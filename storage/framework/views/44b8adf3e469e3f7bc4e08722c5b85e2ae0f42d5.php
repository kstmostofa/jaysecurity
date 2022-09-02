<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Account')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Account List')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
            <a href="#" data-url="<?php echo e(route('accountlist.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="<?php echo e(__('Create New Account')); ?>">
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
                                <th><?php echo e(__('Account Name')); ?></th>
                                <th><?php echo e(__('Initial Balance')); ?></th>
                                <th><?php echo e(__('Account Number')); ?></th>
                                <th><?php echo e(__('Branch Code')); ?></th>
                                <th><?php echo e(__('Bank Branch')); ?></th>
                                <th width="3%"><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            <?php $__currentLoopData = $accountlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountlist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($accountlist->account_name); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat($accountlist->initial_balance)); ?></td>
                                    <td><?php echo e($accountlist->account_number); ?></td>
                                    <td><?php echo e($accountlist->branch_code); ?></td>
                                    <td><?php echo e($accountlist->bank_branch); ?></td>
                                    <td class="text-right action-btns">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Account List')): ?>
                                            <a href="#" data-url="<?php echo e(URL::to('accountlist/'.$accountlist->id.'/edit')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Account List')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Account List')): ?>
                                            <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($accountlist->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['accountlist.destroy', $accountlist->id],'id'=>'delete-form-'.$accountlist->id]); ?>

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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/accountlist/index.blade.php ENDPATH**/ ?>