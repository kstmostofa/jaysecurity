<?php
 
namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Client_company;
use App\Models\Client_company_unit;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ClientCompanyUnitController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Company Unit'))
        {
            $companies_unit = Client_company_unit::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('clientCompanyUnit.index', compact('companies_unit'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Company Unit'))
        {
            $company = Client_company::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            // return view('clientCompanyUnit.create');
            return view('clientCompanyUnit.create', compact('company'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Company Unit'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                'name' => 'required',
                                'company_id' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $company_unit       = new Client_company_unit();
            $company_unit->company_id  = $request->company_id;
            $company_unit->name       = $request->name;
            $company_unit->created_by = \Auth::user()->creatorId();
            $company_unit->save();

            return redirect()->route('company-unit.index')->with('success', __('Company Unit  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Client_company_unit $company)
    {
        return redirect()->route('company-unit.index');
    }

    public function edit(Client_company_unit $company_unit)
    {
        if(\Auth::user()->can('Edit Company Unit'))
        {  //dd($company_unit->created_by);
            if($company_unit->created_by == \Auth::user()->creatorId())
            {
                $company = Client_company::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                // dd($company_unit);
                return view('clientCompanyUnit.edit', compact('company_unit', 'company'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, Client_company_unit $company_unit)

    { 
        if(\Auth::user()->can('Edit Company Unit'))
        {
            if($company_unit->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                    'name' => 'required',
                                    'company_id' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $company_unit->company_id  = $request->company_id;
                $company_unit->name = $request->name;
                $company_unit->save();

                return redirect()->route('company-unit.index')->with('success', __('Company Unit successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Client_company_unit $company_unit)
    { //dd($company);
        if(\Auth::user()->can('Delete Company Unit'))
        {
            if($company_unit->created_by == \Auth::user()->creatorId())
            {
                $company_unit->delete();

                return redirect()->route('company-unit.index')->with('success', __('Company Unit successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
public function add_company_unit(Request $request)
    {
        $current_date_time = Carbon::now()->toDateTimeString(); 
        $validator = \Validator::make(
                $request->all(), [
                               'name' => 'required',
                               'company_id' => 'required',
                               'created_by'=>'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            $res=[
                 'status' =>400,
                 'timestamp'=>$current_date_time,
                 'responseMessage' =>  'error',
                 'error' => $messages,
                 'path' => '/add_company_unit',
                ]; 
                return response()->json(
                    $res, 400);
        }
        $company_data = Client_company::where('id', '=',$request->company_id)->first();

        if($company_data){
            $company          = new Client_company_unit();
            $company->name       = $request->name;
            $company->company_id  = $request->company_id;
            $company->created_by = $request->created_by;
            $company->save();

            $res=[
                 'status' =>200,
                 'timestamp'=>$current_date_time,
                 'responseMessage' =>'Company  successfully created.',
                 'path' => '/add_company_unit'
                ]; 
            return response()->json($res, 200);
        }
        else{
                $res=[
                 'status' =>400,
                 'timestamp'=>$current_date_time,
                 'responseMessage' =>  'company_id not found',
                 'error' => $messages,
                 'path' => '/add_company_unit',
                ]; 
                return response()->json(
                    $res, 400);
        }
       
    }
    
}
