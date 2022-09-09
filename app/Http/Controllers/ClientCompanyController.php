<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Client_company;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClientCompanyController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('Manage Company')) {
            $companies = Client_company::where('created_by', '=', \Auth::user()->creatorId())->get();
            $branchs = Branch::get();
            // dd($branchs);
            return view('clientCompany.index', compact('companies', 'branchs'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('Create Company')) {
            $branch = Branch::get()->pluck('name', 'id');
            return view('clientCompany.create', compact('branch'));
            // return view('clientCompany.create');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Company')) {

            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'branch_id' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $branch             = new Client_company();
            $branch->name       = $request->name;
            $branch->branch_id       = $request->branch_id;
            $branch->created_by = \Auth::user()->creatorId();
            $branch->save();

            return redirect()->route('company.index')->with('success', __('Company  successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Client_company $company)
    {
        return redirect()->route('company.index');
    }

    public function edit(Client_company $company)
    {
        if (\Auth::user()->can('Edit Company')) {  //dd($company->created_by);
            if ($company->created_by == \Auth::user()->creatorId()) {
                $branch = Branch::get()->pluck('name', 'id');
                return view('clientCompany.edit', compact('company', 'branch'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, Client_company $company)
    {
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

                    return redirect()->back()->with('error', $messages->first());
                }

                $company->name = $request->name;
                $company->branch_id = $request->branch_id;
                $company->save();

                return redirect()->route('company.index')->with('success', __('Company successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Client_company $company)
    { //dd($company);
        if (\Auth::user()->can('Delete Company')) {
            if ($company->created_by == \Auth::user()->creatorId()) {
                $company->delete();

                return redirect()->route('company.index')->with('success', __('Company successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function getdepartment(Request $request)
    {

        if ($request->branch_id == 0) {
            $departments = Department::get()->pluck('name', 'id')->toArray();
        } else {
            $departments = Department::where('branch_id', $request->branch_id)->get()->pluck('name', 'id')->toArray();
        }

        return response()->json($departments);
    }

    public function getemployee(Request $request)
    {
        if (in_array('0', $request->department_id)) {
            $employees = Employee::get()->pluck('name', 'id')->toArray();
        } else {
            $employees = Employee::whereIn('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();
        }

        return response()->json($employees);
    }
    public function add_company(Request $request)
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'branch_id' => 'required',
                'created_by' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' =>  'error',
                'error' => $messages,
                'path' => '/add_company',
            ];
            return response()->json(
                $res,
                400
            );
        }
        $branch_data = Branch::where('id', '=', $request->branch_id)->first();

        if ($branch_data) {
            $company             = new Client_company();
            $company->name       = $request->name;
            $company->branch_id  = $request->branch_id;
            $company->created_by = $request->created_by;
            $company->save();

            $res = [
                'status' => 200,
                'timestamp' => $current_date_time,
                'responseMessage' => 'Company  successfully created.',
                'path' => '/add_company'
            ];
            return response()->json($res, 200);
        } else {
            $res = [
                'status' => 400,
                'timestamp' => $current_date_time,
                'responseMessage' =>  'branch_id not found',
                'error' => $messages,
                'path' => '/add_company',
            ];
            return response()->json(
                $res,
                400
            );
        }
    }
}
