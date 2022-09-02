<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Document;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use App\Mail\UserCreate;
use App\Models\Plan;
use App\Models\User;
use App\Models\Utility;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\Imports\EmployeesImport;
use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Employee_field;
use App\Models\Employee_field_atribute;
//use Faker\Provider\File;
use App\Models\Employee_field_data;
use Image;
use App\Models\Client_company;
use App\Models\Client_company_unit;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (\Auth::user()->can('Manage Employee')) {
            if (Auth::user()->type == 'employee') {
                $employees = Employee::where('user_id', '=', Auth::user()->id)->get();
            } else {
                // $employees = Employee::where('created_by', \Auth::user()->creatorId())->get();
                $employees = Employee::get();
            }

            return view('employee.index', compact('employees'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('Create Employee')) {
            $company_settings = Utility::settings();
            $documents        = Document::where('created_by', \Auth::user()->creatorId())->get();
            $branches         = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            $departments      = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $company_client   = Client_company::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            $company_client_unit  = Client_company_unit::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            // echo "<pre>";print_r($company_client_unit);die;
            $designations     = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employees        = User::where('created_by', \Auth::user()->creatorId())->get();
            $employeesId      = \Auth::user()->employeeIdFormat($this->employeeNumber());
            $fields = Employee_field::where('status', '=', '1')->
                // where('created_by', '=', \Auth::user()->creatorId())->
                get();
            $fields_atribute = Employee_field_atribute::get();
            return view('employee.create', compact('employees', 'employeesId', 'departments', 'designations', 'documents', 'branches', 'company_settings', 'fields', 'fields_atribute', 'company_client', 'company_client_unit'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    { //dd($request->company_client_unit_id);
        if (\Auth::user()->can('Create Employee')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'dob' => 'required',
                    'gender' => 'required',
                    'aadhar_card_no' => 'required|unique:employees|numeric',
                    'phone' => 'required',
                    'address' => 'required',
                    'email' => 'required|unique:users',
                    'password' => 'required',
                    'department_id' => 'required',
                    'designation_id' => 'required',
                    'document.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc,zip|max:20480',
                    'company_client_id'    => 'required',
                    'company_client_unit_id' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->withInput()->with('error', $messages->first());
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

                    if ($request->fields['type'][$i] == 'number') {
                        $validate_2 = array(
                            'field_value'  => $request->fields['value_' . $request->fields['id'][$i]],
                        );
                        $validate_ = \Validator::make($validate_2, [
                            'field_value'  => 'required|numeric',
                        ]);
                        // $c_++;
                    }
                    if ($request->fields['type'][$i] == 'date') {
                        $validate_2 = array(
                            'field_value'  => $request->fields['value_' . $request->fields['id'][$i]],
                        );
                        $validate_ = \Validator::make($validate_2, [
                            'field_value'  => 'required|date',
                        ]);
                        // $c_++;
                    }
                    if ($request->fields['type'][$i] == 'file') {
                        if (isset($request->file("fields")['value'][$c])) {
                            $fils = $request->file("fields")['value'][$c];
                            if (!$fils) {
                                // echo "string";die;
                                $str_error = $request->fields['name'][$i] . 'field is required';
                                return redirect()->back()->withInput()->with('error', $str_error);
                            } else {
                                $validate_2 = array(
                                    'field_value'  => $request->fields['value'][$c],
                                );
                                $validate_ = \Validator::make($validate_2, [
                                    'field_value'  => 'required|mimes:pdf,png,jpg,jpeg',
                                ]);
                            }
                            $c++;
                        }
                    } else {
                        $validate_2 = array(
                            'field_value'  => $request->fields['value_' . $request->fields['id'][$i]],
                        );
                        $validate_ = \Validator::make($validate_2, [
                            'field_value'  => 'required',
                        ]);
                        // $c_++;
                    }
                    if (isset($validate_)) {

                        if ($validate_->fails()) {
                            $validate_2_msg = $validate_->getMessageBag();
                            return redirect()->back()->withInput()->with('error', $validate_2_msg);
                        }
                    }
                }
            }

            ////////////////End/////////////////////////
            $objUser        = User::find(\Auth::user()->creatorId());
            $total_employee = $objUser->countEmployees();
            $plan           = Plan::find($objUser->plan);

            // if ($total_employee < $plan->max_employees || $plan->max_employees == -1) {

            $user = User::create(
                [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                    'type' => 'employee',
                    'lang' => 'en',
                    'created_by' => \Auth::user()->creatorId(),
                ]
            );
            $user->save();
            $user->assignRole('Employee');
            // } else {
            //     return redirect()->back()->with('error', __('Your employee limit is over, Please upgrade plan.'));
            // }


            if (!empty($request->document) && !is_null($request->document)) {
                $document_implode = implode(',', array_keys($request->document));
            } else {
                $document_implode = null;
            }

            // dd($request);
            $employee = Employee::create(
                [
                    'user_id' => $user->id,
                    'name' => $request['name'],
                    'aadhar_card_no' => $request['aadhar_card_no'],
                    'dob' => $request['dob'],
                    'gender' => $request['gender'],
                    'phone' => $request['phone'],
                    'address' => $request['address'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                    'employee_id' => $this->employeeNumber(),
                    'branch_id' => $request['branch_id'],
                    'department_id' => $request['department_id'],
                    'designation_id' => $request['designation_id'],
                    'company_client_id' => $request['company_client_id'],
                    'company_client_unit_id' => $request['company_client_unit_id'],
                    'company_doj' => $request['company_doj'],
                    'documents' => $document_implode,
                    'account_holder_name' => $request['account_holder_name'],
                    'account_number' => $request['account_number'],
                    'bank_name' => $request['bank_name'],
                    'bank_identifier_code' => $request['bank_identifier_code'],
                    'branch_location' => $request['branch_location'],
                    'tax_payer_id' => $request['tax_payer_id'],
                    'created_by' => \Auth::user()->creatorId(),
                ]
            );
            ////////////extra field//////////////////////////
            $count_field = count($request->fields['type']); //die;
            $count_file = 0;
            $count_other = 0;
            for ($i = 0; $i < $request->field_count; $i++) {

                if ($request->fields['type'][$i] == 'file') {
                    if (isset($request->file("fields")['value'][$count_file])) {

                        $file = $request->file("fields")['value'][$count_file];

                        $input['file'] = rand() . '.' . $file->getClientOriginalExtension();
                        $destinationPath = public_path() . "/uploads/";

                        $extension = $request->file("fields")['value'][$count_file]->extension();
                        $name = $input['file'];
                        $image = $request->file("fields")['value'][$count_file];
                        $image->move($destinationPath, $name);
                        $count_file;
                        $count_file++;
                        $data_field = array(
                            'field_id' => $request->fields['id'][$i],
                            'field_value' => $input['file'],
                            'emp_id' =>  $user->id,
                            'created_by' => \Auth::user()->creatorId()
                        );
                    }
                } else {
                    if (isset($request->fields['value_' . $request->fields['id'][$i]])) {
                        $data_field = array(
                            'field_id' => $request->fields['id'][$i],
                            // 'field_value'=>$request->fields['value_'][$count_other],
                            'field_value' => $request->fields['value_' . $request->fields['id'][$i]],
                            'emp_id' =>  $user->id,
                            'created_by' => \Auth::user()->creatorId()
                        );
                        $count_other++;
                    }
                }
                // echo "<pre>";print_r($data_field);
                if (isset($data_field)) {
                    $field_query = Employee_field_data::insert($data_field);
                }
            } //dd();
            //////////////end//////////////////////////
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
                            'created_by' => \Auth::user()->creatorId(),
                        ]
                    );
                    $employee_document->save();
                }
            }

            $setings = Utility::settings();
            if ($setings['employee_create'] == 1) {
                $user->type     = 'Employee';
                $user->password = $request['password'];
                try {
                    Mail::to($user->email)->send(new UserCreate($user));
                } catch (\Exception $e) {
                    $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                }

                return redirect()->route('employee.index')->with('success', __('Employee successfully created.') . (isset($smtp_error) ? $smtp_error : ''));
            }

            return redirect()->route('employee.index')->with('success', __('Employee  successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        if (\Auth::user()->can('Edit Employee')) {
            $documents    = Document::where('created_by', \Auth::user()->creatorId())->get();
            $branches     = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments  = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $company_client   = Client_company::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            $company_client_unit  = Client_company_unit::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employee     = Employee::find($id);
            $employeesId  = \Auth::user()->employeeIdFormat($employee->employee_id);

            $emp_field_data  = Employee_field_data::where('emp_id', $employee->user_id)->get();
            $fields = Employee_field::where('status', '=', '1')->get();
            $fields_atribute = Employee_field_atribute::get();
            return view('employee.edit', compact('employee', 'employeesId', 'branches', 'departments', 'designations', 'documents', 'fields', 'fields_atribute', 'emp_field_data', 'company_client'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request);
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

                return redirect()->back()->with('error', $messages->first());
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

    public function destroy($id)
    {
        if (Auth::user()->can('Delete Employee')) {
            $employee      = Employee::findOrFail($id);
            $user          = User::where('id', '=', $employee->user_id)->first();

            $emp_documents = EmployeeDocument::where('employee_id', $employee->employee_id)->get();

            $emp_field = Employee_field_data::where('emp_id', $user->id)->get();

            $dir = storage_path('uploads/');
            if ($emp_field) {
                foreach ($emp_field as $emp_field_data) {
                    // dd($emp_field_data->field_id);
                    $field = Employee_field::where('id', $emp_field_data->field_id)->get();
                    // if ($field->type=='file') {
                    //     // $emp_field_data->delete();
                    //     if (!empty($emp_field_data->field_value)) {
                    //         unlink($dir . $emp_field_data->field_value);
                    //     }
                    // }
                    $emp_field_data->delete();
                }
            }
            $employee->delete();
            $user->delete();
            $dir = storage_path('uploads/document/');

            foreach ($emp_documents as $emp_document) {
                $emp_document->delete();
                if (!empty($emp_document->document_value)) {
                    unlink($dir . $emp_document->document_value);
                }
            }


            return redirect()->route('employee.index')->with('success', 'Employee successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show($id)
    {

        if (\Auth::user()->can('Show Employee')) {
            $empId        = Crypt::decrypt($id);
            $documents    = Document::where('created_by', \Auth::user()->creatorId())->get();
            $branches     = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments  = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employee     = Employee::find($empId);
            $employeesId  = \Auth::user()->employeeIdFormat($employee->employee_id);

            return view('employee.show', compact('employee', 'employeesId', 'branches', 'departments', 'designations', 'documents'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }



    function employeeNumber()
    {
        $latest = Employee::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if (!$latest) {
            return 1;
        }

        return $latest->id + 1;
    }

    public function export()
    {
        $name = 'employee_' . date('Y-m-d i:h:s');
        $data = Excel::download(new EmployeesExport(), $name . '.xlsx');
        ob_end_clean();

        return $data;
    }

    public function importFile()
    {
        return view('employee.import');
    }

    public function import(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:csv,txt',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $employees = (new EmployeesImport())->toArray(request()->file('file'))[0];
        $totalCustomer = count($employees) - 1;
        $errorArray    = [];

        for ($i = 1; $i <= count($employees) - 1; $i++) {

            $employee = $employees[$i];
            $employeeByEmail = Employee::where('email', $employee[5])->first();
            $userByEmail = User::where('email', $employee[5])->first();
            // dd($userByEmail);

            if (!empty($employeeByEmail) && !empty($userByEmail)) {

                $employeeData = $employeeByEmail;
            } else {


                $user = new User();
                $user->name = $employee[0];
                $user->email = $employee[5];
                $user->password = Hash::make($employee[6]);
                $user->type = 'employee';
                $user->lang = 'en';
                $user->created_by = \Auth::user()->creatorId();
                $user->save();
                $user->assignRole('Employee');

                $employeeData = new Employee();
                $employeeData->employee_id      = $this->employeeNumber();
                $employeeData->user_id             = $user->id;
            }


            $employeeData->name                = $employee[0];
            $employeeData->dob                 = $employee[1];
            $employeeData->gender              = $employee[2];
            $employeeData->phone               = $employee[3];
            $employeeData->address             = $employee[4];
            $employeeData->email               = $employee[5];
            $employeeData->password            = Hash::make($employee[6]);
            $employeeData->branch_id           = $employee[8];
            $employeeData->department_id       = $employee[9];
            $employeeData->designation_id      = $employee[10];
            $employeeData->company_doj         = $employee[11];
            $employeeData->account_holder_name = $employee[12];
            $employeeData->account_number      = $employee[13];
            $employeeData->bank_name           = $employee[14];
            $employeeData->bank_identifier_code = $employee[15];
            $employeeData->branch_location     = $employee[16];
            $employeeData->tax_payer_id        = $employee[17];
            $employeeData->created_by          = \Auth::user()->creatorId();

            if (empty($employeeData)) {

                $errorArray[] = $employeeData;
            } else {

                $employeeData->save();
            }
        }

        $errorRecord = [];

        if (empty($errorArray)) {
            $data['status'] = 'success';
            $data['msg']    = __('Record successfully imported');
        } else {
            $data['status'] = 'error';
            $data['msg']    = count($errorArray) . ' ' . __('Record imported fail out of' . ' ' . $totalCustomer . ' ' . 'record');


            foreach ($errorArray as $errorData) {

                $errorRecord[] = implode(',', $errorData);
            }

            \Session::put('errorArray', $errorRecord);
        }

        return redirect()->back()->with($data['status'], $data['msg']);
    }

    public function json(Request $request)
    {
        $designations = Designation::where('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();

        return response()->json($designations);
    }

    public function designation_json(Request $request)
    {
        $designations = Designation::get()->pluck('name', 'id')->toArray();

        return response()->json($designations);
    }
    public function json_company_unit(Request $request)
    {
        $units = Client_company_unit::where('company_id', $request->company_id)->get()->pluck('name', 'id')->toArray();

        return response()->json($units);
    }
    public function profile(Request $request)
    {
        if (\Auth::user()->can('Manage Employee Profile')) {
            $employees = Employee::where('created_by', \Auth::user()->creatorId());
            if (!empty($request->branch)) {
                $employees->where('branch_id', $request->branch);
            }
            if (!empty($request->department)) {
                $employees->where('department_id', $request->department);
            }
            if (!empty($request->designation)) {
                $employees->where('designation_id', $request->designation);
            }
            $employees = $employees->get();

            $brances = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $brances->prepend('All', '');

            $departments = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments->prepend('All', '');

            $designations = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations->prepend('All', '');

            return view('employee.profile', compact('employees', 'departments', 'designations', 'brances'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function profileShow($id)
    {
        if (\Auth::user()->can('Show Employee Profile')) {
            $empId        = Crypt::decrypt($id);
            $documents    = Document::where('created_by', \Auth::user()->creatorId())->get();
            $branches     = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments  = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employee     = Employee::find($empId);
            $employeesId  = \Auth::user()->employeeIdFormat($employee->employee_id);

            return view('employee.show', compact('employee', 'employeesId', 'branches', 'departments', 'designations', 'documents'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function lastLogin()
    {
        $users = User::where('created_by', \Auth::user()->creatorId())->get();

        return view('employee.lastLogin', compact('users'));
    }

    public function employeeJson(Request $request)
    {
        $employees = Employee::where('branch_id', $request->branch)->get()->pluck('name', 'id')->toArray();

        return response()->json($employees);
    }
}
