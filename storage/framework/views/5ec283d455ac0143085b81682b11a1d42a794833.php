<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Transfer')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Transfer')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
            <a href="#" data-url="<?php echo e(route('transfer.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="<?php echo e(__('Create New Transfer')); ?>">
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
                                <?php if(auth()->check() && auth()->user()->hasRole('company')): ?>
                                <th><?php echo e(__('Employee Name')); ?></th>
                                <?php endif; ?>
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('Department')); ?></th>
                                <th><?php echo e(__('Transfer Date')); ?></th>
                                <th><?php echo e(__('Description')); ?></th>
                                <?php if(Gate::check('Edit Transfer') || Gate::check('Delete Transfer')): ?>
                                     <th width="3%"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            <?php $__currentLoopData = $transfers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transfer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php if(auth()->check() && auth()->user()->hasRole('company')): ?>
                                    <td><?php echo e(!empty($transfer->employee())?$transfer->employee()->name:''); ?></td>
                                    <?php endif; ?>
                                    <td><?php echo e(!empty($transfer->branch())?$transfer->branch()->name:''); ?></td>
                                    <td><?php echo e(!empty($transfer->department())?$transfer->department()->name:''); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($transfer->transfer_date)); ?></td>
                                    <td><?php echo e($transfer->description); ?></td>
                                    <?php if(Gate::check('Edit Transfer') || Gate::check('Delete Transfer')): ?>
                                        <td class="text-right action-btns">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Transfer')): ?>
                                                <a href="#" data-url="<?php echo e(URL::to('transfer/'.$transfer->id.'/edit')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Transfer')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Transfer')): ?>
                                                <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($transfer->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['transfer.destroy', $transfer->id],'id'=>'delete-form-'.$transfer->id]); ?>

                                                <?php echo Form::close(); ?>

                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/transfer/index.blade.php ENDPATH**/ ?>