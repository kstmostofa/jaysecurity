<?php
 
namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Client_company;
use App\Models\Employee_field;
use App\Models\Employee_field_atribute;
use Illuminate\Http\Request;
 
class EmployeeFieldController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Employee Field'))
        { 
            $companies = Client_company::where('created_by', '=', \Auth::user()->creatorId())->get();
            $fields = Employee_field::
            // where('created_by', '=', \Auth::user()->creatorId())->
            get();
            $fields_atribute=Employee_field_atribute::get();
            return view('employee_field.index', compact('fields','fields_atribute'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    { 
        if(\Auth::user()->can('Create Employee Field'))
        {
            return view('employee_field.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {  //dd($request);
        if(\Auth::user()->can('Create Employee Field'))
        {

            $validator = \Validator::make(
                $request->all(), 
                [
                    'name'      => 'required',
                    'type'      => 'required',
                    'status'    => 'required',
                    'mandatory' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            /// if type is radio
            if ($request->type=='radio') {
                for ($i=0; $i < count($request->option_name) ; $i++) { 
                  $validate_=array(
                    'option_name' => $request->option_name[$i] ,
                    'option_value' => $request->option_value[$i] ,
                    );
                    $validate_ = \Validator::make($validate_, [
                   'option_name'  => 'required',
                   'option_value'  => 'required',   
                    ]);

                    if ($validate_->fails()) {
                    $validate_msg = $validate_->getMessageBag();
                    return redirect()->back()->withInput()->with('error', $validate_msg);
                    }  
                }
            }
            if (isset($request->multiple) and $request->multiple==1 ) {
                if ($request->type=='checkbox' or $request->type=='select') {
                    $multiple=$request->multiple;
                }
                else{
                $multiple=0;
                }
            }
            else{
                $multiple=0;
            }
            
            ///end
            $employee_field     = new Employee_field();
            $employee_field->field_name = $request->name;
            $employee_field->type       = $request->type;
            $employee_field->status     = $request->status;
            $employee_field->mandatory  = $request->mandatory;
            $employee_field->multiple   = $multiple;
            $employee_field->created_by = \Auth::user()->creatorId();
            $employee_field->save();
            /// if type is radio
            $field_id=$employee_field->id;
             if ($request->type=='checkbox' or $request->type=='select' or $request->type=='radio') {
            for ($i=0; $i < count($request->option_name) ; $i++) { 

              $field_option = new Employee_field_atribute();
              $field_option->field_id = $field_id;
              $field_option->option_name = $request->option_name[$i];
              $field_option->option_value       = $request->option_value[$i];
              $field_option->created_by = \Auth::user()->creatorId();
              $field_option->save();  
              }
            }
            ///end
            return redirect()->route('employee-field.index')->with('success', __('Employee Field successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Client_company $company)
    {
        return redirect()->route('employee_field.index');
    }

    // public function edit(Employee_field $field)
    public function edit($id)
    {
        if(\Auth::user()->can('Edit Employee Field'))
        {  
            // if($field->created_by == \Auth::user()->creatorId())
            // {
        $field = Employee_field::
            where('id', '=',$id)->
            first();
        $fields_atribute=Employee_field_atribute::where('field_id', '=',$id)->get();    
                return view('employee_field.edit', compact('field','fields_atribute'));
            // }
        //     else
        //     {
        //         return response()->json(['error' => __('Permission denied.')], 401);
        //     }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    // public function update(Request $request, Employee_field $field)
    public function update(Request $request)
    { 
        $field = Employee_field::
                 where('id', '=',$request->id)->
                 first();
        $fields_atribute = Employee_field_atribute::where('field_id', '=',$request->id)->get();   
                  
        if(\Auth::user()->can('Edit Employee Field'))
        {
            // if($field->created_by == \Auth::user()->creatorId())
            // {
                $validator = \Validator::make(
                    $request->all(), 
                    [
                    'name'      => 'required',
                    'type'      => 'required',
                    'status'    => 'required',
                    'mandatory' => 'required',
                    ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                
            /// if type is radio

            if ($request->type=='radio') {
                for ($i=0; $i < count($request->option_name) ; $i++) { 
                  $validate_=array(
                    'option_name' => $request->option_name[$i] ,
                    'option_value' => $request->option_value[$i] ,
                    );
                    $validate_ = \Validator::make($validate_, [
                   'option_name'  => 'required',
                   'option_value'  => 'required',   
                    ]);

                    if ($validate_->fails()) {
                    $validate_msg = $validate_->getMessageBag();
                    return redirect()->back()->withInput()->with('error', $validate_msg);
                    }  
                }
            }
            if (isset($request->multiple) and $request->multiple==1 ) {
                if ($request->type=='checkbox' or $request->type=='select') {
                    $multiple=$request->multiple;
                }
                else{
                $multiple=0;
                }
            }
            else{
                $multiple=0;
            }
            // echo $multiple;die;
            ///end 
    $data = array(
         'field_name' =>  $request->name,
         'type'       =>  $request->type,
         'status'     =>  $request->status,
         'mandatory'  =>  $request->mandatory,
         'multiple'   =>  $multiple
       );
    $updated= Employee_field::where('id',$request->id)->update($data);

    /// if type is radio
    $field_id=$request->id;

    //first delete
     Employee_field_atribute::where('field_id', '=',$request->id)->delete(); 
    //

     if (isset($request->option_name)) {
      
    for ($i=0; $i < count($request->option_name) ; $i++) { 

      $field_option = new Employee_field_atribute();
      $field_option->field_id = $field_id;
      $field_option->option_name = $request->option_name[$i];
      $field_option->option_value       = $request->option_value[$i];
      $field_option->created_by = \Auth::user()->creatorId();
      $field_option->save();  
      }
    }
    ///end
 return redirect('/employee-field')->with('success', 'Employee field successfully updated.');
                // return redirect()->route('Employee-field.index')->with('success', __('Employee field successfully updated.'));
            // }
            // else
            // {
            //     return redirect()->back()->with('error', __('Permission denied.'));
            // }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // public function destroy(Employee_field $field)\
    public function destroy(Request $request,$id)
    { 
        $field = Employee_field::
                 where('id', '=',$id)->
                 first();

        if(\Auth::user()->can('Delete Employee Field'))
        {
            // if($field->created_by == \Auth::user()->creatorId())
            // {
                $field->delete();

                return redirect()->route('employee-field.index')->with('success', __('Field successfully deleted.'));
            // }
            // else
            // {
            //     return redirect()->back()->with('error', __('Permission denied.'));
            // }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function getdepartment(Request $request)
    {

        if($request->branch_id == 0)
        {
            $departments = Department::get()->pluck('name', 'id')->toArray();
        }
        else
        {
            $departments = Department::where('branch_id', $request->branch_id)->get()->pluck('name', 'id')->toArray();
        }

        return response()->json($departments);
    }

    public function getemployee(Request $request)
    {
        if(in_array('0', $request->department_id))
        {
            $employees = Employee::get()->pluck('name', 'id')->toArray();
        }
        else
        {
            $employees = Employee::whereIn('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();
        }

        return response()->json($employees);
    }
}
