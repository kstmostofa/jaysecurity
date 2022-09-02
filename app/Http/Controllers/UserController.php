<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Invoice;
use App\Mail\UserCreate;
use App\Models\Branch;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use App\Models\Utility;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('Manage User')) {
            $user = \Auth::user();
            if (\Auth::user()->type == 'super admin') {
                $users = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'company')->get();
            } else {
                $users = User::where('created_by', '=', $user->creatorId())->where('type', '!=', 'employee')->get();
            }

            return view('user.index', compact('users'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('Create User')) {
            $user  = \Auth::user();
            $branch = Branch::where('created_by', '=', $user->creatorId())->get()->pluck('name', 'id');;
            $roles = Role::where('created_by', '=', $user->creatorId())->where('name', '!=', 'employee')->get()->pluck('name', 'id');

            return view('user.create', compact('roles', 'branch'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('Create User')) {
            $default_language = DB::table('settings')->select('value')->where('name', 'default_language')->first();
            $validator        = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|unique:users',
                    'password' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            if (\Auth::user()->type == 'super admin') {
                $user = User::create(
                    [
                        'name' => $request['name'],
                        'email' => $request['email'],
                        'password' => Hash::make($request['password']),
                        'type' => 'company',
                        'plan' => $plan = Plan::where('price', '<=', 0)->first()->id,
                        'lang' => !empty($default_language) ? $default_language->value : '',
                        'created_by' => \Auth::user()->id,
                    ]
                );

                $user->assignRole('Company');
                Utility::jobStage($user->id);
                $role_r = Role::findById(2);
            } else {
                $objUser    = \Auth::user();
                $total_user = $objUser->countUsers();
                $plan       = Plan::find($objUser->plan);

                if ($total_user < $plan->max_users || $plan->max_users == -1) {
                    // dd($request->role);
                    $role_r = Role::findById($request->role);
                    // dd($request->hasFile('avatar'));
                    if ($request->hasFile('avatar')) {
                        // dd($role_r);
                        $filenameWithExt = $request->file('avatar')->getClientOriginalName();
                        $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension       = $request->file('avatar')->getClientOriginalExtension();
                        $fileNameToStore = $filename . '.' . $extension;
                        $dir             = storage_path('uploads/avatar/');
                        $image_path      = $dir . $fileNameToStore;
                        // dd($image_path);
                        if (File::exists($image_path)) {
                            File::delete($image_path);
                        }
                        if (!file_exists($dir)) {
                            mkdir($dir, 0777, true);
                        }
                        $path = $request->file('avatar')->storeAs('uploads/avatar/', $fileNameToStore);
                        $user   = User::create(
                            [
                                'name' => $request['name'],
                                'email' => $request['email'],
                                'password' => Hash::make($request['password']),
                                'type' => $role_r->name,
                                'branch_id' => $request['branch'],
                                'avatar' => null,
                                'lang' => !empty($default_language) ? $default_language->value : '',
                                'created_by' => \Auth::user()->id,
                            ]
                        );
                        $user->assignRole($role_r);
                    } else {
                        $user   = User::create(
                            [
                                'name' => $request['name'],
                                'email' => $request['email'],
                                'password' => Hash::make($request['password']),
                                'type' => $role_r->name,
                                'branch_id' => $request['branch'],
                                'avatar' => $request['avatar'],
                                'lang' => !empty($default_language) ? $default_language->value : '',
                                'created_by' => \Auth::user()->id,
                            ]
                        );
                        $user->assignRole($role_r);
                    }
                } else {
                    return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
                }
            }

            $setings = Utility::settings();
            if ($setings['user_create'] == 1) {

                $user->type     = $role_r->name;
                $user->password = $request['password'];
                try {
                    Mail::to($user->email)->send(new UserCreate($user));
                } catch (\Exception $e) {
                    $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                }

                return redirect()->route('user.index')->with('success', __('User successfully created.') . (isset($smtp_error) ? $smtp_error : ''));
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function show(User $user)
    {
        return view('profile.index');
    }

    public function edit($id)
    {
        if (\Auth::user()->can('Edit User')) {
            $user  = User::find($id);
            $roles = Role::where('created_by', '=', $user->creatorId())->where('name', '!=', 'employee')->get()->pluck('name', 'id');

            return view('user.edit', compact('user', 'roles'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'unique:users,email,' . $id,
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        if (\Auth::user()->type == 'super admin') {
            $user  = User::findOrFail($id);
            $input = $request->all();
            $user->fill($input)->save();
        } else {
            $user = User::findOrFail($id);

            $role          = Role::findById($request->role);
            $input         = $request->all();
            $input['type'] = $role->name;
            $user->fill($input)->save();

            $user->assignRole($role);
        }

        return redirect()->route('user.index')->with('success', 'User successfully updated.');
    }


    public function destroy($id)
    {
        if (\Auth::user()->can('Delete User')) {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('user.index')->with('success', 'User successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function profile()
    {
        $userDetail = \Auth::user();

        return view('user.profile')->with('userDetail', $userDetail);
    }

    public function editprofile(Request $request)
    {
        $userDetail = \Auth::user();
        $user       = User::findOrFail($userDetail['id']);

        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required|max:120',
                'email' => 'required|email|unique:users,email,' . $userDetail['id'],
                'profile' => 'image|mimes:jpeg,png,jpg,svg|max:3072',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        if ($request->hasFile('profile')) {
            $filenameWithExt = $request->file('profile')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('profile')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $dir             = storage_path('uploads/avatar/');
            $image_path      = $dir . $userDetail['avatar'];

            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $path = $request->file('profile')->storeAs('uploads/avatar/', $fileNameToStore);
        }

        if (!empty($request->profile)) {
            $user['avatar'] = $fileNameToStore;
        }
        $user['name']  = $request['name'];
        $user['email'] = $request['email'];
        $user->save();

        if (\Auth::user()->type == 'employee') {
            $employee        = Employee::where('user_id', $user->id)->first();
            $employee->email = $request['email'];
            $employee->save();
        }

        return redirect()->back()->with(
            'success',
            'Profile successfully updated.'
        );
    }

    public function updatePassword(Request $request)
    {
        if (\Auth::Check()) {
            $request->validate(
                [
                    'current_password' => 'required',
                    'new_password' => 'required|min:6',
                    'confirm_password' => 'required|same:new_password',
                ]
            );
            $objUser          = Auth::user();
            $request_data     = $request->All();
            $current_password = $objUser->password;
            if (Hash::check($request_data['current_password'], $current_password)) {
                $user_id            = Auth::User()->id;
                $obj_user           = User::find($user_id);
                $obj_user->password = Hash::make($request_data['new_password']);;
                $obj_user->save();

                return redirect()->route('profile', $objUser->id)->with('success', __('Password successfully updated.'));
            } else {
                return redirect()->route('profile', $objUser->id)->with('error', __('Please enter correct current password.'));
            }
        } else {
            return redirect()->route('profile', \Auth::user()->id)->with('error', __('Something is wrong.'));
        }
    }


    public function upgradePlan($user_id)
    {
        $user = User::find($user_id);

        $plans = Plan::get();

        return view('user.plan', compact('user', 'plans'));
    }

    public function activePlan($user_id, $plan_id)
    {

        $user       = User::find($user_id);
        $assignPlan = $user->assignPlan($plan_id);
        $plan       = Plan::find($plan_id);
        if ($assignPlan['is_success'] == true && !empty($plan)) {
            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
            Order::create(
                [
                    'order_id' => $orderID,
                    'name' => null,
                    'card_number' => null,
                    'card_exp_month' => null,
                    'card_exp_year' => null,
                    'plan_name' => $plan->name,
                    'plan_id' => $plan->id,
                    'price' => $plan->price,
                    'price_currency' => !empty(env('CURRENCY')) ? env('CURRENCY') : '$',
                    'txn_id' => '',
                    'payment_status' => 'succeeded',
                    'receipt' => null,
                    'user_id' => $user->id,
                ]
            );

            return redirect()->back()->with('success', 'Plan successfully upgraded.');
        } else {
            return redirect()->back()->with('error', 'Plan fail to upgrade.');
        }
    }

    public function notificationSeen($user_id)
    {
        Notification::where('user_id', '=', $user_id)->update(['is_read' => 1]);

        return response()->json(['is_success' => true], 200);
    }
}
