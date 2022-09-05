
<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Create Employee')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
<?php echo e(Form::open(array('route'=>array('employee.store'),'method'=>'post','enctype'=>'multipart/form-data'))); ?>



</div>
<div class="row">
<div class="col-md-6 ">
<div class="card card-fluid">
<div class="card-header"><h6 class="mb-0"><?php echo e(__('Personal Detail')); ?></h6></div>
<div class="card-body ">
<div class="row">
    <div class="form-group col-md-6">
        <?php echo Form::label('name', __('Name'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
        <?php echo Form::text('name', old('name'), ['class' => 'form-control','required' => 'required']); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo Form::label('phone', __('Phone'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
        <?php echo Form::text('phone',old('phone'), ['class' => 'form-control']); ?>

    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo Form::label('dob', __('Date of Birth'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
            <?php echo Form::text('dob', old('dob'), ['class' => 'form-control datepicker']); ?>

        </div>
    </div>

    <div class="col-md-6 ">
        <div class="form-group ">
            <?php echo Form::label('gender', __('Gender'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
            <div class="d-flex radio-check">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="g_male" value="Male" name="gender" class="custom-control-input">
                    <label class="custom-control-label" for="g_male"><?php echo e(__('Male')); ?></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="g_female" value="Female" name="gender" class="custom-control-input">
                    <label class="custom-control-label" for="g_female"><?php echo e(__('Female')); ?></label>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group col-md-6">
        <?php echo Form::label('email', __('Email'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
        <?php echo Form::email('email',old('email'), ['class' => 'form-control','required' => 'required']); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo Form::label('password', __('Password'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
        <?php echo Form::password('password', ['class' => 'form-control','required' => 'required']); ?>

    </div>
</div>
<div class="form-group">
    <?php echo Form::label('address', __('Address'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
    <?php echo Form::textarea('address',old('address'), ['class' => 'form-control','rows'=>2]); ?>

</div>
 <div class="form-group">
        <?php echo Form::label('aadhar_card_no', __('Aadhar Card No'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
        <?php echo Form::text('aadhar_card_no', old('aadhar_card_no'), ['class' => 'form-control','required' => 'required']); ?>

    </div>
</div>
</div>
</div>
<div class="col-md-6 ">
<div class="card card-fluid">
<div class="card-header"><h6 class="mb-0"><?php echo e(__('Company Detail')); ?></h6></div>
<div class="card-body employee-detail-create-body">
<div class="row">
    <?php echo csrf_field(); ?>
    <div class="form-group col-md-12">
        <?php echo Form::label('employee_id', __('Employee ID'),['class'=>'form-control-label']); ?>

        <?php echo Form::text('employee_id', $employeesId, ['class' => 'form-control','disabled'=>'disabled']); ?>

    </div>

    <div class="form-group col-md-6">
        <?php echo e(Form::label('branch_id', __('Branch'),['class'=>'form-control-label'])); ?>

        <?php echo e(Form::select('branch_id', $branches,null, array('class' => 'form-control  select2','required'=>'required'))); ?>

    </div>
    
    <div class="form-group col-md-6">
        <?php echo e(Form::label('department_id', __('Department'),['class'=>'form-control-label'])); ?>

        <?php echo e(Form::select('department_id', $departments,null, array('class' => 'form-control  select2','id'=>'department_id','required'=>'required'))); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('companyclient_id', __('Company Client'),['class'=>'form-control-label'])); ?>

        <?php echo e(Form::select('company_client_id', $company_client,null, array('class' => 'form-control  select2','id'=>'company_client_id','required'=>'required'))); ?>

    </div>
    
    <div class="form-group col-md-6">
        <?php echo e(Form::label('company_client_unit_id', __('Company Client Unit'),['class'=>'form-control-label'])); ?>

        <select class="select2 form-control select2-multiple" id="company_client_unit_id" name="company_client_unit_id" data-toggle="select2" data-placeholder="<?php echo e(__('Select Company Unit ...')); ?>">
            <option value=""><?php echo e(__('Select any Company Unit')); ?></option>
        </select>
    </div>
    <div class="form-group col-md-12">
        <?php echo e(Form::label('designation_id', __('Designation'),['class'=>'form-control-label'])); ?>

        <select class="select2 form-control select2-multiple" id="designation_id" name="designation_id" data-toggle="select2" data-placeholder="<?php echo e(__('Select Designation ...')); ?>">
            <option value=""><?php echo e(__('Select any Designation')); ?></option>
        </select>
    </div>
    <div class="form-group col-md-12 ">
        <?php echo Form::label('company_doj', __('Company Date Of Joining'),['class'=>'form-control-label']); ?>

        <?php echo Form::text('company_doj', null, ['class' => 'form-control datepicker','required' => 'required']); ?>

    </div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6 ">
<div class="card card-fluid">
<div class="card-header"><h6 class="mb-0"><?php echo e(__('Document')); ?></h6></div>
<div class="card-body employee-detail-create-body">
<?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="row">
        <div class="form-group col-12">
            <div class="float-left col-4">
                <label for="document" class="float-left pt-1 form-control-label"><?php echo e($document->name); ?> <?php if($document->is_required == 1): ?> <span class="text-danger">*</span> <?php endif; ?></label>
            </div>
            <div class="float-right col-8">
                <input type="hidden" name="emp_doc_id[<?php echo e($document->id); ?>]" id="" value="<?php echo e($document->id); ?>">
                <div class="choose-file form-group">
                    <label for="document[<?php echo e($document->id); ?>]">
                        <div><?php echo e(__('Choose File')); ?></div>
                        <input class="form-control  <?php $__errorArgs = ['document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> border-0" <?php if($document->is_required == 1): ?> required <?php endif; ?> name="document[<?php echo e($document->id); ?>]" type="file" id="document[<?php echo e($document->id); ?>]" data-filename="<?php echo e($document->id.'_filename'); ?>">
                    </label>
                    <p class="<?php echo e($document->id.'_filename'); ?>"></p>
                </div>

            </div>

        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
</div>
</div>
<div class="col-md-6 ">
<div class="card card-fluid">
<div class="card-header"><h6 class="mb-0"><?php echo e(__('Bank Account Detail')); ?></h6></div>
<div class="card-body employee-detail-create-body">
<div class="row">
    <div class="form-group col-md-6">
        <?php echo Form::label('account_holder_name', __('Account Holder Name'),['class'=>'form-control-label']); ?>

        <?php echo Form::text('account_holder_name', old('account_holder_name'), ['class' => 'form-control']); ?>


    </div>
    <div class="form-group col-md-6">
        <?php echo Form::label('account_number', __('Account Number'),['class'=>'form-control-label']); ?>

        <?php echo Form::number('account_number', old('account_number'), ['class' => 'form-control']); ?>


    </div>
    <div class="form-group col-md-6">
        <?php echo Form::label('bank_name', __('Bank Name'),['class'=>'form-control-label']); ?>

        <?php echo Form::text('bank_name', old('bank_name'), ['class' => 'form-control']); ?>


    </div>
    <div class="form-group col-md-6">
        <?php echo Form::label('bank_identifier_code', __('Bank Identifier Code'),['class'=>'form-control-label']); ?>

        <?php echo Form::text('bank_identifier_code',old('bank_identifier_code'), ['class' => 'form-control']); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo Form::label('branch_location', __('Branch Location'),['class'=>'form-control-label']); ?>

        <?php echo Form::text('branch_location',old('branch_location'), ['class' => 'form-control']); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo Form::label('tax_payer_id', __('Tax Payer Id'),['class'=>'form-control-label']); ?>

        <?php echo Form::text('tax_payer_id',old('tax_payer_id'), ['class' => 'form-control']); ?>

    </div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="card card-fluid">
<div class="card-header"><h6 class="mb-0">Additional Details</h6></div>
<div class="card-body employee-detail-create-body">
<div class="row">
    <input type="hidden" name="field_count" class="form-control" value="<?php echo count($fields); ?>">
    <?php foreach ($fields as $value) {
      ?>
    <div class="form-group col-md-6">
        <label class="form-control-label" for="fields"><?php echo e($value->field_name); ?></label>
        <?php if ($value->type=='file') {
            ?>
             <div class="choose-file form-group">

                <label for="document" class="form-control-label">
                    <div>Choose file here</div>
                     <input type="<?php echo $value->type; ?>" name="fields[value][]" class="form-control">
                </label>
                <p class="document_create"></p>
            </div>
           <!--  <input type="<?php echo $value->type; ?>" name="fields[value][]" class="form-control"> --><?php
        }
        else if ($value->type=='radio') {
            ?><div class="row"><?php
            foreach ($fields_atribute as $atribute) {
                if ($atribute->field_id==$value->id) {
                 ?>
            <div class="d-flex radio-check">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="<?php echo e($atribute->option_name); ?>" value="<?php echo e($atribute->option_value); ?>" name="fields[value_<?php echo e($value->id); ?>]" class="custom-control-input">
                    <label class="custom-control-label" for="<?php echo e($atribute->option_name); ?>"><?php echo e($atribute->option_name); ?></label>
                </div>
            </div>
    
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
                    <input type="checkbox" id="<?php echo e($atribute->option_name); ?>" value="<?php echo e($atribute->option_value); ?>" name="fields[value_<?php echo e($value->id); ?>]" class="custom-control-input">
                    <label class="custom-control-label" for="<?php echo e($atribute->option_name); ?>"><?php echo e($atribute->option_name); ?></label>
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
            <select class="form-control select2-multiple" id="<?php echo e($atribute->option_name); ?>" name="fields[value_<?php echo e($value->id); ?>]" data-toggle="select2" data-placeholder="<?php echo e(__('Select...')); ?>" style="border-radius: 10px;height: 40px;box-shadow: none;line-height: 40px;font-size: 12px;font-family: 'Montserrat-SemiBold';font-weight: normal;">   
            <?php
            foreach ($fields_atribute as $atribute) {
                if ($atribute->field_id==$value->id) {
            ?>
            <option value="<?php echo e($atribute->option_value); ?>"><?php echo e($atribute->option_name); ?></option>
        
            <?php
            }
          }
          ?>
          </select>
          </div><?php 
        }
        else{
            ?><!-- <input type="<?php echo $value->type; ?>" name="fields[value_][]" class="form-control"> -->
            <input type="<?php echo $value->type; ?>" name="fields[value_<?php echo e($value->id); ?>]" class="form-control"><?php
        } ?>
        
        <input type="hidden" name="fields[id][]" class="form-control" value="<?php echo $value->id; ?>">
        <input type="hidden" name="fields[name][]" class="form-control" value="<?php echo $value->field_name; ?>">
        <input type="hidden" name="fields[type][]" class="form-control" value="<?php echo $value->type; ?>">
        <input type="hidden" name="fields[mandatory][]" class="form-control" value="<?php echo $value->mandatory; ?>">            
       <!--  <?php echo Form::label('account_holder_name', __('Account Holder Name'),['class'=>'form-control-label']); ?>

        <?php echo Form::text('account_holder_name', old('account_holder_name'), ['class' => 'form-control']); ?> -->
    </div>
    <?php } ?>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12">
<?php echo Form::submit('Create', ['class' => 'btn btn-xs badge-blue float-right radius-10px']); ?>


<?php echo e(Form::close()); ?>

</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>

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
url: '<?php echo e(route('employee.json')); ?>',
type: 'POST',
data: {
"department_id": did, "_token": "<?php echo e(csrf_token()); ?>",
},
success: function (data) {
$('#designation_id').empty();
$('#designation_id').append('<option value=""><?php echo e(__('Select any Designation')); ?></option>');
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
});

$(document).on('change', 'select[name=company_client_id]', function () {

var company_id = $(this).val();
getCompanyUnit(company_id);
});

function getCompanyUnit(did) {
$.ajax({
url: '<?php echo e(route('employee.json_company_unit')); ?>',
type: 'POST',
data: {
"company_id": did, "_token": "<?php echo e(csrf_token()); ?>",
},
success: function (data) {
$('#company_client_unit_id').empty();
$('#company_client_unit_id').append('<option value=""><?php echo e(__('Select any Company Unit')); ?></option>');
$.each(data, function (key, value) {
    $('#company_client_unit_id').append('<option value="' + key + '">' + value + '</option>');
});
}
});
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jaysecurity\resources\views/employee/create.blade.php ENDPATH**/ ?>