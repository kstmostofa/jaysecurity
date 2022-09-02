<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Manage Employee Salary')); ?>

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
            <th><?php echo e(__('Employee Id')); ?></th>
            <th><?php echo e(__('Name')); ?></th>
            <th><?php echo e(__('Payroll Type')); ?></th>
            <th><?php echo e(__('Salary')); ?></th>
            <th><?php echo e(__('Net Salary')); ?></th>
             <th width="3%"><?php echo e(__('Action')); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="Id">
                    <a href="<?php echo e(route('setsalary.show',$employee->id)); ?>"  data-toggle="tooltip" data-original-title="<?php echo e(__('View')); ?>">
                        <?php echo e(\Auth::user()->employeeIdFormat($employee->employee_id)); ?>

                    </a>
                </td>
                <td><?php echo e($employee->name); ?></td>
                <td><?php echo e($employee->salary_type()); ?></td>
                <td><?php echo e(\Auth::user()->priceFormat($employee->salary)); ?></td>
                <td><?php echo e(!empty($employee->get_net_salary()) ?\Auth::user()->priceFormat($employee->get_net_salary()):''); ?></td>
                <td>
                    <a href="<?php echo e(route('setsalary.show',$employee->id)); ?>" class="edit-icon bg-success" data-toggle="tooltip" data-original-title="<?php echo e(__('View')); ?>">
                        <i class="fas fa-eye"></i>
                    </a>
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



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/setsalary/index.blade.php ENDPATH**/ ?>