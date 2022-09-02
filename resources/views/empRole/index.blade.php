@extends('layouts.admin')

@section('page-title')
{{__('Manage Employee Role')}}
@endsection

@section('action-button')
<div class="all-button-box row d-flex justify-content-end">
@can('Create Branch')
<div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
<a href="#" data-url="{{ route('emp-role.create') }}" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="{{__('Create New Role')}}">
<i class="fa fa-plus"></i> {{__('Create')}}
</a>
</div>
@endcan
</div>
@endsection

@section('content')
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-body py-0">
<div class="table-responsive">
<table class="table table-striped mb-0 dataTable" >
<thead>
<tr>
<th>{{__('Name')}}</th>
<th width="200px">{{ __('Action') }}</th>
</tr>
</thead>
<tbody class="font-style">
@foreach ($emp_roles as $role)
<tr>
<td>{{ $role->name }}</td>
<td class="Action text-right">
    
    <span>
        @can('Edit Branch')
            <a href="#" class="edit-icon" data-url="{{ URL::to('emp-role/'.$role->id.'/edit') }} " data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Role')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i></a>
        @endcan
        @can('Delete Branch')
            <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$role->id}}').submit();"><i class="fas fa-trash"></i></a>
            {!! Form::open(['method' => 'DELETE', 'route' => ['emp-role.destroy', $role->id],'id'=>'delete-form-'.$role->id]) !!}
            {!! Form::close() !!}
        @endcan
    </span>
</td>
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

