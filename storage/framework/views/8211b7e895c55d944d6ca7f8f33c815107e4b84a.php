

<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Manage Employee Field')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
<div class="all-button-box row d-flex justify-content-end">
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Branch')): ?>
<div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
<a href="#" data-url="<?php echo e(route('employee-field.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="<?php echo e(__('Create New Field ')); ?>">
<i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

</a>
</div>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-body py-0">
<div class="table-responsive">
<table class="table table-striped mb-0 dataTable" >
<thead>
<tr>
<th><?php echo e(__('Name')); ?></th>
<th>Type </th>
<th>Status</th>
<th>Mandatory field / not </th>
<th width="200px"><?php echo e(__('Action')); ?></th>
</tr>
</thead>
<tbody class="font-style">
<?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
<td><?php echo e($field->field_name); ?></td>
<td><?php echo e($field->type); ?></td>
<td><?php echo e($field->status); ?></td>
<td><?php echo e($field->mandatory); ?></td>
<td class="Action text-right">
    
    <span>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Branch')): ?>
            <a href="#" class="edit-icon" data-url="<?php echo e(URL::to('employee-field/'.$field->id.'/edit')); ?> " data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Employee field')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Branch')): ?>
            <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($field->id); ?>').submit();"><i class="fas fa-trash"></i></a>
            <?php echo Form::open(['method' => 'DELETE', 'route' => ['employee-field.destroy', $field->id],'id'=>'delete-form-'.$field->id]); ?>

            <?php echo Form::close(); ?>

        <?php endif; ?>
    </span>
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/employee_field/index.blade.php ENDPATH**/ ?>