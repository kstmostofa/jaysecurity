@extends('layouts.admin')

@section('page-title')
    {{ __('Employee') }}
@endsection

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        @can('Edit Employee')
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="{{ route('employee.edit', \Illuminate\Support\Facades\Crypt::encrypt($employee->id)) }}"
                    class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fa fa-edit"></i> {{ __('Edit') }}
                </a>
            </div>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('Personal Detail') }}</h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{ __('EmployeeId') }}</strong>
                                    <span>{{ $employeesId }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{ __('Name') }}</strong>
                                    <span>{{ $employee->name }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{ __('Email') }}</strong>
                                    <span>{{ $employee->email }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{ __('Date of Birth') }}</strong>
                                    <span>{{ \Auth::user()->dateFormat($employee->dob) }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{ __('Phone') }}</strong>
                                    <span>{{ $employee->phone }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{ __('Address') }}</strong>
                                    <span>{{ $employee->address }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{ __('Salary Type') }}</strong>
                                    <span>{{ !empty($employee->salaryType) ? $employee->salaryType->name : '' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{ __('Basic Salary') }}</strong>
                                    <span>{{ $employee->salary }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('Company Detail') }}</h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{ __('Branch') }}</strong>
                                    <span>{{ !empty($employee->branch) ? $employee->branch->name : '' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{ __('Company Name') }}</strong>
                                    <span>{{ $employee->company->name }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{ __('Company Unit') }}</strong>
                                    <span>{{ $employee->unit->name }}</span>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{ __('Department') }}</strong>
                                    <span>{{ !empty($employee->department) ? $employee->department->name : '' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{ __('Designation') }}</strong>
                                    <span>{{ !empty($employee->designation) ? $employee->designation->name : '' }}</span>
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{ __('Date Of Joining') }}</strong>
                                    <span>{{ \Auth::user()->dateFormat($employee->company_doj) }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('Document Detail') }}</h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            @php
                                $employeedoc = $employee->documents()->pluck('document_value', 'document_id');
                            @endphp
                            @foreach ($documents as $key => $document)
                                <div class="col-md-12">
                                    <div class="info text-sm">
                                        <strong>{{ $document->name }}</strong>
                                        <span><a href="{{ !empty($employeedoc[$document->id]) ? asset(Storage::url('uploads/document')) . '/' . $employeedoc[$document->id] : '' }}"
                                                target="_blank">{{ !empty($employeedoc[$document->id]) ? $employeedoc[$document->id] : '' }}</a></span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('Bank Account Detail') }}</h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{ __('Account Holder Name') }}</strong>
                                    <span>{{ $employee->account_holder_name }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{ __('Account Number') }}</strong>
                                    <span>{{ $employee->account_number }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{ __('Bank Name') }}</strong>
                                    <span>{{ $employee->bank_name }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{ __('Bank Identifier Code') }}</strong>
                                    <span>{{ $employee->bank_identifier_code }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{ __('Branch Location') }}</strong>
                                    <span>{{ $employee->branch_location }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{ __('Tax Payer Id') }}</strong>
                                    <span>{{ $employee->tax_payer_id }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-fluid">
                <div class="card-header">
                    <h6 class="mb-0">Additional Details</h6>
                </div>
                <div class="card-body employee-detail-create-body">
                    <div class="row">
                        <input type="hidden" name="field_count" class="form-control" value="<?php echo count($fields); ?>">
                        <?php foreach ($fields as $value) {
        $field_value='';$field_data_id=0;
        
        foreach ($emp_field_data as $val) {
            
            if ($val->field_id==$value->id) {
                $field_data_id=$val->id;
                $field_value=$val->field_value;
            }
        }
      ?>
                        {{-- <input type="hidden" name="fields_<?php echo $value->id; ?>" value="{{ $field_data_id }}"> --}}
                        <div class="form-group col-md-3">
                            <div class="info text-sm font-style">
                                <strong>{{ $value->field_name }}:</strong>
                                <span>{{ $field_value }}</span>
                            </div>
                            {{-- <label class="form-control-label" for="fields">{{ $value->field_name }} ffff</label> --}}
                            <?php 
        $c=0;
        if ($value->type=='file') {
            
            ?><img src="/uploads/{{ $field_value }}" width="100px" height="100px">
                            <?php 
            $c++;
        }
        else if ($value->type=='radio') {
            ?>
                            <div class="row"><?php
            foreach ($fields_atribute as $atribute) {
                if ($atribute->field_id==$value->id) {
                 ?>
                                {{-- <div class="d-flex radio-check">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="{{ $atribute->option_name }}"
                                            value="{{ $atribute->option_value }}" name="fields[value_{{ $value->id }}]"
                                            <?php if ($field_value == $atribute->option_value) {
                                                echo 'checked';
                                            } ?> class="custom-control-input">
                                        <label class="custom-control-label"
                                            for="{{ $atribute->option_name }}">{{ $atribute->option_name }}</label>
                                    </div>
                                </div> --}}

                                <?php   
                }
            }
            ?>
                            </div><?php
        }
        else if ($value->type=='checkbox') {
            ?>
                            <div class="row"><?php
            foreach ($fields_atribute as $atribute) {
                if ($atribute->field_id==$value->id) {
            ?>
                                <div class="d-flex radio-check">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="checkbox" id="{{ $atribute->option_name }}"
                                            value="{{ $atribute->option_value }}" name="fields[value_{{ $value->id }}]"
                                            <?php if ($field_value == $atribute->option_value) {
                                                echo 'checked';
                                            } ?> class="custom-control-input">
                                        <label class="custom-control-label"
                                            for="{{ $atribute->option_name }}">{{ $atribute->option_name }}</label>
                                    </div>
                                </div>
                                <?php
            }
          }
        ?>
                            </div>
                            <?php
        }
        else if ($value->type=='select') {
            ?>
                            <div class="row">
                                <select class="form-control select2-multiple" id="{{ $atribute->option_name }}"
                                    name="fields[value_{{ $value->id }}]" data-toggle="select2"
                                    data-placeholder="{{ __('Select...') }}"
                                    style="border-radius: 10px;height: 40px;box-shadow: none;line-height: 40px;font-size: 12px;font-family: 'Montserrat-SemiBold';font-weight: normal;">
                                    <?php
            foreach ($fields_atribute as $atribute) {
                if ($atribute->field_id==$value->id) {
            ?>
                                    <option value="{{ $atribute->option_value }}" <?php if ($field_value == $atribute->option_value) {
                                        echo 'selected';
                                    } ?>>
                                        {{ $atribute->option_name }}</option>

                                    <?php
            }
          }
          ?>
                                </select>
                            </div><?php 
        }
        else{
            ?>
                            <!-- <input type="<?php echo $value->type; ?>" name="fields[value_][]" value='<?php echo $field_value; ?>' class="form-control"> -->
                            <?php
        } ?>

                            <input type="hidden" name="fields[id][]" class="form-control" value="<?php echo $value->id; ?>">
                            <input type="hidden" name="fields[name][]" class="form-control"
                                value="<?php echo $value->field_name; ?>">
                            <input type="hidden" name="fields[type][]" class="form-control"
                                value="<?php echo $value->type; ?>">
                            <input type="hidden" name="fields[mandatory][]" class="form-control"
                                value="<?php echo $value->mandatory; ?>">

                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
