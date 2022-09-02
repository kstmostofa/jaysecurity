<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Plan;
use App\Models\PlanRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type == 'super admin') {
            $plan_requests = PlanRequest::all();

            return view('plan_request.index', compact('plan_requests'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function update($id)
    {
        $planRequest = PlanRequest::findOrFail($id);
        $user_id = $planRequest->user->id;

        $user       = User::find($user_id);
        $assignPlan = $user->assignPlan($planRequest->plan_id);

        $planRequest->delete();

        return redirect()->route('plan_requests.index')->with('success', 'Plan request successfully activated.');
    }

    public function destroy($id)
    {
        $planRequest = PlanRequest::findOrFail($id);

        $user = \Auth::user();
        $user = User::where('id', '=', $planRequest->user_id)->first();
        $user->requested_plan = "0";
        $user->save();

        $planRequest->delete();

        return redirect()->route('plan_requests.index')->with('success', 'Plan request successfully deleted.');
    }
}
