<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Goal Tracking')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
    <style>
        @import  url(<?php echo e(asset('css/font-awesome.css')); ?>);
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('js/bootstrap-toggle.js')); ?>"></script>
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
            $("fieldset[id^='demo'] .stars").click(function () {
                alert($(this).val());
                $(this).attr("checked");
            });
        });

    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Goal Tracking')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="#" data-url="<?php echo e(route('goaltracking.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="<?php echo e(__('Create New Goal Tracking')); ?>">
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
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                            <tr>
                                <th><?php echo e(__('Goal Type')); ?></th>
                                <th><?php echo e(__('Subject')); ?></th>
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('Target Achievement')); ?></th>
                                <th><?php echo e(__('Start Date')); ?></th>
                                <th><?php echo e(__('End Date')); ?></th>
                                <th><?php echo e(__('Rating')); ?></th>
                                <th width="20%"><?php echo e(__('Progress')); ?></th>
                                <?php if(Gate::check('Edit Goal Tracking') || Gate::check('Delete Goal Tracking')): ?>
                                    <th width="3%"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            <?php $__currentLoopData = $goalTrackings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goalTracking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td><?php echo e(!empty($goalTracking->goalType)?$goalTracking->goalType->name:''); ?></td>
                                    <td><?php echo e($goalTracking->subject); ?></td>
                                    <td><?php echo e(!empty($goalTracking->branches)?$goalTracking->branches->name:''); ?></td>
                                    <td><?php echo e($goalTracking->target_achievement); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($goalTracking->start_date)); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($goalTracking->end_date)); ?></td>
                                    <td>
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <?php if($goalTracking->rating < $i): ?>
                                                <i class="fas fa-star"></i>
                                            <?php else: ?>
                                                <i class="text-warning fas fa-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </td>
                                    <td>
                                        <div class="progress-wrapper">
                                            <span class="progress-percentage"><small class="font-weight-bold"></small><?php echo e($goalTracking->progress); ?>%</span>
                                            <div class="progress progress-xs mt-2 w-100">
                                                <div class="progress-bar bg-<?php echo e(Utility::getProgressColor($goalTracking->progress)); ?>" role="progressbar" aria-valuenow="<?php echo e($goalTracking->progress); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo e($goalTracking->progress); ?>%;"></div>
                                            </div>
                                        </div>

                                    </td class="text-right action-btns">
                                    <?php if( Gate::check('Edit Goal Tracking') ||Gate::check('Delete Goal Tracking')): ?>
                                        <td class="text-right action-btns">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Goal Tracking')): ?>
                                                <a href="#" data-url="<?php echo e(route('goaltracking.edit',$goalTracking->id)); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Goal Tracking')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Goal Tracking')): ?>
                                                <a href="#" class="delete-icon" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($goalTracking->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['goaltracking.destroy', $goalTracking->id],'id'=>'delete-form-'.$goalTracking->id]); ?>

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




<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/goaltracking/index.blade.php ENDPATH**/ ?>