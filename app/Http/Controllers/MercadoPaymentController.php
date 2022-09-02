<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use LivePixel\MercadoPago\MP;

class MercadoPaymentController extends Controller
{
    public $secret_key;
    public $app_id;
    public $is_enabled;


    public function paymentConfig()
    {
        if(\Auth::user()->type == 'company')
        {
            $admin_payment_setting = Utility::getAdminPaymentSetting();
            $this->secret_key      = isset($admin_payment_setting['mercado_secret_key']) ? $admin_payment_setting['mercado_secret_key'] : '';
            $this->app_id          = isset($admin_payment_setting['mercado_app_id']) ? $admin_payment_setting['mercado_app_id'] : '';
            $this->is_enabled      = isset($admin_payment_setting['is_mercado_enabled']) ? $admin_payment_setting['is_mercado_enabled'] : 'off';

            return $this;
        }
    }

    public function planPayWithMercado(Request $request)
    {

        $payment = $this->paymentConfig();

        $planID     = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan       = Plan::find($planID);
        $authuser   = Auth::user();
        $coupons_id = '';
        if($plan)
        {
            $price = $plan->price;
            if(isset($request->coupon) && !empty($request->coupon))
            {
                $request->coupon = trim($request->coupon);
                $coupons         = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                if(!empty($coupons))
                {
                    $usedCoupun             = $coupons->used_coupon();
                    $discount_value         = ($price / 100) * $coupons->discount;
                    $plan->discounted_price = $price - $discount_value;
                    $coupons_id             = $coupons->id;
                    if($usedCoupun >= $coupons->limit)
                    {
                        return redirect()->back()->with('error', __('This coupon code has expired.'));
                    }
                    $price = $price - $discount_value;
                }
                else
                {
                    return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
                }
            }

            if($price <= 0)
            {
                $authuser->plan = $plan->id;
                $authuser->save();

                $assignPlan = $authuser->assignPlan($plan->id);

                if($assignPlan['is_success'] == true && !empty($plan))
                {

                    $orderID = time();
                    Order::create(
                        [
                            'order_id' => $orderID,
                            'name' => null,
                            'email' => null,
                            'card_number' => null,
                            'card_exp_month' => null,
                            'card_exp_year' => null,
                            'plan_name' => $plan->name,
                            'plan_id' => $plan->id,
                            'price' => $price == null ? 0 : $price,
                            'price_currency' => !empty(env('CURRENCY')) ? env('CURRENCY') : 'USD',
                            'txn_id' => '',
                            'payment_type' => 'Mercado',
                            'payment_status' => 'succeeded',
                            'receipt' => null,
                            'user_id' => $authuser->id,
                        ]
                    );
                    $res['msg']  = __("Plan successfully upgraded.");
                    $res['flag'] = 2;

                    return $res;
                }
                else
                {
                    return Utility::error_res(__('Plan fail to upgrade.'));
                }
            }

            $preference_data = array(
                "items" => array(
                    array(
                        "title" => "Plan : " . $plan->name,
                        "quantity" => 1,
                        "currency_id" => env('CURRENCY'),
                        "unit_price" => (float)$price,
                    ),
                ),
            );

            try
            {
                $mp         = new MP($payment->app_id, $payment->secret_key);
                $preference = $mp->create_preference($preference_data);

                return redirect($preference['response']['init_point']);
            }
            catch(Exception $e)
            {
                return redirect()->back()->with('error', $e->getMessage());
            }
            // callback url :  domain.com/plan/mercado

        }
        else
        {
            return redirect()->back()->with('error', 'Plan is deleted.');
        }

    }

    public function getPaymentStatus(Request $request)
    {
        Log::info(json_encode($request->all()));
    }
}
