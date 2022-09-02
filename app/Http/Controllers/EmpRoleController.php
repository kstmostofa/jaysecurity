<?php
 
namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\EmpRole;
use Illuminate\Http\Request;
use Carbon\Carbon;
class EmpRoleController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Company'))
        { 
            $emp_roles = EmpRole::get();
            $branchs= Branch::get();
            return view('empRole.index', compact('emp_roles','branchs'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Company'))
        {
            // return view('clientCompany.create', compact('branch'));
            return view('empRole.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Company'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $role             = new EmpRole();
            $role->name       = $request->name;
            $role->save();

            return redirect()->route('emp-role.index')->with('success', __('Role  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Client_company $company)
    {
        return redirect()->route('empRole.index');
    }

    public function edit(EmpRole $emp_role)
    {
        if(\Auth::user()->can('Edit Company'))
        {  //dd($company->created_by);
            // if($emp_role->created_by == \Auth::user()->creatorId())
            // {
                return view('empRole.edit', compact('emp_role'));
            // }
            // else
            // {
            //     return response()->json(['error' => __('Permission denied.')], 401);
            // }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, EmpRole $emp_role)
    { 
        if(\Auth::user()->can('Edit Company'))
        {
            // if($company->created_by == \Auth::user()->creatorId())
            // {
                $validator = \Validator::make(
                    $request->all(), [
                                    'name' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $emp_role->name = $request->name;
                $emp_role->save();

                return redirect()->route('emp-role.index')->with('success', __('Role successfully updated.'));
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

    public function destroy(EmpRole $emp_role)
    { //dd($emp_role);
        if(\Auth::user()->can('Delete Company'))
        {
            // if($company->created_by == \Auth::user()->creatorId())
            // {
                $emp_role->delete();

                return redirect()->route('emp-role.index')->with('success', __('Role successfully deleted.'));
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

public function get_all_emp_role()
{  
   $res=array();
   $roles = EmpRole::get();
   foreach ($roles as  $value) {
       array_push($res, $value);
   }
   
    $current_date_time=Carbon::now()->toDateTimeString();
    $res=[
         'status' =>200,
         'timestamp'=>$current_date_time,
         'responseMessage' =>'You get data successfully',
         'path' => '/list_of_emp_role',
         'data' => $res
        ];
        return response()->json($res,200); 
}
}
