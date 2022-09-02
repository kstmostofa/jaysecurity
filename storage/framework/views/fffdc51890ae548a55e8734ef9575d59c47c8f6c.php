<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Employee Set Salary')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-12">
<div class="row">
<div class="col-md-6">
<div class="card min-height-253">
<div class="card-header">
<div class="row">
    <div class="col">
        <h6 class="mb-0"><?php echo e(__('Employee Salary')); ?></h6>
    </div> 
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Set Salary')): ?>
        <div class="col text-right">
            <a href="#" data-url="<?php echo e(route('employee.basic.salary',$employee->id)); ?>" data-size="md" data-ajax-popup="true" data-title="<?php echo e(__('Set Basic Sallary')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Basic Salary')); ?>" class="apply-btn">
                <i class="fa fa-plus"></i>
            </a>
        </div>
    <?php endif; ?>
</div>
</div>
<div class="card-body">
<div class="project-info d-flex text-sm">
    <div class="project-info-inner mr-3 col-6">
        <b class="m-0"> <?php echo e(__('Payslip Type')); ?> </b>
        <div class="project-amnt pt-1"><?php echo e($employee->salary_type()); ?></div>
    </div>
    <div class="project-info-inner mr-3 col-6">
        <b class="m-0"> <?php echo e(__('Salary')); ?> </b>
        <div class="project-amnt pt-1"><?php echo e($employee->salary); ?></div>
    </div>
</div>
</div>
</div>
</div>
<div class="col-md-6">
<div class="card ">
<div class="card-header ">
<div class="row">
    <div class="col">
        <h6 class="mb-0"><?php echo e(__('Allowance')); ?></h6>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Allowance')): ?>
        <div class="col text-right">
            <a href="#" data-url="<?php echo e(route('allowances.create',$employee->id)); ?>" data-size="md" data-ajax-popup="true" data-title="<?php echo e(__('Create Allowance')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Create Allowance')); ?>" class="apply-btn">
                <i class="fa fa-plus"></i>
            </a>
        </div>
    <?php endif; ?>
