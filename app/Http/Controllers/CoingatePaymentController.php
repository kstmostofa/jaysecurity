<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Plan;
use App\Models\UserCoupon;
use App\Models\Utility;
use CoinGate\CoinGate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoingatePaymentController extends Controller
{
    //


    public $mode;
    public $coingate_auth_token;
    public $is_enabled;

    public function paymentConfig()
    {
        if(\Auth::user()->type == 'company')
        {
            $admin_payment_setting     = Utility::getAdminPaymentSetting();
            $this->coingate_auth_token = isset($admin_payment_setting['coingate_auth_token']) ? $admin_payment_setting['coingate_auth_token'] : '';
            $this->mode                = isset($admin_payment_setting['coingate_mode']) ? $admin_payment_setting['coingate_mode'] : 'off';
            $this->is_enabled          = isset($admin_payment_setting['is_coingate_enabled']) ? $admin_payment_setting['is_coingate_enabled'] : 'off';

            return $this;
        }
    }


    public function planPayWithCoingate(Request $request)
    {
        $payment    = $this->paymentConfig();
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
                            'payment_type' => 'coingate',
                            'payment_status' => 'succeeded',
                            'receipt' => null,
                            'user_id' => $authuser->id,
                        ]
                    );
                    $assignPlan = $authuser->assignPlan($plan->id);

                    return redirect()->route('plans.index')->with('success', __('Plan activated Successfully!'));
                }
                else
                {
                    return redirect()->back()->with('error', __('Plan fail to upgrade.'));
                }
            }
            CoinGate::config(
                array(
                    'environment' => $payment->mode,
                    'auth_token' => $payment->coingate_auth_token,
                    'curlopt_ssl_verifypeer' => FALSE,
                )
            );
            $post_params = array(
                'order_id' => time(),
                'price_amount' => $price,
                'price_currency' => env('CURRENCY'),
                'receive_currency' => env('CURRENCY'),
                'callback_url' => route(
                    'plan.coingate', [
                                       $request->plan_id,
                                       'coupon_id=' . $coupons_id,
                                   ]
                ),
                'cancel_url' => route('stripe', [$request->plan_id]),
                'success_url' => route(
                    'plan.coingate', [
                                       $request->plan_id,
                                       'coupon_id=' . $coupons_id,
                                   ]
                ),
                'title' => 'Plan #' . time(),
            );

            $order = \CoinGate\Merchant\Order::create($post_params);
            if($order)
            {
                return redirect($order->payment_url);
            }
            else
            {
                return redirect()->back()->with('error', __('opps something wren wrong.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', 'Plan is deleted.');
        }

    }

    public function coingatePlanGetPayment(Request $request)
    {
        $user                  = Auth::user();
        $plan_id               = $request->plan_id;
        $store_id              = Auth::user()->current_store;
        $admin_payment_setting = Utility::getAdminPaymentSetting();
        $plan                  = Plan::find($plan_id);
        $price = $plan->price;
        if($plan)
        {
            try
            {
                $orderID = time();
                if($request->has('coupon_id') && $request->coupon_id != '')
                {
                    $coupons = Coupon::find($request->coupon_id);
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
                }
                $order                 = new Order();
                $order->order_id       = $orderID;
                $order->name           = $user->name;
                $order->card_number    = '';
                $order->card_exp_month = '';
                $order->card_exp_year  = '';
                $order->plan_name      = $plan->name;
                $order->plan_id        = $plan->id;
                $order->price          = $price;
                $order->price_currency = env('CURRENCY_CODE');
                $order->txn_id         = isset($request->transaction_id) ? $request->transaction_id : '';
                $order->payment_type   = __('Coingate');
                $order->payment_status = 'success';
                $order->receipt        = '';
                $order->user_id        = $user->id;
                $order->save();

                $assignPlan = $user->assignPlan($plan->id);
                if($assignPlan['is_success'])
                {
                    return redirect()->route('plans.index')->with('success', __('Plan activated Successfully.'));
                }
                else
                {
                    return redirect()->route('plans.index')->with('error', $assignPlan['error']);
                }
            }
            catch(\Exception $e)
            {
                return redirect()->route('plans.index')->with('error', __('Transaction has been failed.'));
            }
        }
        else
        {
            return redirect()->route('plans.index')->with('error', __('Plan is deleted.'));
        }
    }


}
