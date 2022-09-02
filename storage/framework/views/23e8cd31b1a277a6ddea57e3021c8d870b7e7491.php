
<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Manage Employee Salary')); ?>

<?php $__env->stopSection(); ?> 

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Employee')): ?>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="all-button-box">
                    <a href="<?php echo e(route('salary.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto">
                        <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

                    </a>
                </div>
            </div>
        <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
<div class="col-12">
<div class="card">
<div class="card-body py-0">
<div class="table-responsive">
<table class="table table-striped mb-0 dataTable" >
    <thead>
    <tr>
        <th><?php echo e(__('Name')); ?></th>
        <th><?php echo e(__('Company Client Id')); ?></th>
        <th><?php echo e(__('Company Client Unit Id')); ?></th>
        <th><?php echo e(__('Designation')); ?></th>
        <th><?php echo e(__('Amt')); ?></th>
        <th><?php echo e(__('is_active')); ?></th>
        <th><?php echo e(__('start_date')); ?></th>
        <th><?php echo e(__('end_data')); ?></th>
         <th width="3%"><?php echo e(__('Action')); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $salary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($sal->name); ?></td>
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
             <td>
                <?php 
                foreach ($designations as $key => $value) {
                        if ($key==$sal->designation_id) {
                           echo $value;
                        }
                } 
                ?></td>   
            </td>
            <td><?php echo e($sal->role_id); ?></td>
            <td><?php echo e($sal->amt); ?></td>
            <td><?php echo e($sal->is_active); ?></td>
            <td><?php echo e($sal->start_date); ?></td>
            <td><?php echo e($sal->end_date); ?></td>
            <td>
                    <a href="<?php echo e(route('salary.edit',$sal->id)); ?>" class="edit-icon bg-success" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="<?php echo e(route('salary.show',$sal->id)); ?>" class="edit-icon bg-success" data-toggle="tooltip" data-original-title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($sal->id); ?>').submit();"><i class="fas fa-trash"></i></a>
            <?php echo Form::open(['method' => 'DELETE', 'route' => ['salary.destroy', $sal->id],'id'=>'delete-form-'.$sal->id]); ?>

            <?php echo Form::close(); ?>

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



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/salary/index.blade.php ENDPATH**/ ?>