</div>
</div>
<div class="table-responsive">
<table class="table table-striped mb-0">
    <thead>
    <tr>
        <th><?php echo e(__('Employee Name')); ?></th>
        <th><?php echo e(__('Allownace Option')); ?></th>
        <th><?php echo e(__('Title')); ?></th>
        <th><?php echo e(__('Amount')); ?></th>
        <th><?php echo e(__('Action')); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $allowances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allowance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e(!empty($allowance->employee())?$allowance->employee()->name:''); ?></td>
            <td><?php echo e(!empty($allowance->allowance_option())?$allowance->allowance_option()->name:''); ?></td>
            <td><?php echo e($allowance->title); ?></td>
            <td><?php echo e(\Auth::user()->priceFormat($allowance->amount)); ?></td>
            <td>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Allowance')): ?>
                    <a href="#" data-url="<?php echo e(URL::to('allowance/'.$allowance->id.'/edit')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Allowance')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Allowance')): ?>
                    <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('allowance-delete-form-<?php echo e($allowance->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['allowance.destroy', $allowance->id],'id'=>'allowance-delete-form-'.$allowance->id]); ?>

                    <?php echo Form::close(); ?>

                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
</div>
</div>
</div>
<!-- <div class="col-md-6">
<div class="card">
<div class="card-header">
<div class="row">
    <div class="col">
        <h6 class="mb-0"><?php echo e(__('Commission')); ?></h6>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Commission')): ?>
        <div class="col text-right">
            <a href="#" data-url="<?php echo e(route('commissions.create',$employee->id)); ?>" data-size="md" data-ajax-popup="true" data-title="<?php echo e(__('Create Commission')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Create Commission')); ?>" class="apply-btn">
                <i class="fa fa-plus"></i>
            </a>
        </div>
    <?php endif; ?>
</div>
</div>
<div class="table-responsive">
<table class="table table-striped mb-0">
    <thead>
    <tr>
        <th><?php echo e(__('Employee Name')); ?></th>
        <th><?php echo e(__('Title')); ?></th>
        <th><?php echo e(__('Amount')); ?></th>
        <th><?php echo e(__('Action')); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $commissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e(!empty($commission->employee())?$commission->employee()->name:''); ?></td>
            <td><?php echo e($commission->title); ?></td>
            <td><?php echo e(\Auth::user()->priceFormat( $commission->amount)); ?></td>
            <td class="text-right">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Commission')): ?>
                    <a href="#" data-url="<?php echo e(URL::to('commission/'.$commission->id.'/edit')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Commission')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Commission')): ?>
                    <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('commission-delete-form-<?php echo e($commission->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['commission.destroy', $commission->id],'id'=>'commission-delete-form-'.$commission->id]); ?>

                    <?php echo Form::close(); ?>

                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
</div>
</div>
</div> -->
<div class="col-md-6">
<div class="card">
<div class="card-header">
<div class="row">
    <div class="col">
        <h6 class="mb-0"><?php echo e(__('Loan')); ?></h6>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Loan')): ?>
        <div class="col text-right">
            <a href="#" data-url="<?php echo e(route('loans.create',$employee->id)); ?>" data-size="md" data-ajax-popup="true" data-title="<?php echo e(__('Create Loan')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Create Loan')); ?>" class="apply-btn">
                <i class="fa fa-plus"></i>
            </a>
        </div>
    <?php endif; ?>
</div>
</div>
<div class="table-responsive">
<table class="table table-striped mb-0">
    <thead>
    <tr>
        <th><?php echo e(__('Employee')); ?></th>
        <th><?php echo e(__('Loan Options')); ?></th>
        <th><?php echo e(__('Title')); ?></th>
        <th><?php echo e(__('Loan Amount')); ?></th>
        <th><?php echo e(__('Start Date')); ?></th>
        <th><?php echo e(__('End Date')); ?></th>
        <th><?php echo e(__('Action')); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e(!empty($loan->employee())?$loan->employee()->name:''); ?></td>
            <td><?php echo e(!empty( $loan->loan_option())? $loan->loan_option()->name:''); ?></td>
            <td><?php echo e($loan->title); ?></td>
            <td><?php echo e(\Auth::user()->priceFormat($loan->amount)); ?></td>
            <td><?php echo e(\Auth::user()->dateFormat($loan->start_date)); ?></td>
            <td><?php echo e(\Auth::user()->dateFormat( $loan->end_date)); ?></td>
            <td class="text-right">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Loan')): ?>
                    <a href="#" data-url="<?php echo e(URL::to('loan/'.$loan->id.'/edit')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Loan')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Loan')): ?>
                    <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('loan-delete-form-<?php echo e($loan->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['loan.destroy', $loan->id],'id'=>'loan-delete-form-'.$loan->id]); ?>

                    <?php echo Form::close(); ?>

                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
</div>
</div>
</div>
<div class="col-md-6">
<div class="card">
<div class="card-header">
<div class="row">
    <div class="col">
        <h6 class="mb-0"><?php echo e(__('Saturation Deduction')); ?></h6>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Saturation Deduction')): ?>
        <div class="col text-right">
            <a href="#" data-url="<?php echo e(route('saturationdeductions.create',$employee->id)); ?>" data-size="md" data-ajax-popup="true" data-title="<?php echo e(__('Create Saturation Deduction')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Create Saturation Deduction')); ?>" class="apply-btn">
                <i class="fa fa-plus"></i>
            </a>
        </div>
    <?php endif; ?>
</div>
</div>
<div class="table-responsive">
<table class="table table-striped mb-0">
    <thead>
    <tr>
        <th><?php echo e(__('Employee Name')); ?></th>
        <th><?php echo e(__('Deduction Option')); ?></th>
        <th><?php echo e(__('Title')); ?></th>
        <th><?php echo e(__('Amount')); ?></th>
        <th><?php echo e(__('Action')); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $saturationdeductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saturationdeduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e(!empty($saturationdeduction->employee())?$saturationdeduction->employee()->name:''); ?></td>
            <td><?php echo e(!empty($saturationdeduction->deduction_option())?$saturationdeduction->deduction_option()->name:''); ?></td>
            <td><?php echo e($saturationdeduction->title); ?></td>
            <td><?php echo e(\Auth::user()->priceFormat( $saturationdeduction->amount)); ?></td>
            <td class="text-right">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Saturation Deduction')): ?>
                    <a href="#" data-url="<?php echo e(URL::to('saturationdeduction/'.$saturationdeduction->id.'/edit')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Saturation Deduction')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Saturation Deduction')): ?>
                    <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('deduction-delete-form-<?php echo e($saturationdeduction->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['saturationdeduction.destroy', $saturationdeduction->id],'id'=>'deduction-delete-form-'.$saturationdeduction->id]); ?>

                    <?php echo Form::close(); ?>

                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
</div>
</div>
</div>
<div class="col-md-6">
<div class="card">
<div class="card-header">
<div class="row">
    <div class="col">
        <h6 class="mb-0"><?php echo e(__('Other Payment')); ?></h6>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Other Payment')): ?>
        <div class="col text-right">
            <a href="#" data-url="<?php echo e(route('otherpayments.create',$employee->id)); ?>" data-size="md" data-ajax-popup="true" data-title="<?php echo e(__('Create Other Payment')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Create Other Payment')); ?>" class="apply-btn">
                <i class="fa fa-plus"></i>
            </a>
        </div>
    <?php endif; ?>
</div>
</div>
<div class="table-responsive">
<table class="table table-striped mb-0">
    <thead>
    <tr>
        <th><?php echo e(__('Employee')); ?></th>
        <th><?php echo e(__('Title')); ?></th>
        <th><?php echo e(__('Amount')); ?></th>
        <th><?php echo e(__('Action')); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $otherpayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $otherpayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e(!empty($otherpayment->employee())?$otherpayment->employee()->name:''); ?></td>
            <td><?php echo e($otherpayment->title); ?></td>
            <td><?php echo e(\Auth::user()->priceFormat($otherpayment->amount)); ?></td>
            <td class="text-right">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Other Payment')): ?>
                    <a href="#" data-url="<?php echo e(URL::to('otherpayment/'.$otherpayment->id.'/edit')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Other Payment')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Other Payment')): ?>
                    <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('payment-delete-form-<?php echo e($otherpayment->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['otherpayment.destroy', $otherpayment->id],'id'=>'payment-delete-form-'.$otherpayment->id]); ?>

                    <?php echo Form::close(); ?>

                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
</div>
</div>
</div>
<div class="col-md-6">
<div class="card">
<div class="card-header">
<div class="row">
    <div class="col">
        <h6 class="mb-0"><?php echo e(__('Overtime')); ?></h6>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Overtime')): ?>
        <div class="col text-right">
            <a href="#" data-url="<?php echo e(route('overtimes.create',$employee->id)); ?>" data-size="md" data-ajax-popup="true" data-title="<?php echo e(__('Create Overtime')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Create Overtime')); ?>" class="apply-btn">
                <i class="fa fa-plus"></i>
            </a>
        </div>
    <?php endif; ?>
</div>
</div>
<div class="table-responsive">
<table class="table table-striped mb-0">
    <thead>
    <tr>
        <th><?php echo e(__('Employee Name')); ?></th>
        <th><?php echo e(__('Overtime Title')); ?></th>
        <th><?php echo e(__('Number of days')); ?></th>
        <th><?php echo e(__('Hours')); ?></th>
        <th><?php echo e(__('Rate')); ?></th>
        <th><?php echo e(__('Action')); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $overtimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overtime): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e(!empty($overtime->employee())?$overtime->employee()->name:''); ?></td>
            <td><?php echo e($overtime->title); ?></td>
            <td><?php echo e($overtime->number_of_days); ?></td>
            <td><?php echo e($overtime->hours); ?></td>
            <td><?php echo e(\Auth::user()->priceFormat($overtime->rate)); ?></td>
            <td class="text-right">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Overtime')): ?>
                    <a href="#" data-url="<?php echo e(URL::to('overtime/'.$overtime->id.'/edit')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit OverTime')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Overtime')): ?>
                    <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('overtime-delete-form-<?php echo e($overtime->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['overtime.destroy', $overtime->id],'id'=>'overtime-delete-form-'.$overtime->id]); ?>

                    <?php echo Form::close(); ?>

                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
</div>
</div>
</div>

</div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
<script type="text/javascript">

$(document).ready(function () {
var d_id = $('#department_id').val();
var designation_id = '<?php echo e($employee->designation_id); ?>';
getDesignation(d_id);


$("#allowance-dataTable").dataTable({
"columnDefs": [
{"sortable": false, "targets": [1]}
]
});

$("#commission-dataTable").dataTable({
"columnDefs": [
{"sortable": false, "targets": [1]}
]
});

$("#loan-dataTable").dataTable({
"columnDefs": [
{"sortable": false, "targets": [1]}
]
});

$("#saturation-deduction-dataTable").dataTable({
"columnDefs": [
{"sortable": false, "targets": [1]}
]
});

$("#other-payment-dataTable").dataTable({
"columnDefs": [
{"sortable": false, "targets": [1]}
]
});

$("#overtime-dataTable").dataTable({
"columnDefs": [
{"sortable": false, "targets": [1]}
]
});
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
var select = '';
if (key == '<?php echo e($employee->designation_id); ?>') {
select = 'selected';
}

$('#designation_id').append('<option value="' + key + '"  ' + select + '>' + value + '</option>');
});
}
});
}

///Add new
$(document).on('change', 'select[name=custom_type]', function () {
var custom_type = $(this).val();
if (custom_type=='1'){
   $('.salary').show();
   $('.salary_').hide(); 
}
else if(custom_type=='0'){
    $('.salary').hide();
    $('.salary_').show();
}
});
///
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/setsalary/employee_salary.blade.php ENDPATH**/ ?>