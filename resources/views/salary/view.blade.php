@extends('layouts.admin')
@section('page-title')
{{__('Manage Employee Salary')}}
@endsection 

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        @can('Create Employee')
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="all-button-box">
                    <a href="{{ route('salary.create') }}" class="btn btn-xs btn-white btn-icon-only width-auto">
                        <i class="fa fa-plus"></i> {{ __('Create') }}
                    </a>
                </div>
            </div>
        @endcan
@endsection

@section('content')

<div class="row">
<div class="col-12">
<div class="card">
<div class="card-body py-0">
<div class="table-responsive">
<table class="table table-striped mb-0 dataTable" >
    <thead>
    <tr>
        <th>{{__('Name')}}</th>
        <th>{{__('Company Client Id')}}</th>
        <th>{{__('Company Client Unit Id')}}</th>
        <th>{{__('Designation')}}</th>
        <th>{{__('Amt')}}</th>
        <!-- <th>{{__('is_active') }}</th> -->
        <th>{{__('start_date') }}</th>
        <th>{{__('end_data') }}</th>
         <!-- <th width="3%">{{ __('Action') }}</th> -->
    </tr>
    </thead>
    <tbody>
    @foreach ($salary_log_data as $sal)
        <tr>
            <td>{{ $salary_data->name }}</td>
            <td>
                <?php 
                foreach ($company_client as $key => $value) {
                        if ($key==$sal->company_client_id) {
                           echo $value;
                        }
                } 
                ?></td>
            <td>
                <?php 
                foreach ($company_client_unit as $key => $value) {
                        if ($key==$sal->company_client_unit_id) {
                           echo $value;
                        }
                } 
                ?></td>
             
            <td>{{ $sal->role_id }}</td>
            <td>{{ $sal->amt }}</td>
            <!-- <td>{{ $sal->is_active }}</td> -->
            <td>{{ $sal->start_date }}</td>
            <td>{{ $sal->end_date }}</td>
            
        </tr>
    @endforeach
    </tbody>
</table>
</div>
</div>

</div>
</div>
</div>
@endsection


