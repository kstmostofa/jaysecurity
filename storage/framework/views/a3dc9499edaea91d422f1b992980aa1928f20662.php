
<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Create Salary')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
<?php echo e(Form::model($salary, array('route' => array('salary.update', $salary->id), 'method' => 'PUT' , 'enctype' => 'multipart/form-data'))); ?>

<?php echo csrf_field(); ?>
</div>
<div class="row">
<div class="col-md-6 ">
<div class="card card-fluid">
<div class="card-header"><h6 class="mb-0"><?php echo e(__('Personal Detail')); ?></h6></div>
<div class="card-body ">
<div class="row">
    <div class="form-group col-md-6">
        <?php echo Form::label('name', __('Name'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
        <?php echo Form::text('name', old('name'),  ['class' => 'form-control','required' => 'required']); ?>

    </div>
    <!-- <div class="form-group col-md-6">
        <?php echo Form::label('role', __('Role'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
        <?php echo Form::text('role',old('role'), ['class' => 'form-control']); ?>

    </div> -->
    <div class="form-group  col-lg-6 col-md-6">
                <?php echo e(Form::label('role', __('User Role'),['class'=>'form-control-label'])); ?>

                <?php echo Form::select('role', $roles, $salary->role_id,array('class' => 'form-control select2','required'=>'required')); ?>

                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-role" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo Form::label('amt', __('Amt'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
            <?php echo Form::text('amt', old('amt'), ['class' => 'form-control']); ?>

        </div>
    </div>

    <div class="col-md-6 ">
        <div class="form-group ">
            <?php echo Form::label('is_active', __('Is Active'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
            <div class="d-flex radio-check">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="active_" value="1" name="is_active" class="custom-control-input" <?php echo e(($salary->is_active == '1')?'checked':''); ?>>
                    <label class="custom-control-label" for="active_"><?php echo e(__('Active')); ?></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="active_not" value="0" name="is_active" class="custom-control-input" <?php echo e(($salary->is_active == '0')?'checked':''); ?>>
                    <label class="custom-control-label" for="active_not"><?php echo e(__('Active Not')); ?></label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group col-md-6">
       <!--  <?php echo Form::label('Start Date', __('Start Date'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span> -->
            <?php echo Form::hidden('start_date', old('start_date'), ['class' => 'form-control datepicker']); ?>

    </div>
    
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
    
    <div class="form-group col-md-6">
        <?php echo e(Form::label('companyclient_id', __('Company Client'),['class'=>'form-control-label'])); ?>

        <?php echo e(Form::select('company_client_id', $company_client,null, array('class' => 'form-control  select2','id'=>'company_client_id','required'=>'required'))); ?>

    </div>
    
     <div class="form-group col-md-6">
        <?php echo e(Form::label('company_client_unit_id', __('Company Client Unit'),['class'=>'form-control-label'])); ?>

        <?php echo e(Form::select('company_client_unit_id', $company_client_unit,null, array('class' => 'form-control  select2','id'=>'company_client_unit_id','required'=>'required'))); ?>

    </div>
   <div class="form-group col-md-6">
    <?php echo e(Form::label('designation_id', __('Designation'),['class'=>'form-control-label'])); ?>

    <select class="select2 form-control select2-multiple" id="designation_id" name="designation_id" data-toggle="select2" data-placeholder="<?php echo e(__('Select Designation ...')); ?>">
        <option value=""><?php echo e(__('Select any Designation')); ?></option>
    </select>
</div>

    <!-- <div class="form-group col-md-6">
        <?php echo e(Form::label('company_client_unit_id', __('Company Client Unit'),['class'=>'form-control-label'])); ?>

        <select class="select2 form-control select2-multiple" id="company_client_unit_id" name="company_client_unit_id" data-toggle="select2" data-placeholder="<?php echo e(__('Select Company Unit ...')); ?>">
            <option value=""><?php echo e(__('Select any Company Unit')); ?></option>
        </select>
    </div> -->
   
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
get_designation();
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
function get_designation() {
$.ajax({
url: '<?php echo e(route('employee.designation.json')); ?>',
type: 'POST',
data: {
 "_token": "<?php echo e(csrf_token()); ?>",
},
success: function (data) {
$('#designation_id').empty();
$('#designation_id').append('<option value="">Select any Designation</option>');
$.each(data, function (key, value) {
var select = '';
if (key == '<?php echo e($salary->designation_id); ?>') {
select = 'selected';
}

$('#designation_id').append('<option value="' + key + '"  ' + select + '>' + value + '</option>');
});
}
});
}

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/salary/edit.blade.php ENDPATH**/ ?>