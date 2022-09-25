<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Employee')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Employee')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="<?php echo e(route('employee.edit', \Illuminate\Support\Facades\Crypt::encrypt($employee->id))); ?>"
                    class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fa fa-edit"></i> <?php echo e(__('Edit')); ?>

                </a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><?php echo e(__('Personal Detail')); ?></h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('EmployeeId')); ?></strong>
                                    <span><?php echo e($employeesId); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Name')); ?></strong>
                                    <span><?php echo e($employee->name); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Email')); ?></strong>
                                    <span><?php echo e($employee->email); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Date of Birth')); ?></strong>
                                    <span><?php echo e(\Auth::user()->dateFormat($employee->dob)); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Phone')); ?></strong>
                                    <span><?php echo e($employee->phone); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Address')); ?></strong>
                                    <span><?php echo e($employee->address); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Salary Type')); ?></strong>
                                    <span><?php echo e(!empty($employee->salaryType) ? $employee->salaryType->name : ''); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Basic Salary')); ?></strong>
                                    <span><?php echo e($employee->salary); ?></span>
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
                        <h6 class="mb-0"><?php echo e(__('Company Detail')); ?></h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Branch')); ?></strong>
                                    <span><?php echo e(!empty($employee->branch) ? $employee->branch->name : ''); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Company Name')); ?></strong>
                                    <span><?php echo e($employee->company->name); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Company Unit')); ?></strong>
                                    <span><?php echo e($employee->unit->name); ?></span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Date Of Joining')); ?></strong>
                                    <span><?php echo e(\Auth::user()->dateFormat($employee->company_doj)); ?></span>
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
                        <h6 class="mb-0"><?php echo e(__('Document Detail')); ?></h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <?php
                                $employeedoc = $employee->documents()->pluck('document_value', 'document_id');
                            ?>
                            <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-12">
                                    <div class="info text-sm">
                                        <strong><?php echo e($document->name); ?></strong>
                                        <span><a href="<?php echo e(!empty($employeedoc[$document->id]) ? asset(Storage::url('uploads/document')) . '/' . $employeedoc[$document->id] : ''); ?>"
                                                target="_blank"><?php echo e(!empty($employeedoc[$document->id]) ? $employeedoc[$document->id] : ''); ?></a></span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><?php echo e(__('Bank Account Detail')); ?></h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Account Holder Name')); ?></strong>
                                    <span><?php echo e($employee->account_holder_name); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Account Number')); ?></strong>
                                    <span><?php echo e($employee->account_number); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Bank Name')); ?></strong>
                                    <span><?php echo e($employee->bank_name); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Bank Identifier Code')); ?></strong>
                                    <span><?php echo e($employee->bank_identifier_code); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Branch Location')); ?></strong>
                                    <span><?php echo e($employee->branch_location); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Tax Payer Id')); ?></strong>
                                    <span><?php echo e($employee->tax_payer_id); ?></span>
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
                        
                        <div class="form-group col-md-3">
                            <div class="info text-sm font-style">
                                <strong><?php echo e($value->field_name); ?>:</strong>
                                <span><?php echo e($field_value); ?></span>
                            </div>
                            
                            <?php 
        $c=0;
        if ($value->type=='file') {
            
            ?><img src="/uploads/<?php echo e($field_value); ?>" width="100px" height="100px">
                            <?php 
            $c++;
        }
        else if ($value->type=='radio') {
            ?>
                            <div class="row"><?php
            foreach ($fields_atribute as $atribute) {
                if ($atribute->field_id==$value->id) {
                 ?>
                                

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
                                        <input type="checkbox" id="<?php echo e($atribute->option_name); ?>"
                                            value="<?php echo e($atribute->option_value); ?>" name="fields[value_<?php echo e($value->id); ?>]"
                                            <?php if ($field_value == $atribute->option_value) {
                                                echo 'checked';
                                            } ?> class="custom-control-input">
                                        <label class="custom-control-label"
                                            for="<?php echo e($atribute->option_name); ?>"><?php echo e($atribute->option_name); ?></label>
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
                                <select class="form-control select2-multiple" id="<?php echo e($atribute->option_name); ?>"
                                    name="fields[value_<?php echo e($value->id); ?>]" data-toggle="select2"
                                    data-placeholder="<?php echo e(__('Select...')); ?>"
                                    style="border-radius: 10px;height: 40px;box-shadow: none;line-height: 40px;font-size: 12px;font-family: 'Montserrat-SemiBold';font-weight: normal;">
                                    <?php
            foreach ($fields_atribute as $atribute) {
                if ($atribute->field_id==$value->id) {
            ?>
                                    <option value="<?php echo e($atribute->option_value); ?>" <?php if ($field_value == $atribute->option_value) {
                                        echo 'selected';
                                    } ?>>
                                        <?php echo e($atribute->option_name); ?></option>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/employee/show.blade.php ENDPATH**/ ?>