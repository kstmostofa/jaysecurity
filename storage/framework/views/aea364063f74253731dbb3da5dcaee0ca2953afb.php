<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Plan Request')); ?>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                                <tr>
                                    <th> <?php echo e(__('User Name')); ?></th>
                                    <th> <?php echo e(__('Plan Name')); ?></th>
                                    <th> <?php echo e(__('Employees')); ?></th>
                                    <th> <?php echo e(__('Users')); ?></th>
                                    <th> <?php echo e(__('Duration')); ?></th>
                                    <th> <?php echo e(__('Created At')); ?></th>
                                    <th> <?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__currentLoopData = $plan_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="font-style">
                                        <td><?php echo e($prequest->user->name); ?></td>
                                        <td><?php echo e($prequest->plan->name); ?></td>
                                        <td><?php echo e($prequest->plan->max_employees); ?></td>
                                        <td><?php echo e($prequest->plan->max_users); ?></td>
                                        <td><?php echo e($prequest->duration); ?></td>
                                        <td><?php echo e($prequest->created_at); ?></td>
                                        <td class="action">
                                            <a href="<?php echo e(route('plan_request.update', $prequest->id)); ?>"
                                                class="btn btn-success mr-3">Approve
                                            </a>
                                            <a href="#" class="btn btn-danger" data-toggle="tooltip"
                                                data-original-title="<?php echo e(__('Delete')); ?>"
                                                data-confirm="<?php echo e(__('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?')); ?>"
                                                data-confirm-yes="document.getElementById('delete-form-<?php echo e($prequest->id); ?>').submit();">
                                                Reject
                                            </a>
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['plan_requests.destroy', $prequest->id], 'id' => 'delete-form-' . $prequest->id]); ?>

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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/plan_request/index.blade.php ENDPATH**/ ?>