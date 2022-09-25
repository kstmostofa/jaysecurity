<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Deposite')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Deposit')): ?>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
            <a href="#" data-url="<?php echo e(route('deposit.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="<?php echo e(__('Create New Deposit')); ?>">
                <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

            </a>
            </div>
        <?php endif; ?>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
            <a href="<?php echo e(route('deposite.export')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto">
                <i class="fa fa-file-excel"></i> <?php echo e(__('Export')); ?>

            </a>
        </div>
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
                                <th><?php echo e(__('Account')); ?></th>
                                <th><?php echo e(__('Payer')); ?></th>
                                <th><?php echo e(__('Amount')); ?></th>
                                <th><?php echo e(__('Category')); ?></th>
                                <th><?php echo e(__('Ref#')); ?></th>
                                <th><?php echo e(__('Payment')); ?></th>
                                <th><?php echo e(__('Date')); ?></th>
                                <th width="3%"><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            <?php $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(!empty($deposit->account($deposit->account_id))?$deposit->account($deposit->account_id)->account_name:''); ?></td>
                                    <td><?php echo e(!empty( $deposit->payer($deposit->payer_id))? $deposit->payer($deposit->payer_id)->payer_name:''); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat( $deposit->amount)); ?></td>
                                    <td><?php echo e(!empty($deposit->income_category($deposit->income_category_id))?$deposit->income_category($deposit->income_category_id)->name:''); ?></td>
                                    <td><?php echo e($deposit->referal_id); ?></td>
                                    <td><?php echo e(!empty($deposit->payment_type($deposit->payment_type_id))?$deposit->payment_type($deposit->payment_type_id)->name:''); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($deposit->date)); ?></td>

                                    <td class="text-right action-btns">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Deposit')): ?>
                                            <a href="#" data-url="<?php echo e(URL::to('deposit/'.$deposit->id.'/edit')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Deposit')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Deposit')): ?>
                                            <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($deposit->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['deposit.destroy', $deposit->id],'id'=>'delete-form-'.$deposit->id]); ?>

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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/deposit/index.blade.php ENDPATH**/ ?>