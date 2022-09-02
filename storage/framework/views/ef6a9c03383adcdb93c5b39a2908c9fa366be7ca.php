<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Company Policy')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Company Policy')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
            <a href="#" data-url="<?php echo e(route('company-policy.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="<?php echo e(__('Create New Company Policy')); ?>">
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
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('Title')); ?></th>
                                <th><?php echo e(__('Description')); ?></th>
                                <th><?php echo e(__('Attachment')); ?></th>
                                <?php if(Gate::check('Edit Company Policy') || Gate::check('Delete Company Policy')): ?>
                                    <th width="3%"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            <?php $__currentLoopData = $companyPolicy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $policy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $policyPath=asset(Storage::url('uploads/companyPolicy'));
                                ?>
                                <tr>
                                    <td><?php echo e(!empty($policy->branches)?$policy->branches->name:''); ?></td>
                                    <td><?php echo e($policy->title); ?></td>
                                    <td><?php echo e($policy->description); ?></td>
                                    <td>
                                        <?php if(!empty($policy->attachment)): ?>
                                            <a href="<?php echo e($policyPath.'/'.$policy->attachment); ?>" target="_blank">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        <?php else: ?>
                                            <p>-</p>
                                        <?php endif; ?>
                                    </td>
                                    <?php if(Gate::check('Edit Company Policy') || Gate::check('Delete Company Policy')): ?>
                                        <td class="text-right action-btns">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Company Policy')): ?>
                                                <a href="#" data-url="<?php echo e(route('company-policy.edit',$policy->id)); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Company Policy')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Company Policy')): ?>
                                                <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($policy->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['company-policy.destroy', $policy->id],'id'=>'delete-form-'.$policy->id]); ?>

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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/companyPolicy/index.blade.php ENDPATH**/ ?>