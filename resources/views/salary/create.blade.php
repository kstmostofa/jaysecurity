@extends('layouts.admin')
@section('page-title')
{{__('Create Salary')}}
@endsection
@section('content')
<div class="row">
{{Form::open(array('route'=>array('salary.store'),'method'=>'post','enctype'=>'multipart/form-data'))}}
{{--        <form method="post" action="{{route('employee.store')}}" enctype="multipart/form-data">--}}
{{--        @csrf--}}
</div>
<div class="row">
<div class="col-md-6 ">
<div class="card card-fluid">
<div class="card-header"><h6 class="mb-0">{{__('Personal Detail')}}</h6></div>
<div class="card-body ">
<div class="row">
    <div class="form-group col-md-6">
        {!! Form::label('name', __('Name'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
        {!! Form::text('name', old('name'), ['class' => 'form-control','required' => 'required']) !!}
    </div>
    <!-- <div class="form-group col-md-6">
        {!! Form::label('role', __('Role'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
        {!! Form::text('role',old('role'), ['class' => 'form-control']) !!}
    </div> -->
    <div class="form-group col-lg-6 col-md-6">
                {{ Form::label('role', __('User Role'),['class'=>'form-control-label']) }}
                {!! Form::select('role', $roles, null,array('class' => 'form-control select2','required'=>'required')) !!}
                @error('role')
                <span class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('amt', __('Amt'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
            {!! Form::text('amt', old('amt'), ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-md-6 ">
        <div class="form-group ">
            {!! Form::label('is_active', __('Is Active'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
            <div class="d-flex radio-check">
               <!--  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="active" value="1" name="is_active" class="custom-control-input">
                    <label class="custom-control-label" for="g_male">{{__('Active')}}</label>
                </div> -->
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="active_" value="1" name="is_active" class="custom-control-input">
                    <label class="custom-control-label" for="active_">{{__('Active')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="active_not" value="0" name="is_active" class="custom-control-input">
                    <label class="custom-control-label" for="active_not">{{__('Active Not')}}</label>
                </div>
            </div>
        </div>
    </div>
   <!--  <div class="form-group col-md-6">
        {!! Form::label('Start Date', __('Start Date'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
            {!! Form::text('start_date', old('start_date'), ['class' => 'form-control datepicker']) !!}
    </div> -->
    
</div>

</div>
</div>
</div>
<div class="col-md-6 ">
<div class="card card-fluid">
<div class="card-header"><h6 class="mb-0">{{__('Company Detail')}}</h6></div>
<div class="card-body employee-detail-create-body">
<div class="row">
    @csrf
    
    <div class="form-group col-md-6">
        {{ Form::label('companyclient_id', __('Company Client'),['class'=>'form-control-label']) }}
        {{ Form::select('company_client_id', $company_client,null, array('class' => 'form-control  select2','id'=>'company_client_id','required'=>'required')) }}
    </div>
     
    <div class="form-group col-md-6">
        {{ Form::label('company_client_unit_id', __('Company Client Unit'),['class'=>'form-control-label']) }}
        <select class="select2 form-control select2-multiple" id="company_client_unit_id" name="company_client_unit_id" data-toggle="select2" data-placeholder="{{ __('Select Company Unit ...') }}">
            <option value="">{{__('Select any Company Unit')}}</option>
        </select>
    </div>
   <div class="form-group col-md-12">
        {{ Form::label('designation_id', __('Designation'),['class'=>'form-control-label']) }}
        <select class="select2 form-control select2-multiple" id="designation_id" name="designation_id" data-toggle="select2" data-placeholder="{{ __('Select Designation ...') }}">
            <option value="">{{__('Select any Designation')}}</option>
        </select>
    </div>
</div>
</div>
</div>
</div>
</div>



<div class="row">
<div class="col-12">
{!! Form::submit('Create', ['class' => 'btn btn-xs badge-blue float-right radius-10px']) !!}
{{--            </form>--}}
{{Form::close()}}
</div>
</div>
@endsection

@push('script-page')

<script>

$(document).ready(function () {
var d_id = $('#department_id').val();
getDesignation(d_id);
});

$(document).on('change', 'select[name=department_id]', function () {
var department_id = $(this).val();
getDesignation(department_id);
});

function getDesignation(did) {

$.ajax({
url: '{{route('employee.json')}}',
type: 'POST',
data: {
"department_id": did, "_token": "{{ csrf_token() }}",
},
success: function (data) {
$('#designation_id').empty();
$('#designation_id').append('<option value="">{{__('Select any Designation')}}</option>');
$.each(data, function (key, value) {
    $('#designation_id').append('<option value="' + key + '">' + value + '</option>');
});
}
});
}
</script>
<script>

$(document).ready(function () {
var d_id = $('#company_client_id').val();
getCompanyUnit(d_id);
getDesignation();
});

$(document).on('change', 'select[name=company_client_id]', function () {

var company_id = $(this).val();
getCompanyUnit(company_id);
});

function getCompanyUnit(did) {
$.ajax({
url: '{{route('employee.json_company_unit')}}',
type: 'POST',
data: {
"company_id": did, "_token": "{{ csrf_token() }}",
},
success: function (data) {
$('#company_client_unit_id').empty();
$('#company_client_unit_id').append('<option value="">{{__('Select any Company Unit')}}</option>');
$.each(data, function (key, value) {
    $('#company_client_unit_id').append('<option value="' + key + '">' + value + '</option>');
});
}
});
}

function getDesignation(did) {

$.ajax({
url: '{{route('employee.designation.json')}}',
type: 'POST',
data: {
"_token": "{{ csrf_token() }}",
},
success: function (data) {
$('#designation_id').empty();
$('#designation_id').append('<option value="">{{__('Select any Designation')}}</option>');
$.each(data, function (key, value) {
    $('#designation_id').append('<option value="' + key + '">' + value + '</option>');
});
}
});
}
</script>
@endpush
