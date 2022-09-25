<?php

namespace App\Http\Controllers;

use App\Models\User;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use JWTAuth;
use JWTFactory;
use Validator;
use App\Models\Employee_field;
use App\Models\Employee_field_atribute;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Client_company;
use App\Models\Client_company_unit;
use App\Models\Utility;
use App\Models\Document;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use App\Mail\UserCreate;
use App\Models\Employee_field_data;

use App\Models\AttendanceEmployee;
use Carbon\Carbon;

class UserApiController extends Controller
{

    public function __construct()
    {
        $this->auth = Auth::guard('api')->user();
    }

    public function register_user(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name'  => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
                'type'     => 'required',
                'created_by' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return response()->json([
                'message' => $messages
            ]);
        }
    }
    public function login_user(Request $request)
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        $validator = \Validator::make(
            $request->all(),
            [
                'email' => 'required|regex:/^.+@.+$/i',
                'password' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            $error = [
                'error' => $messages
            ];
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' =>  'email or password is incorrect',
                'path' => '/login',
            ];
            return response()->json(
                $res,
                400
            );
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            // return $user;
            $branch_id = $user->branch_id;
            $user_arr = $user->toArray();
            $token = JWTAuth::fromUser($user);
            $data = array(
                'api_token' => $token
            );
            $updated = User::where('email', $request->email)->update($data);
            $user = User::where('email', $request->email)->with(['roles' => function ($query) {
                $query->select('name', 'id');
            }])->with(['branch'])->first();

            $user_arr = $user->toArray();
            if ($updated) {
                array_push($data, $user_arr);
                $res = [
                    'status' => 200,
                    'timestamp' => $current_date_time,
                    'responseMessage' => 'You are login successfully',
                    'path' => '/login',
                    'data' => $data
                ];
                return response()->json(
                    $res,
                    200
                );
            } else {
                $res = [
                    'status' => 403,
                    'timestamp' => $current_date_time,
                    'responseMessage' => 'Some thing want wrong',
                    'path' => '/login',
                ];
                return response()->json(
                    $res,
                    403
                );
            }
        } else {
            $res = [
                'status' => 403,
                'timestamp' => $current_date_time,
                'responseMessage' => 'invaild email and password',
                'path' => '/login',
            ];
            return response()->json(
                $res,
                403
            );
        }
    }
    ///home api
    public function home_api(Request $request)
    {
        $headers = $request->header();
        $Token = $request->header('Token');
        // dd($Token);
        $current_date_time = Carbon::now()->toDateTimeString();
        if ($Token == '') {
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' => 'Token is required',
                'path' => '/profile'
            ];
            return response()->json($res, 400);
        }
        $user = User::where('api_token', $Token)->first();
        if ($user) {
            $user_arr = $user->toArray();
            $data = array(
                'userId' => $user->id,
                'userName' => $user->name
            );
            $res = [
                'status' => 200,
                'timestamp' => $current_date_time,
                'responseMessage' => 'You are login successfully',
                'path' => '/login',
                'data' => $data
            ];
            return response()->json($res, 200);
        } else {
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' =>  'login failed',
                'path' => '/login',
            ];
            return response()->json($res, 400);
        }
    }
    ///end
    public function profile_user(Request $request)
    {
        // $validator = \Validator::make(
        //           $request->all(),
        //           [
        //               'email' => 'required|regex:/^.+@.+$/i',
        //           ]
        //           );
        //   if ($validator->fails()) {
        //           $messages = $validator->getMessageBag();
        //               return response()->json([
        //                'message' => $messages
        //                  ]);
        //           }
        $headers = $request->header();
        $Token = $request->header('Token');
        // dd($Token);
        $current_date_time = Carbon::now()->toDateTimeString();
        if ($Token == '') {
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' => 'Token is required',
                'path' => '/profile'
            ];
            return response()->json($res, 400);
        }
        $user = User::where('email', $request->email)->first();

        $user = User::where('api_token', $Token)->first();

        if ($user) {
            $user_arr = $user->toArray();

            $res = [
                'status' => 200,
                'timestamp' => $current_date_time,
                'responseMessage' => 'You have get data successfully',
                'path' => '/profile',
                'data' => $user_arr
            ];
            return response()->json($res, 200);
        } else {

            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' => 'Email Id not found',
                'path' => '/profile'
            ];
            return response()->json($res, 400);
        }
    }
    public function get_emp_field()
    {
        $res = array();
        $fields = Employee_field::where('status', '=', '1')->get();

        foreach ($fields as $value) {
            $id = $value->id;
            $data['fields']['id'] = $value->id;
            $data['fields']['name'] = $value->field_name;
            $data['fields']['type'] = $value->type;
            $data['fields']['status'] = $value->status;
            $data['fields']['mandatory'] = $value->mandatory;
            $data['fields']['multiple'] = $value->multiple;
            $data['fields']['created_by'] = $value->created_by;
            $data['fields']['fields_atribute'] = array();
            $fields_atribute = Employee_field_atribute::where('field_id', '=', $id)->get();
            foreach ($fields_atribute as $val) {
                $data_['fields_atribute']['id'] = $val->id;
                $data_['fields_atribute']['field_id'] = $val->field_id;
                $data_['fields_atribute']['option_name'] = $val->option_name;
                $data_['fields_atribute']['option_value'] = $val->option_value;
                $data_['fields_atribute']['created_by'] = $val->created_by;
                array_push($data['fields']['fields_atribute'], $data_['fields_atribute']);
            }
            array_push($res, $data);
            $data = array();
        }
        // print_r($res);
        $result = [
            'responseCode' => 1,
            'data' => $res,
        ];
        return response()->json($result);
    }
    function employeeNumber($created_by)
    {
        $latest = Employee::where('created_by', '=', $created_by)->latest()->first();
        if (!$latest) {
            return 1;
        }

        return $latest->id + 1;
    }
    public function add_employee(Request $request)
    {
        // dd($request);
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'dob' => 'required',
                'gender' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
                'department_id' => 'required',
                'designation_id' => 'required',
                'document.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc,zip|max:20480',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return response()->json([
                'message' => $messages
            ]);
        }
        ///////validation
        $error_msg = array();
        $fields = Employee_field::where('status', '=', '1')->get();

        foreach ($fields as  $value) {
            $field_id = $value->id;
            $field_name = $value->field_name;
            $mandatory = $value->mandatory;
            $c = 0;
            for ($i = 0; $i < count($request->fields); $i++) {
                $id_ = $request->fields[$i]['id'];
                if ($field_id == $id_) {
                    $c = 1;

                    if ($mandatory == 1) {
                        $type = $request->fields[$i]['type'];
                        if ($type == 'file') {
                            $validate_2 = array(
                                'field_value'  => $request->fields[$i]['value'],
                            );
                            $validate_ = \Validator::make($validate_2, [
                                'field_value'  => 'required|mimes:pdf,png,jpg,jpeg',
                            ]);
                        } elseif ($type == 'text') {
                            $validate_2 = array(
                                'field_value'  => $request->fields[$i]['value'],
                            );
                            $validate_ = \Validator::make($validate_2, [
                                'field_value'  => 'required',
                            ]);
                        } elseif ($type == 'date') {
                            $validate_2 = array(
                                'field_value'  => $request->fields[$i]['value'],
                            );
                            $validate_ = \Validator::make($validate_2, [
                                'field_value'  => 'required|date',
                            ]);
                        } elseif ($type == 'number') {
                            $validate_2 = array(
                                'field_value'  => $request->fields[$i]['value'],
                            );
                            $validate_ = \Validator::make($validate_2, [
                                'field_value'  => 'required|numeric',
                            ]);
                        }
                    }
                    if ($validator->fails()) {
                        $messages = $validator->getMessageBag();
                        return response()->json([
                            'message' => $messages
                        ]);
                    }
                }
            }
            if ($c == 0) {
                if ($mandatory == 1) {
                    array_push($error_msg, $field_name . ' is required');
                }
            }
        }
        if (count($error_msg)) {
            return response()->json([
                'message' => $error_msg
            ]);
        }

        ///////end
        for ($i = 0; $i < count($request->fields); $i++) {
            // print_r($request->fields);
            $validate_1 = array(
                'field_id' => $request->fields[$i]['id'],
                'field_type' => $request->fields[$i]['type'],
            );
            $type = $request->fields[$i]['type'];
            if ($type == 'file') {
                $validate_2 = array(
                    'field_value'  => $request->fields[$i]['value'],
                );
                $validate_ = \Validator::make($validate_2, [
                    'field_value'  => 'required|mimes:pdf,png,jpg,jpeg',
                ]);
                // print_r($validate_2);
            } elseif ($type == 'text') {
                $validate_2 = array(
                    'field_value'  => $request->fields[$i]['value'],
                );
                $validate_ = \Validator::make($validate_2, [
                    'field_value'  => 'required',
                ]);
            } elseif ($type == 'date') {
                $validate_2 = array(
                    'field_value'  => $request->fields[$i]['value'],
                );
                $validate_ = \Validator::make($validate_2, [
                    'field_value'  => 'required|date',
                ]);
            } elseif ($type == 'number') {
                $validate_2 = array(
                    'field_value'  => $request->fields[$i]['value'],
                );
                $validate_ = \Validator::make($validate_2, [
                    'field_value'  => 'required|numeric',
                ]);
            }
        }
        if ($validate_->fails()) {
            $messages = $validate_->getMessageBag();
            return response()->json([
                'message' => $messages
            ]);
        }
        $data_user = array(
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'type' => 'employee',
            'lang' => 'en',
            'created_by' => $request['created_by'],
        );
        $user_query = User::insert($data_user);
        $user_id = DB::getPdo()->lastInsertId();

        if (!empty($request->document) && !is_null($request->document)) {
            $document_implode = implode(',', array_keys($request->document));
        } else {
            $document_implode = null;
        }

        $employee = Employee::create(
            [
                'user_id' => $user_id,
                'name' => $request['name'],
                'dob' => $request['dob'],
                'gender' => $request['gender'],
                'phone' => $request['phone'],
                'address' => $request['address'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'employee_id' => $this->employeeNumber($request->created_by),
                'branch_id' => $request['branch_id'],
                'department_id' => $request['department_id'],
                'designation_id' => $request['designation_id'],
                'company_doj' => $request['company_doj'],
                'documents' => $document_implode,
                'account_holder_name' => $request['account_holder_name'],
                'account_number' => $request['account_number'],
                'bank_name' => $request['bank_name'],
                'bank_identifier_code' => $request['bank_identifier_code'],
                'branch_location' => $request['branch_location'],
                'tax_payer_id' => $request['tax_payer_id'],
                'created_by' => $request['created_by'],
            ]
        );

        for ($i = 0; $i < count($request->fields); $i++) {
            if ($request->fields[$i]['type'] == 'file') {
                $file = $request->file("fields")[$i]['value'];

                $input['file'] = rand() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path() . "/uploads/";

                $extension = $request->file("fields")[$i]['value']->extension();
                $name = $input['file'];
                $image = $request->file("fields")[$i]['value'];
                $image->move($destinationPath, $name);

                $data_field = array(
                    'field_id' => $request->fields[$i]['id'],
                    'field_value' => $input['file'],
                    'emp_id' =>  $user_id,
                    'created_by' => $request->created_by
                );
            } else {
                $data_field = array(
                    'field_id' => $request->fields[$i]['id'],
                    'field_value' => $request->fields[$i]['value'],
                    'emp_id' =>  $user_id,
                    'created_by' => $request->created_by
                );
            }
            // print_r($data_field);
            $field_query = Employee_field_data::insert($data_field);
        }
        ////
        if ($request->hasFile('document')) {
            foreach ($request->document as $key => $document) {

                $filenameWithExt = $request->file('document')[$key]->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('document')[$key]->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $dir             = storage_path('uploads/document/');
                $image_path      = $dir . $filenameWithExt;

                if (File::exists($image_path)) {
                    File::delete($image_path);
                }

                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $path              = $request->file('document')[$key]->storeAs('uploads/document/', $fileNameToStore);
                $employee_document = EmployeeDocument::create(
                    [
                        'employee_id' => $employee['employee_id'],
                        'document_id' => $key,
                        'document_value' => $fileNameToStore,
                        'created_by' => $request->created_by,
                    ]
                );
                $employee_document->save();
            }
        }
        ///
        // $setings = Utility::settings();
        //  if ($setings['employee_create'] == 1) {
        //      $user->type     = 'Employee';
        //      $user->password = $request['password'];
        //      try {
        //          Mail::to($user->email)->send(new UserCreate($user));
        //      } catch (\Exception $e) {
        //          $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
        //      }

        //      return redirect()->route('employee.index')->with('success', __('Employee successfully created.') . (isset($smtp_error) ? $smtp_error : ''));
        //  }
        $res = [
            'responseCode' => 1,
            'message' => 'Employee  successfully created.',
        ];
        return response()->json($res);
        ////
    }


    public function get_all_branch()
    {
        $res = array();
        $branches = Branch::get();
        foreach ($branches as  $value) {
            array_push($res, $value);
        }

        $current_date_time = Carbon::now()->toDateTimeString();
        $res = [
            'status' => 200,
            'timestamp' => $current_date_time,
            'responseMessage' => 'You get data successfully',
            'path' => '/list_of_branchs',
            'data' => $res
        ];
        return response()->json($res, 200);
    }

    public function edit_branch(Request $request, Branch $branch)
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        if (\Auth::user()->can('Edit Branch')) {

            if ($branch->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return response()->json(['message' => $messages]);
                }

                $branch->name = $request->name;
                $branch->save();


                $res = [
                    'status' => 200,
                    'timestamp' => $current_date_time,
                    'responseMessage' =>  $branch,
                    'path' => '/edit-branch',
                ];
                return response()->json(
                    $res,
                    200
                );
            } else {
                $res = [
                    'status' => 400,
                    'timestamp' => $current_date_time,
                    'responseMessage' =>  'Permission denied.',
                    'path' => '/edit-branch',
                ];
                return response()->json(
                    $res,
                    400
                );
            }
        } else {
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' =>  'Permission denied.',
                'path' => '/edit-branch',
            ];
            return response()->json(
                $res,
                400
            );
        }
    }
    public function get_all_department()
    {
        $res = array();
        $data = array();
        $Department = Department::get();
        foreach ($Department as  $value) {

            $data['department_data'] = $value;
            $branch_id = $value->branch_id;
            $branches = Branch::where('id', $branch_id)->first();
            $data['department_data']['branch_data'] = $branches;
            array_push($res, $data);
        }
        $result = [
            'responseCode' => 1,
            'data' => $res,
        ];
        return response()->json($result);
    }
    public function get_all_designation()
    {
        $res = array();
        $designations = Designation::get();
        foreach ($designations as  $value) {
            array_push($res, $value);
        }
        $result = [
            'responseCode' => 1,
            'data' => $res,
        ];
        return response()->json($result);
    }


    public function get_department_by_id(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'id'  => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return response()->json(['message' => $messages]);
        }
        $id = $request->id;
        $designation = Department::where('id', $id)->first();
        $result = [
            'responseCode' => 1,
            'data' => $designation,
        ];
        return response()->json($result);
    }
    public function get_client_company()
    {
        $res = array();
        $companies = Client_company::get();
        foreach ($companies as  $value) {
            array_push($res, $value);
        }
        $result = [
            'responseCode' => 1,
            'data' => $res,
        ];
        return response()->json($result);
    }

    public function edit_client_company(Request $request, Client_company $company)
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        if (\Auth::user()->can('Edit Company')) {

            if ($company->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                        'branch_id' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return response()->json(['message' => $messages]);
                }

                $company->name = $request->name;
                $company->branch_id = $request->branch_id;
                $company->save();


                $res = [
                    'status' => 200,
                    'timestamp' => $current_date_time,
                    'responseMessage' =>  $company,
                    'path' => '/edit_client_company',
                ];
                return response()->json(
                    $res,
                    200
                );
            } else {
                $res = [
                    'status' => 400,
                    'timestamp' => $current_date_time,
                    'responseMessage' =>  'Permission denied.',
                    'path' => '/edit_client_company',
                ];
                return response()->json(
                    $res,
                    400
                );
            }
        } else {
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' =>  'Permission denied.',
                'path' => '/edit_client_company',
            ];
            return response()->json(
                $res,
                400
            );
        }
    }
    public function get_client_company_with_unit()
    {
        $res = array();
        $unit = array();
        $companies = Client_company::get();
        foreach ($companies as  $value) {
            $company_unit = Client_company_unit::where('company_id', $value->id)->get();
            // print_r($company_unit);
            $data['company_id'] = $value->id;
            $data['company_name'] = $value->name;
            $branch_id = $value->branch_id;
            $branch_data = Branch::where('id', $branch_id)->first();
            $data['company_city'] = $branch_data->name;
            $unit = array();
            $unit_ = array();
            foreach ($company_unit as  $val) {
                $unit['unit_id'] = $val->id;
                $unit['unit_name'] = $val->name;
                $unit['total_strength'] = Null;
                $unit['total_present'] = Null;
                // $data['company_unit_data']=$unit;
                array_push($unit_, $unit);
                // $data['company_unit_data']['total_strength']=Null;
                // $data['company_unit_data']['total_present']=Null;
            }
            $data['company_unit_data'] = $unit_;
            array_push($res, $data);
        }
        $current_date_time = Carbon::now()->toDateTimeString();
        $res = [
            'status' => 200,
            'timestamp' => $current_date_time,
            'responseMessage' => 'You get data successfully',
            'path' => '/list_of_companies_with_unit',
            'data' => $res
        ];
        return response()->json($res, 200);
    }

    public function get_client_company_unit()
    {
        $res = array();
        $companies_unit = Client_company_unit::get();

        foreach ($companies_unit as  $value) {
            $company_id = $value->company_id;
            $company = Client_company::where('id', $company_id)->first();
            $data['company_id'] = $company->id;
            $data['company_name'] = $company->name;
            $data['branch_name'] = $company->getBranch->name;
            $data['company_unit_id'] = $value->id;
            $data['company_unit_name'] = $value->name;
            $data['total_strength'] = Null;
            $data['total_present'] = Null;
            array_push($res, $data);
        }
        $current_date_time = Carbon::now()->toDateTimeString();
        $ress = [
            'status' => 200,
            'timestamp' => $current_date_time,
            'responseMessage' => 'You get data successfully',
            'path' => '/list_of_company_unit',
            'data' => $res
        ];
        return response()->json($ress, 200);
    }
    public function edit_client_company_unit(Request $request, Client_company_unit $company_unit)
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        if (\Auth::user()->can('Edit Company Unit')) {

            if ($company_unit->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                        'company_id' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return response()->json(['message' => $messages]);
                }

                $company_unit->name = $request->name;
                if ($request->company_id) {
                    $company_unit->company_id = $request->company_id;
                }
                $company_unit->save();
                return response()->json(
                    [
                        'status' => 200,
                        'timestamp' => $current_date_time,
                        'responseMessage' =>  $company_unit,
                        'path' => '/edit_client_company_unit',
                    ],
                    200
                );
            } else {
                $res = [
                    'status' => 400,
                    'timestamp' => $current_date_time,
                    'responseMessage' =>  'Permission denied.',
                    'path' => '/edit_client_company_unit',
                ];
                return response()->json(
                    $res,
                    400
                );
            }
        }
    }

    public function get_company_by_id(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'id'  => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return response()->json(['message' => $messages]);
        }
        $id = $request->id;
        $designation = Client_company::where('id', $id)->first();
        $result = [
            'responseCode' => 1,
            'data' => $designation,
        ];
        return response()->json($result);
    }
    public function get_company_by_branch_id(Request $request)
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        $validator = \Validator::make(
            $request->all(),
            [
                'branch_id'  => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            // return response()->json(['message' => $messages]);
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' =>  'branch_id is required',
                'path' => '/add_emp',
            ];
            return response()->json(
                $res,
                400
            );
        }
        $branch_id = $request->branch_id;
        $branch_data = Branch::where('id', $branch_id)->first();
        if ($branch_data) {

            $companies = Client_company::where('branch_id', $branch_id)->get();

            $res = [
                'status' => 200,
                'timestamp' => $current_date_time,
                'responseMessage' => 'You get data successfully',
                'path' => '/add_emp',
                'data' => $companies
            ];
            return response()->json($res, 200);
        } else {
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' =>  'branch_id is invaild',
                'path' => '/add_emp',
            ];
            return response()->json(
                $res,
                400
            );
        }
    }
    public function get_company_unit_by_company_id(Request $request)
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        $validator = \Validator::make(
            $request->all(),
            [
                'company_id'  => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            // return response()->json(['message' => $messages]);
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' =>  'company_id is required',
                'path' => '/add_emp',
            ];
            return response()->json(
                $res,
                400
            );
        }
        $company_id = $request->company_id;
        $company_data = Client_company::where('id', $company_id)->first();
        if ($company_data) {
            $companies_unit = Client_company_unit::where('company_id', $company_id)->get();

            $res = [
                'status' => 200,
                'timestamp' => $current_date_time,
                'responseMessage' => 'You get data successfully',
                'path' => '/add_emp',
                'data' => $companies_unit
            ];
            return response()->json($res, 200);
        } else {
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' =>  'company_id is invaild',
                'path' => '/add_emp',
            ];
            return response()->json(
                $res,
                400
            );
        }
    }
    public function get_emp_field_2()
    {
        $res = array();
        $fields = Employee_field::where('status', '=', '1')
            ->orderBy('priority')
            ->get();

        foreach ($fields as $value) {
            $id = $value->id;
            $data['fields']['id'] = $value->id;
            $data['fields']['name'] = $value->field_name;
            $data['fields']['type'] = $value->type;
            // $data['fields']['status']=$value->status;
            if ($value->mandatory == 1) {
                $mandatory = true;
            } else {
                $mandatory = false;
            }
            $data['fields']['mandatory'] = $mandatory;
            $data['fields']['value'] = '';
            $data['fields']['multiple'] = $value->multiple;
            $data['fields']['created_by'] = $value->created_by;
            $data['fields']['fields_atribute'] = array();
            $fields_atribute = Employee_field_atribute::where('field_id', '=', $id)->get();
            foreach ($fields_atribute as $val) {
                $data_['fields_atribute']['id'] = $val->id;
                $data_['fields_atribute']['field_id'] = $val->field_id;
                $data_['fields_atribute']['option_name'] = $val->option_name;
                $data_['fields_atribute']['option_value'] = $val->option_value;
                $data_['fields_atribute']['created_by'] = $val->created_by;
                array_push($data['fields']['fields_atribute'], $data_['fields_atribute']);
            }
            array_push($res, $data);
            $data = array();
        }
        $current_date_time = Carbon::now()->toDateTimeString();
        $res = [
            'status' => 200,
            'timestamp' => $current_date_time,
            'responseMessage' => 'You get data successfully',
            'path' => '/add_emp',
            'data' => $res
        ];
        return response()->json($res, 200);
    }
    public function add_employee_static(Request $request)
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'dob' => 'required',
                'aadhar_card_no' => 'required|unique:employees|numeric',
                'gender' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
                // 'department_id' => 'required',
                // 'designation_id' => 'required',
                'branch_id' => 'required',
                'company_id' => 'required',
                'company_unit_id' => 'required',
                'created_by' => 'required',
                // 'document.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc,zip|max:20480',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            // return response()->json([
            //          'message' => $messages
            //            ]);
            // $error=[
            //          'error' => $messages
            //            ];
            // print_r($messages);
            $array =  (array) $messages;
            // print_r($array);die;
            $err = array();
            foreach ($array as $value) {
                if (is_array($value)) {
                    foreach ($value as $key => $val) {
                        // print_r($val);
                        $error['errorText'] = $val;
                        $error['fieldId'] = $key;
                        array_push($err, $error);
                    }
                }
            }
            // print_r($err);
            // die;
            $data['error'] = $err;
            $res = [
                'status' => 200,
                'timestamp' => $current_date_time,
                'responseMessage' => "error",
                'data' => $data,
                'path' => '/add_emp',
            ];
            return response()->json(
                $res,
                200
            );
        }
        $data_user = array(
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'type' => 'employee',
            'lang' => 'en',
            'created_by' => $request['created_by'],
        );
        $user_query = User::insert($data_user);
        $user_id = DB::getPdo()->lastInsertId();

        if (!empty($request->document) && !is_null($request->document)) {
            $document_implode = implode(',', array_keys($request->document));
        } else {
            $document_implode = null;
        }

        $employee = Employee::create(
            [
                'user_id' => $user_id,
                'name' => $request['name'],
                'aadhar_card_no' => $request['aadhar_card_no'],
                'dob' => $request['dob'],
                'gender' => $request['gender'],
                'phone' => $request['phone'],
                'address' => $request['address'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'employee_id' => $this->employeeNumber($request->created_by),
                'branch_id' => $request['branch_id'],
                'department_id' => $request['department_id'],
                'designation_id' => $request['designation_id'],
                'company_doj' => $request['company_doj'],
                'documents' => $document_implode,
                'account_holder_name' => $request['account_holder_name'],
                'account_number' => $request['account_number'],
                'bank_name' => $request['bank_name'],
                'bank_identifier_code' => $request['bank_identifier_code'],
                // 'branch_location' => $request['branch_location'],
                // 'tax_payer_id' => $request['tax_payer_id'],
                'created_by' => $request['created_by'],
            ]
        );
        ///documents
        if ($request->hasFile('document')) {
            foreach ($request->document as $key => $document) {

                $filenameWithExt = $request->file('document')[$key]->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('document')[$key]->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $dir             = storage_path('uploads/document/');
                $image_path      = $dir . $filenameWithExt;

                if (File::exists($image_path)) {
                    File::delete($image_path);
                }

                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $path              = $request->file('document')[$key]->storeAs('uploads/document/', $fileNameToStore);
                $employee_document = EmployeeDocument::create(
                    [
                        'employee_id' => $employee['employee_id'],
                        'document_id' => $key,
                        'document_value' => $fileNameToStore,
                        'created_by' => $request->created_by,
                    ]
                );
                $employee_document->save();
            }
        }
        ///end
        $res = [
            'status' => 200,
            'timestamp' => $current_date_time,
            'responseMessage' => 'Employee  successfully created.',
            'path' => '/add_emp',
            'emp_id' => $employee['employee_id']
        ];
        return response()->json($res, 200);
    }
    public function token_check(Request $request)
    {

        $headers = $request->header();
        $Token = $request->header('Token');
        // dd($Token);
        $current_date_time = Carbon::now()->toDateTimeString();
        if ($Token == '') {
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' => 'Token is required',
                'path' => '/profile'
            ];
            return response()->json($res, 400);
        }

        $user = User::where('api_token', $Token)->first();

        if ($user) {
            $user_arr = $user->toArray();
            $data['userexist'] = true;
            $res = [
                'status' => 200,
                'timestamp' => $current_date_time,
                'responseMessage' => 'You have get data successfully',
                'path' => '/token_check',
                'data' => $data
            ];
            return response()->json($res, 200);
        } else {
            $data['userexist'] = false;
            $res = [
                'status' => 200,
                'timestamp' => $current_date_time,
                'responseMessage' => 'You have get data successfully',
                'path' => '/token_check',
                'data' => $data
            ];
            return response()->json($res, 200);
        }
    }
    public function aadhar_check(Request $request)
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        $validator = \Validator::make(
            $request->all(),
            [
                'aadhar_card_no'  => 'required|numeric|digits:12',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' =>  'aadhar_card_no is required or 12 digits',
                'path' => '/add_emp',
            ];
            return response()->json(
                $res,
                400
            );
        }

        // $data=Employee::where('aadhar_card_no',$request->aadhar_card_no)->first();
        $employee = Employee::where('aadhar_card_no', $request->aadhar_card_no)->first();
        if ($employee) {
            $employeesId  = \Auth::user()->employeeIdFormat($employee->employee_id);
            $emp_field_data  = Employee_field_data::where('emp_id', $employee->user_id)->get();
            $fields = Employee_field::where('status', '=', '1')->get();

            $dynamic_data = array();
            $all_dynamic_data = array();
            foreach ($emp_field_data as $field_data) {
                foreach ($fields as  $field) {
                    if ($field_data->field_id == $field->id) {
                        $dynamic_data['field_id'] = $field->id;
                        $dynamic_data['field_name'] = $field->field_name;
                        $dynamic_data['field_type'] = $field->type;
                        $dynamic_data['field_value'] = $field_data->field_value;
                        array_push($all_dynamic_data, $dynamic_data);
                    }
                }
            }
            // print_r($all_dynamic_data);
            $res['static_emp_data'] = $employee;
            $res['dynamice_emp_data'] = $all_dynamic_data;
            $res['employeesId'] = $employeesId;
            // die;
        }
        if ($employee) {
            // $user_arr=$data->toArray();
            $data['userexist'] = true;
            $data['emp_data'] = $res;
            $res = [
                'status' => 200,
                'timestamp' => $current_date_time,
                'responseMessage' => 'You have get data successfully',
                'path' => '/add_emp',
                'data' => $data
            ];
            return response()->json($res, 200);
        } else {
            $data['userexist'] = false;
            $res = [
                'status' => 200,
                'timestamp' => $current_date_time,
                'responseMessage' => 'You have get data successfully',
                'path' => '/add_emp',
                'data' => $data
            ];
            return response()->json($res, 200);
        }
    }

    public function add_employee_new(Request $request)
    {
        // dd($request->fields);
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'dob' => 'required',
                'gender' => 'required',
                'role_id' => 'required',
                // 'email' => 'unique:users',
                'aadhar_card_no' => 'required|numeric|digits:12|unique:employees',
                'branch_id' => 'required',
                // 'company_id' => 'required',
                // 'company_unit_id' => 'required',
                'created_by' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return response()->json([
                'message' => $messages
            ]);
        }
        ///////validation
        //  return($request->fields);
        $error_msg = array();
        $fields = Employee_field::where('status', '=', '1')->get();
        // return $fields;
        // echo count($request->fields);die;
        foreach ($fields as  $value) {
            $field_id = $value->id;
            $field_name = $value->field_name;
            $mandatory = $value->mandatory;
            $c = 0;
            for ($i = 0; $i < count($request->fields); $i++) {
                $id_ = $request->fields[$i]['id'];
                if ($field_id == $id_) {
                    $c = 1;

                    if ($mandatory == 1) {
                        $type = $request->fields[$i]['type'];
                        if ($type == 'file') {
                            $validate_2 = array(
                                'field_value'  => $request->fields[$i]['value'],
                            );
                            $validate_ = \Validator::make($validate_2, [
                                'field_value'  => 'required|mimes:pdf,png,jpg,jpeg',
                            ]);
                        } elseif ($type == 'text') {
                            $validate_2 = array(
                                'field_value'  => $request->fields[$i]['value'],
                            );
                            $validate_ = \Validator::make($validate_2, [
                                'field_value'  => 'required',
                            ]);
                        } elseif ($type == 'date') {
                            $validate_2 = array(
                                'field_value'  => $request->fields[$i]['value'],
                            );
                            $validate_ = \Validator::make($validate_2, [
                                'field_value'  => 'required|date',
                            ]);
                        } elseif ($type == 'number') {
                            $validate_2 = array(
                                'field_value'  => $request->fields[$i]['value'],
                            );
                            $validate_ = \Validator::make($validate_2, [
                                'field_value'  => 'required|numeric',
                            ]);
                        }
                    }
                    if ($validator->fails()) {
                        $messages = $validator->getMessageBag();
                        return response()->json([
                            'message' => $messages
                        ]);
                    }
                }
            }
            if ($c == 0) {
                if ($mandatory == 1) {
                    array_push($error_msg, $field_name . ' is required');
                }
            }
        }
        if (count($error_msg)) {
            return response()->json([
                'message' => $error_msg
            ]);
        }

        ///////end
        for ($i = 0; $i < count($request->fields); $i++) {
            // print_r($request->fields);
            $validate_1 = array(
                'field_id' => $request->fields[$i]['id'],
                'field_type' => $request->fields[$i]['type'],
            );
            $type = $request->fields[$i]['type'];
            $name = $request->fields[$i]['name'];
            if ($type == 'file') {
                $validate_2 = array(
                    $name  => $request->fields[$i]['value'],
                );
                $validate_ = \Validator::make($validate_2, [
                    $name  => 'required|mimes:pdf,png,jpg,jpeg',
                ]);
                // print_r($validate_2);
            } elseif ($type == 'text') {
                $validate_2 = array(
                    $name  => $request->fields[$i]['value'],
                );
                $validate_ = \Validator::make($validate_2, [
                    $name  => 'required',
                ]);
            } elseif ($type == 'date') {
                $validate_2 = array(
                    $name  => $request->fields[$i]['value'],
                );
                $validate_ = \Validator::make($validate_2, [
                    $name => 'required|date',
                ]);
            } elseif ($type == 'number') {
                $validate_2 = array(
                    $name  => $request->fields[$i]['value'],
                );
                $validate_ = \Validator::make($validate_2, [
                    $name => 'required|numeric',
                ]);
            }
        }
        if ($validate_->fails()) {
            $messages = $validate_->getMessageBag();
            return response()->json([
                'message' => $messages
            ]);
        }
        ////email and pwd
        $random_no = rand(100, 10000);
        if ($request['email'] == '' or empty($request['email'])) {
            $email = 'emp' . $random_no . '@jaysecurity.in';
        } else {
            $email = $request['email'];
        }
        /////end
        $data_user = array(
            'name' => $request['name'],
            'email' => $email,
            // 'password' => Hash::make($request['password']),
            'password' => Hash::make($random_no),
            'type' => 'employee',
            'lang' => 'en',
            'created_by' => $request['created_by'],
        );
        $user_query = User::insert($data_user);
        $user_id = DB::getPdo()->lastInsertId();

        if (!empty($request->document) && !is_null($request->document)) {
            $document_implode = implode(',', array_keys($request->document));
        } else {
            $document_implode = null;
        }

        $employee = Employee::create(

            [
                'user_id' => $user_id,
                'name' => $request['name'],
                'aadhar_card_no' => $request['aadhar_card_no'],
                'dob' => $request['dob'],
                'gender' => $request['gender'],
                'phone' => $request['phone'],
                'address' => $request['address'],
                'email' => $email,
                'random_no' => $random_no,
                'role_id' => $request['role_id'],
                'password' => Hash::make($random_no),
                'employee_id' => $this->employeeNumber($request->created_by),
                'branch_id' => $request['branch_id'],
                'company_client_id' => $request['company_client_id'],
                'company_client_unit_id' => $request['company_client_unit_id'],
                'department_id' => $request['department_id'],
                'designation_id' => $request['designation_id'],
                'company_doj' => $request['company_doj'],
                'documents' => $document_implode,
                'account_holder_name' => $request['account_holder_name'],
                'account_number' => $request['account_number'],
                'bank_name' => $request['bank_name'],
                'bank_identifier_code' => $request['bank_identifier_code'],
                'created_by' => $request['created_by'],
            ]
        );

        for ($i = 0; $i < count($request->fields); $i++) {
            if ($request->fields[$i]['type'] == 'file') {
                $file = $request->file("fields")[$i]['value'];

                $input['file'] = rand() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path() . "/uploads/";

                $extension = $request->file("fields")[$i]['value']->extension();
                $name = $input['file'];
                $image = $request->file("fields")[$i]['value'];
                $image->move($destinationPath, $name);

                $data_field = array(
                    'field_id' => $request->fields[$i]['id'],
                    'field_value' => $input['file'],
                    'emp_id' =>  $user_id,
                    'created_by' => $request->created_by
                );
            } else {
                $data_field = array(
                    'field_id' => $request->fields[$i]['id'],
                    'field_value' => $request->fields[$i]['value'],
                    'emp_id' =>  $user_id,
                    'created_by' => $request->created_by
                );
            }
            // print_r($data_field);
            $field_query = Employee_field_data::insert($data_field);
        }
        ////
        if ($request->hasFile('document')) {
            foreach ($request->document as $key => $document) {

                $filenameWithExt = $request->file('document')[$key]->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('document')[$key]->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $dir             = storage_path('uploads/document/');
                $image_path      = $dir . $filenameWithExt;

                if (File::exists($image_path)) {
                    File::delete($image_path);
                }

                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $path              = $request->file('document')[$key]->storeAs('uploads/document/', $fileNameToStore);
                $employee_document = EmployeeDocument::create(
                    [
                        'employee_id' => $employee['employee_id'],
                        'document_id' => $key,
                        'document_value' => $fileNameToStore,
                        'created_by' => $request->created_by,
                    ]
                );
                $employee_document->save();
            }
        }

        $res = [
            'responseCode' => 1,
            'message' => 'Employee  successfully created.',
        ];
        return response()->json($res);
        ////
    }
    public function get_all_emp_company_unit(Request $request)
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        $validator = \Validator::make(
            $request->all(),
            [
                'company_unit_id'  => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            // return response()->json(['message' => $messages]);
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' =>  'company_unit_id is required',
                'path' => '/list_emp',
            ];
            return response()->json(
                $res,
                400
            );
        }
        $company_unit_id = $request->company_unit_id;
        $company_unit_data = Client_company_unit::where('id', $company_unit_id)->first();
        if ($company_unit_data) {
            $emp_data = Employee::where('company_client_unit_id', $company_unit_id)->get();

            $fields = Employee_field::where('status', '=', '1')->get();
            $dynamic_data = array();
            $all_dynamic_data = array();
            $final_list = array();
            $emp_list = array();
            if ($emp_data) {
                ///////////
                foreach ($emp_data as $employee) {
                    $employeesId  = \Auth::user()->employeeIdFormat($employee->employee_id);
                    $emp_field_data  = Employee_field_data::where('emp_id', $employee->user_id)->get();
                    foreach ($emp_field_data as $field_data) {
                        foreach ($fields as  $field) {
                            if ($field_data->field_id == $field->id) {
                                $dynamic_data['field_id'] = $field->id;
                                $dynamic_data['field_name'] = $field->field_name;
                                $dynamic_data['field_type'] = $field->type;
                                $dynamic_data['field_value'] = $field_data->field_value;
                                array_push($all_dynamic_data, $dynamic_data);
                            }
                        }
                    }
                    $emp_list['static_emp_data'] = $employee;
                    $emp_list['dynamice_emp_data'] = $all_dynamic_data;
                    $emp_list['employeesId'] = $employeesId;
                    array_push($final_list, $emp_list);
                }
                ////////////
            }
            $res = [
                'status' => 200,
                'timestamp' => $current_date_time,
                'bbbb' => $company_unit_data,
                'responseMessage' => 'You get all data successfully',
                'path' => '/list_emp',
                'data' => $final_list
            ];
            return response()->json($res, 200);
        } else {
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' =>  'company_id is invaild',
                'path' => '/list_emp',
            ];
            return response()->json(
                $res,
                400
            );
        }
    }
    public function bulkAttendance(Request $request)
    {
        $current_date = Carbon::now()->toDateString();

        $current_date_time = Carbon::now()->toDateTimeString();
        $validator = \Validator::make(
            $request->all(),
            [
                'date'  => 'required|date_format:Y-m-d|before_or_equal:' . $current_date,
                'employee_id' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' =>  $messages,
                'path' => '/list_emp',
            ];
            return response()->json(
                $res,
                400
            );
        }

        $startTime = Utility::getValByName('company_start_time');
        $endTime   = Utility::getValByName('company_end_time');
        $date      = $request->date;

        $employees = $request->employee_id;
        $atte      = [];
        /////
        foreach ($employees as $employee) {
            $present = 'present-' . $employee;
            $in      = 'in-' . $employee;
            $out     = 'out-' . $employee;
            $atte[]  = $present;
            if ($request->$present == 'on') {

                $in  = date("H:i:s", strtotime($request->$in));
                $out = date("H:i:s", strtotime($request->$out));

                $totalLateSeconds = strtotime($in) - strtotime($startTime);

                $hours = floor($totalLateSeconds / 3600);
                $mins  = floor($totalLateSeconds / 60 % 60);
                $secs  = floor($totalLateSeconds % 60);
                $late  = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

                //early Leaving
                $totalEarlyLeavingSeconds = strtotime($endTime) - strtotime($out);
                $hours                    = floor($totalEarlyLeavingSeconds / 3600);
                $mins                     = floor($totalEarlyLeavingSeconds / 60 % 60);
                $secs                     = floor($totalEarlyLeavingSeconds % 60);
                $earlyLeaving             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);


                if (strtotime($out) > strtotime($endTime)) {
                    //Overtime
                    $totalOvertimeSeconds = strtotime($out) - strtotime($endTime);
                    $hours                = floor($totalOvertimeSeconds / 3600);
                    $mins                 = floor($totalOvertimeSeconds / 60 % 60);
                    $secs                 = floor($totalOvertimeSeconds % 60);
                    $overtime             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                } else {
                    $overtime = '00:00:00';
                }


                $attendance = AttendanceEmployee::where('employee_id', '=', $employee)->where('date', '=', $request->date)->first();

                if (!empty($attendance)) {
                    $employeeAttendance = $attendance;
                } else {
                    $employeeAttendance              = new AttendanceEmployee();
                    $employeeAttendance->employee_id = $employee;
                    $employeeAttendance->created_by  = \Auth::user()->creatorId();
                }


                $employeeAttendance->date          = $request->date;
                $employeeAttendance->status        = 'Present';
                $employeeAttendance->clock_in      = $in;
                $employeeAttendance->clock_out     = $out;
                $employeeAttendance->late          = $late;
                $employeeAttendance->early_leaving = ($earlyLeaving > 0) ? $earlyLeaving : '00:00:00';
                $employeeAttendance->overtime      = $overtime;
                $employeeAttendance->total_rest    = '00:00:00';
                $employeeAttendance->save();
            } else {
                $attendance = AttendanceEmployee::where('employee_id', '=', $employee)->where('date', '=', $request->date)->first();

                if (!empty($attendance)) {
                    $employeeAttendance = $attendance;
                } else {
                    $employeeAttendance              = new AttendanceEmployee();
                    $employeeAttendance->employee_id = $employee;
                    $employeeAttendance->created_by  = \Auth::user()->creatorId();
                }

                $employeeAttendance->status        = 'Leave';
                $employeeAttendance->date          = $request->date;
                $employeeAttendance->clock_in      = '00:00:00';
                $employeeAttendance->clock_out     = '00:00:00';
                $employeeAttendance->late          = '00:00:00';
                $employeeAttendance->early_leaving = '00:00:00';
                $employeeAttendance->overtime      = '00:00:00';
                $employeeAttendance->total_rest    = '00:00:00';
                $employeeAttendance->save();
            }
        }

        /////
        $res = [
            'status' => 200,
            'timestamp' => $current_date_time,
            'responseMessage' =>  'Employee attendance successfully created.',
            'path' => '/attendance_emp',
        ];
        return response()->json(
            $res,
            200
        );
    }

    public function bulkAttendance_2(Request $request)
    {
        // dd($request);
        $current_date = Carbon::now()->toDateString();

        $current_date_time = Carbon::now()->toDateTimeString();
        $validator = \Validator::make(
            $request->all(),
            [
                'date'  => 'required|date_format:Y-m-d|before_or_equal:' . $current_date,
                'attendance' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' =>  $messages,
                'path' => '/list_emp',
            ];
            return response()->json(
                $res,
                400
            );
        }

        $startTime = Utility::getValByName('company_start_time');
        $endTime   = Utility::getValByName('company_end_time');
        $date      = $request->date;

        $attendance = $request->attendance;
        $atte      = [];
        // dd($attendance);
        /////
        foreach ($attendance as $employee) {

            $employeeId = $employee['employeeId'];
            $present = $employee['present'];
            $in      = $employee['in'];
            $out     = $employee['out'];
            $atte[]  = $present;

            if ($present) {

                $in  = date("H:i:s", strtotime($in));
                $out = date("H:i:s", strtotime($out));

                $totalLateSeconds = strtotime($in) - strtotime($startTime);

                $hours = floor($totalLateSeconds / 3600);
                $mins  = floor($totalLateSeconds / 60 % 60);
                $secs  = floor($totalLateSeconds % 60);
                $late  = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

                //early Leaving
                $totalEarlyLeavingSeconds = strtotime($endTime) - strtotime($out);
                $hours                    = floor($totalEarlyLeavingSeconds / 3600);
                $mins                     = floor($totalEarlyLeavingSeconds / 60 % 60);
                $secs                     = floor($totalEarlyLeavingSeconds % 60);
                $earlyLeaving             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);


                if (strtotime($out) > strtotime($endTime)) {
                    //Overtime
                    $totalOvertimeSeconds = strtotime($out) - strtotime($endTime);
                    $hours                = floor($totalOvertimeSeconds / 3600);
                    $mins                 = floor($totalOvertimeSeconds / 60 % 60);
                    $secs                 = floor($totalOvertimeSeconds % 60);
                    $overtime             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                } else {
                    $overtime = '00:00:00';
                }


                $attendance = AttendanceEmployee::where('employee_id', '=', $employeeId)->where('date', '=', $request->date)->first();

                if (!empty($attendance)) {
                    $employeeAttendance = $attendance;
                } else {
                    $employeeAttendance              = new AttendanceEmployee();
                    $employeeAttendance->employee_id = $employeeId;
                    $employeeAttendance->created_by  = \Auth::user()->creatorId();
                }


                $employeeAttendance->date          = $request->date;
                $employeeAttendance->status        = 'Present';
                $employeeAttendance->clock_in      = $in;
                $employeeAttendance->clock_out     = $out;
                $employeeAttendance->late          = $late;
                $employeeAttendance->early_leaving = ($earlyLeaving > 0) ? $earlyLeaving : '00:00:00';
                $employeeAttendance->overtime      = $overtime;
                $employeeAttendance->total_rest    = '00:00:00';
                $employeeAttendance->save();
            } else {
                $attendance = AttendanceEmployee::where('employee_id', '=', $employeeId)->where('date', '=', $request->date)->first();

                if (!empty($attendance)) {
                    $employeeAttendance = $attendance;
                } else {
                    $employeeAttendance              = new AttendanceEmployee();
                    $employeeAttendance->employee_id = $employeeId;
                    $employeeAttendance->created_by  = \Auth::user()->creatorId();
                }

                $employeeAttendance->status        = 'Leave';
                $employeeAttendance->date          = $request->date;
                $employeeAttendance->clock_in      = '00:00:00';
                $employeeAttendance->clock_out     = '00:00:00';
                $employeeAttendance->late          = '00:00:00';
                $employeeAttendance->early_leaving = '00:00:00';
                $employeeAttendance->overtime      = '00:00:00';
                $employeeAttendance->total_rest    = '00:00:00';
                $employeeAttendance->save();
            }
        }
        /////
        $res = [
            'status' => 200,
            'timestamp' => $current_date_time,
            'responseMessage' =>  'Employee attendance successfully created.',
            'path' => '/attendance_emp',
        ];
        return response()->json(
            $res,
            200
        );
    }

    //Started By Mostofa
    //Get All Area rounder
    public function get_all_area_rounder()
    {
        $res = array();
        $current_date_time = Carbon::now()->toDateTimeString();
        $creator_id = $this->auth->id;
        $area_rounders = User::where('type', 'Area officer')->where('created_by', $creator_id)
            ->with(['roles' => function ($query) {
                $query->select('name', 'id');
            }])->get();
        foreach ($area_rounders as $value) {
            // return $value;
            $branch_id = $value->branch_id;
            // $company = User::where('branch_id', $branch_id)->first();
            $data['branch_name'] = $value->branch->name;
            array_push($res, $data);
        }
        array_push($res, $area_rounders);
        $ress = [
            'status' => 200,
            'timestamp' => $current_date_time,
            'avatar_base_url' => "https://" . $_SERVER['HTTP_HOST'] . "/storage/avatar/",
            'responseMessage' =>  $area_rounders,
            'path' => '/get_all_area_rounder',

        ];
        return response()->json(
            $ress,
            200
        );

        //add not authorized message to response

    }

    public function create_area_rounder(Request $request)
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        $validator = \Validator::make(
            $request->all(),
            [
                'name'  => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
                'role'     => 'required',
                'branch' => 'required',
                'avatar' => 'required|mimes:png,jpg,jpeg|max:2048',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return response()->json([
                'message' => $messages
            ]);
        }
        //return($request->role);
        $role_r = Role::find($request->role);

        //return $role_r;

        if ($request->hasFile('avatar')) {
            $filenameWithExt = $request->file('avatar')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('avatar')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $dir             = storage_path('uploads/avatar/');
            $image_path      = $dir . $fileNameToStore;
            // return ($fileNameToStore);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $path = $request->file('avatar')->storeAs('uploads/avatar/', $fileNameToStore);
        }
        // return $fileNameToStore;
        $user   = User::create(
            [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'type' => $role_r->name,
                'branch_id' => $request['branch'],
                'avatar' => $fileNameToStore,
                'lang' => !empty($default_language) ? $default_language->value : '',
                'created_by' => $this->auth->id,
            ]
        );
        $user->assignRole($role_r);


        $res = [
            'status' => 200,
            'timestamp' => $current_date_time,
            'responseMessage' =>  $user,
            'path' => '/create_area_rounder',
        ];
        return response()->json(
            $res,
            200
        );
    }

    public function edit_area_rounder(Request $request)
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        $validator = \Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'role_id' => 'required',
                'branch_id' => 'required',
                'name' => 'required',
                'email' => 'unique:users,email,' . $request->id,

            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return response()->json([
                'message' => $messages
            ]);
        }

        if ($this->auth->type == 'super admin') {
            $user  = User::findOrFail($request->id);

            $input = $request->all();

            $user->fill($input)->save();
        } else {
            if ($request->hasFile('avatar')) {
                $filenameWithExt = $request->file('avatar')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('avatar')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $dir             = storage_path('uploads/avatar/');
                $image_path      = $dir . $fileNameToStore;
                // return ($fileNameToStore);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $path = $request->file('avatar')->storeAs('uploads/avatar/', $fileNameToStore);
                $user = User::findOrFail($request->id);
                $role          = Role::find($request->role_id);
                $input         = $request->all();
                $input['type'] = $role->name;
                $input['avatar'] = $fileNameToStore;
                $user->fill($input)->save();
                $user->assignRole($role);
            } else {
                $user = User::findOrFail($request->id);
                $role          = Role::find($request->role_id);
                $input         = $request->all();
                $input['type'] = $role->name;
                // return $input;
                $user->fill($input)->save();
                $user->assignRole($role);
            }
        }

        $res = [
            'status' => 200,
            'timestamp' => $current_date_time,
            'responseMessage' =>  $user,
            'path' => '/edit_area_rounder',
        ];
        return response()->json(
            $res,
            200
        );
    }

    public function edit_employee(Request $request)

    {
        if (\Auth::user()->can('Edit Employee')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'aadhar_card_no' => 'required|numeric',
                    'dob' => 'required',
                    'gender' => 'required',
                    'phone' => 'required|numeric',
                    'address' => 'required',
                    'document.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc,zip|max:20480',
                    'company_client_id' => 'required',
                    'company_client_unit_id' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return response()->json([
                    'message' => $messages
                ]);
            }

            ///////////////new code///////////////////////////
            $c = 0;
            $c_ = 0;
            for ($i = 0; $i < $request->field_count; $i++) {

                $validate_1 = array(
                    'field_id' => $request->fields['id'][$i],
                    'field_name'  => $request->fields['name'][$i],
                    'field_type' => $request->fields['type'][$i],
                    'field_mandatory'  => $request->fields['mandatory'][$i],

                );

                $validate_1 = \Validator::make($validate_1, [
                    'field_id'    => 'required|numeric',
                    'field_name'  => 'required',
                    'field_type'  => 'required',
                    'field_mandatory' => 'required|numeric',
                ]);

                if ($validate_1->fails()) {
                    $validate_msg = $validate_1->getMessageBag();
                    $validate_msg = 'Some thing went wrong';
                    return redirect()->back()->withInput()->with('error', $validate_msg);
                }
                if ($request->fields['mandatory'][$i] == '1') {
                    if ($request->fields['type'][$i] == 'file') {
                        ///image data
                        if ($request->file('files_' . $c)) {
                            $validate_ = array(
                                $request->fields['name'][$i]  => $request->file('files_' . $c),
                            );

                            $validate_ = \Validator::make($validate_, [
                                $request->fields['name'][$i]   => 'required|mimes:pdf,png,jpg,jpeg',
                            ]);
                            if ($validate_->fails()) {
                                $validate_msg = $validate_->getMessageBag();
                                return redirect()->back()->withInput()->with('error', $validate_msg);
                            }
                        } else {
                            if ($request->fields['value_old'][$c] == '') {
                                $validate_msg = $request->fields['name'][$i] . "  filed required";
                                return redirect()->back()->withInput()->with('error', $validate_msg);
                            }
                        }

                        $c++;
                        ///end
                    } else if ($request->fields['type'][$i] == 'number') {
                        $validate_ = array(
                            $request->fields['name'][$i]  => $request->fields['value_' . $request->fields['id'][$i]],
                        );

                        $validate_ = \Validator::make($validate_, [
                            $request->fields['name'][$i]   => 'required|numeric',
                        ]);
                        if ($validate_->fails()) {
                            $validate_msg = $validate_->getMessageBag();
                            return redirect()->back()->withInput()->with('error', $validate_msg);
                        }
                        // $c_++;
                    } else if ($request->fields['type'][$i] == 'date') {
                        $validate_ = array(
                            $request->fields['name'][$i]  => $request->fields['value_' . $request->fields['id'][$i]],
                        );

                        $validate_ = \Validator::make($validate_, [
                            $request->fields['name'][$i]   => 'required|date',
                        ]);
                        if ($validate_->fails()) {
                            $validate_msg = $validate_->getMessageBag();
                            return redirect()->back()->withInput()->with('error', $validate_msg);
                        }
                        $c_++;
                    } else {
                        $validate_ = array(
                            $request->fields['name'][$i]  => $request->fields['value_' . $request->fields['id'][$i]],
                        );

                        $validate_ = \Validator::make($validate_, [
                            $request->fields['name'][$i]   => 'required',
                        ]);
                        if ($validate_->fails()) {
                            $validate_msg = $validate_->getMessageBag();
                            return redirect()->back()->withInput()->with('error', $validate_msg);
                        }
                        $c_++;
                    }
                }
            }

            ////////////////End/////////////////////////
            $employee = Employee::findOrFail($id);
            ////////////extra field//////////////////////////
            $count_field = count($request->fields['type']); //die;
            $count_file = 0;
            $count_other = 0;


            for ($i = 0; $i < $request->field_count; $i++) {

                if ($request->fields['type'][$i] == 'file') {
                    // dd($request->file("fields"));

                    if ($request->file('files_' . $count_file)) {

                        // $file = $request->file("fields")['value'][$count_file];
                        $file = $request->file('files_' . $count_file);

                        $input['file'] = rand() . '.' . $file->getClientOriginalExtension();
                        // dd($input['file']);
                        $destinationPath = public_path() . "/uploads/";

                        $extension = $request->file('files_' . $count_file)->extension();
                        $name = $input['file'];
                        $image = $request->file('files_' . $count_file);
                        $image->move($destinationPath, $name);
                        $count_file++;
                        $data_field = array(
                            'field_id' => $request->fields['id'][$i],
                            'field_value' => $input['file'],
                            'emp_id' =>  $employee->user_id,
                            'created_by' => \Auth::user()->creatorId()
                        );
                    } else {
                        $input['file'] = $request->fields['value_old'][$count_file];
                        $count_file++;
                        $data_field = array(
                            'field_id' => $request->fields['id'][$i],
                            'field_value' => $input['file'],
                            'emp_id' =>  $employee->user_id,
                            'created_by' => \Auth::user()->creatorId()
                        );
                    }
                } else {
                    if (isset($request->fields['value_' . $request->fields['id'][$i]])) {
                        $data_field = array(
                            'field_id'   => $request->fields['id'][$i],
                            'field_value' => $request->fields['value_' . $request->fields['id'][$i]],
                            'emp_id'     =>  $employee->user_id,
                            'created_by' => \Auth::user()->creatorId()
                        );
                        $count_other++;
                    }
                }

                $fields_id_ = 'fields_' . $request->fields['id'][$i];

                if ($request->$fields_id_ == '0') {
                    $field_query = Employee_field_data::insert($data_field);
                } else {

                    // $field_query =Employee_field_data::where('id',$fields_.$request->fields['id'][$i])->update($data_field);
                    $field_query = Employee_field_data::where('id', $request->$fields_id_)->update($data_field);
                    // dd($field_query);
                }
                // echo "<pre>";
                // print_r($data_field);
            } //dd();
            //////////////end//////////////////////////


            if ($request->document) {

                foreach ($request->document as $key => $document) {
                    if (!empty($document)) {
                        $filenameWithExt = $request->file('document')[$key]->getClientOriginalName();
                        $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension       = $request->file('document')[$key]->getClientOriginalExtension();
                        $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                        $dir        = storage_path('uploads/document/');
                        $image_path = $dir . $filenameWithExt;

                        if (File::exists($image_path)) {
                            File::delete($image_path);
                        }
                        if (!file_exists($dir)) {
                            mkdir($dir, 0777, true);
                        }
                        $path = $request->file('document')[$key]->storeAs('uploads/document/', $fileNameToStore);


                        $employee_document = EmployeeDocument::where('employee_id', $employee->employee_id)->where('document_id', $key)->first();

                        if (!empty($employee_document)) {
                            $employee_document->document_value = $fileNameToStore;
                            $employee_document->save();
                        } else {
                            $employee_document                 = new EmployeeDocument();
                            $employee_document->employee_id    = $employee->employee_id;
                            $employee_document->document_id    = $key;
                            $employee_document->document_value = $fileNameToStore;
                            $employee_document->save();
                        }
                    }
                }
            }

            $employee = Employee::findOrFail($id);
            $input    = $request->all();
            $employee->fill($input)->save();
            if ($request->salary) {
                return redirect()->route('setsalary.index')->with('success', 'Employee successfully updated.');
            }

            if (\Auth::user()->type != 'employee') {
                return redirect()->route('employee.index')->with('success', 'Employee successfully updated.');
            } else {
                return redirect()->route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id))->with('success', 'Employee successfully updated.');
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function user_status(Request $request, $id)
    {

        $current_date_time = Carbon::now()->toDateTimeString();

        $validator = \Validator::make(
            $request->all(),
            [
                'status' => 'required',

            ]
        );
        //  return $request->all();
        $user = User::findOrFail($id);

        $user->status = $request->status;
        $user->note = $request->note;
        $user->save();

        $user_details = ($user);



        $employee = Employee::where('user_id', $id)->first();

        $employee->status = $request->status;
        $employee->note = $request->note;
        $employee->save();
        $user_arr = $user->toArray();
        array_push($user_arr, $employee);
        $res = [
            'status' => 200,
            'timestamp' => $current_date_time,
            'responseMessage' =>  $user_arr,
            'path' => '/edit_area_rounder',
        ];
        return response()->json(
            $res,
            200
        );
    }

    //transfer area rounder to another company unit
    public function transfer_area_rounder(Request $request, $id)
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        $validator = \Validator::make(
            $request->all(),
            [
                'branch_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return response()->json([
                'message' => $messages
            ]);
        }
        $user = User::findOrFail($id);
        $user->branch_id = $request->branch_id;
        $user->save();
        $user_arr = $user->toArray();
        $res = [
            'status' => 200,
            'timestamp' => $current_date_time,
            'responseMessage' =>  'Area Rounder Transfered Successfully',
            'path' => '/transfer_area_rounder',
            'data' => $user_arr
        ];
        return response()->json(
            $res,
            200
        );
    }
}
