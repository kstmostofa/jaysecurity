<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Utility;
use App\Models\PlanRequest;
use App\Models\User;
use File;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('Manage Plan')) {
            $plans                 = Plan::get();

            $admin_payment_setting = Utility::getAdminPaymentSetting();

            return view('plan.index', compact('plans', 'admin_payment_setting'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if (\Auth::user()->can('Create Plan')) {
            $arrDuration = Plan::$arrDuration;

            return view('plan.create', compact('arrDuration'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Plan')) {
            $admin_payment_setting = Utility::getAdminPaymentSetting();
            if (!empty($admin_payment_setting) && ($admin_payment_setting['is_stripe_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_paystack_enabled'] == 'on' || $admin_payment_setting['is_flutterwave_enabled'] == 'on' || $admin_payment_setting['is_razorpay_enabled'] == 'on' || $admin_payment_setting['is_mercado_enabled'] == 'on' || $admin_payment_setting['is_paytm_enabled'] == 'on' || $admin_payment_setting['is_mollie_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_skrill_enabled'] == 'on' || $admin_payment_setting['is_coingate_enabled'] == 'on')) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|unique:plans',
                        'price' => 'required|numeric|min:0',
                        'duration' => 'required',
                        'max_users' => 'required|numeric',
                        'max_employees' => 'required|numeric',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $post = $request->all();

                if (Plan::create($post)) {
                    return redirect()->back()->with('success', __('Plan Successfully created.'));
                } else {
                    return redirect()->back()->with('error', __('Something is wrong.'));
                }
            } else {
                return redirect()->back()->with('error', __('Please set stripe/paypal api key & secret key for add new plan'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function edit($plan_id)
    {
        if (\Auth::user()->can('Edit Plan')) {
            $arrDuration = Plan::$arrDuration;
            $plan        = Plan::find($plan_id);

            return view('plan.edit', compact('plan', 'arrDuration'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, $plan_id)
    {
        if (\Auth::user()->can('Edit Plan')) {
            $admin_payment_setting = Utility::getAdminPaymentSetting();
            if (!empty($admin_payment_setting) &&  ($admin_payment_setting['is_stripe_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_paystack_enabled'] == 'on' || $admin_payment_setting['is_flutterwave_enabled'] == 'on' || $admin_payment_setting['is_razorpay_enabled'] == 'on' || $admin_payment_setting['is_mercado_enabled'] == 'on' || $admin_payment_setting['is_paytm_enabled'] == 'on' || $admin_payment_setting['is_mollie_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_skrill_enabled'] == 'on' || $admin_payment_setting['is_coingate_enabled'] == 'on')) {
                $plan = Plan::find($plan_id);
                if (!empty($plan)) {
                    $validator = \Validator::make(
                        $request->all(),
                        [
                            'name' => 'required|unique:plans,name,' . $plan_id,
                            'duration' => 'required',
                            'max_users' => 'required|numeric',
                            'max_employees' => 'required|numeric',
                        ]
                    );
                    if ($validator->fails()) {
                        $messages = $validator->getMessageBag();

                        return redirect()->back()->with('error', $messages->first());
                    }

                    $post = $request->all();

                    if ($plan->update($post)) {
                        return redirect()->back()->with('success', __('Plan successfully updated.'));
                    } else {
                        return redirect()->back()->with('error', __('Something is wrong.'));
                    }
                } else {
                    return redirect()->back()->with('error', __('Plan not found.'));
                }
            } else {
                return redirect()->back()->with('error', __('Please set stripe/paypal api key & secret key for add new plan'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        $user = \Auth::user();
        $user = User::where('id', '=',  $user->id)->first();
        $user->requested_plan = "0";
        $user->save();

        $plan = Plan::findOrFail($id);
        PlanRequest::where('plan_id', $plan->id)->where('user_id', '=',  $user->id)->delete();

        return redirect()->route('plans.index')->with('success', 'Plan request successfully deleted.');
    }

    public function plan_request($code)
    {
        $objUser = \Auth::user();

        $plan_id = \Illuminate\Support\Facades\Crypt::decrypt($code);
        $plan    = Plan::find($plan_id);

        $plan_request_check_user = PlanRequest::where('user_id', '=', $objUser->id)->first();

        if ($plan_request_check_user) {
            return redirect()->back()->with('error', __('you already request sended for plan.'));
        } else {
            $planRequest = new PlanRequest();
            $planRequest['user_id'] = $objUser->id;
            $planRequest['plan_id'] = $plan->id;
            $planRequest['duration'] = $plan->duration;
            $planRequest->save();

            $objUser['requested_plan'] = $plan->id;
            $objUser->save();

            return redirect()->back()->with('success', __('Plan request successfully sended.'));
        }
    }


    public function userPlan(Request $request)
    {
        if (\Auth::user()->can('Buy Plan')) {
            $objUser = \Auth::user();
            $planID  = \Illuminate\Support\Facades\Crypt::decrypt($request->code);
            $plan    = Plan::find($planID);
            if ($plan) {
                if ($plan->price <= 0) {
                    $objUser->assignPlan($plan->id);

                    return redirect()->route('plans.index')->with('success', __('Plan successfully activated.'));
                } else {
                    return redirect()->back()->with('error', __('Something is wrong.'));
                }
            } else {
                return redirect()->back()->with('error', __('Plan not found.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
