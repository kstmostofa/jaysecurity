@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Plan Request') }}
@endsection



@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                                <tr>
                                    <th> {{ __('User Name') }}</th>
                                    <th> {{ __('Plan Name') }}</th>
                                    <th> {{ __('Employees') }}</th>
                                    <th> {{ __('Users') }}</th>
                                    <th> {{ __('Duration') }}</th>
                                    <th> {{ __('Created At') }}</th>
                                    <th> {{ __('Action') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($plan_requests as $prequest)
                                    <tr class="font-style">
                                        <td>{{ $prequest->user->name }}</td>
                                        <td>{{ $prequest->plan->name }}</td>
                                        <td>{{ $prequest->plan->max_employees }}</td>
                                        <td>{{ $prequest->plan->max_users }}</td>
                                        <td>{{ $prequest->duration }}</td>
                                        <td>{{ $prequest->created_at }}</td>
                                        <td class="action">
                                            <a href="{{ route('plan_request.update', $prequest->id) }}"
                                                class="btn btn-success mr-3">Approve
                                            </a>
                                            <a href="#" class="btn btn-danger" data-toggle="tooltip"
                                                data-original-title="{{ __('Delete') }}"
                                                data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                data-confirm-yes="document.getElementById('delete-form-{{ $prequest->id }}').submit();">
                                                Reject
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['plan_requests.destroy', $prequest->id], 'id' => 'delete-form-' . $prequest->id]) !!}
                                            {!! Form::close() !!}
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
