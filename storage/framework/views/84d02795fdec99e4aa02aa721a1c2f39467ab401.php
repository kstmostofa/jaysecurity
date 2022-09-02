<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Job')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>

        $('.copy_link').click(function (e) {
            e.preventDefault();
            var copyText = $(this).attr('href');

            document.addEventListener('copy', function (e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);

            document.execCommand('copy');
            show_toastr('Success', 'Url copied to clipboard', 'success');
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Job')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="<?php echo e(route('job.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto" data-title="<?php echo e(__('Create New Job')); ?>">
                    <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

                </a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="card card-box">
                <div class="left-card">
                    <div class="icon-box"><i class="fas fa-users"></i></div>
                    <h4><?php echo e(__('Total Jobs')); ?></h4>
                </div>
                <div class="number-icon"><?php echo e($data['total']); ?></div>
            </div>

        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="card card-box">
                <div class="left-card">
                    <div class="icon-box green-bg"><i class="fas fa-tag"></i></div>
                    <h4><?php echo e(__('Active Jobs')); ?></h4>
                </div>
                <div class="number-icon"><?php echo e($data['active']); ?></div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="card card-box">
                <div class="left-card">
                    <div class="icon-box red-bg"><i class="fas fa-money-bill"></i></div>
                    <h4><?php echo e(__('Inactive Jobs')); ?></h4>
                </div>
                <div class="number-icon"><?php echo e($data['in_active']); ?></div>
            </div>

        </div>
    </div>
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                            <tr>
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('Title')); ?></th>
                                <th><?php echo e(__('Start Date')); ?></th>
                                <th><?php echo e(__('End Date')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Created At')); ?></th>
                                <?php if( Gate::check('Edit Job') ||Gate::check('Delete Job') ||Gate::check('Show Job')): ?>
                                     <th width="3%"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(!empty($job->branches)?$job->branches->name:__('All')); ?></td>
                                    <td><?php echo e($job->title); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($job->start_date)); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($job->end_date)); ?></td>
                                    <td>
                                        <?php if($job->status=='active'): ?>
                                            <span class="badge badge-success"><?php echo e(App\Models\Job::$status[$job->status]); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-danger"><?php echo e(App\Models\Job::$status[$job->status]); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e(\Auth::user()->dateFormat($job->created_at)); ?></td>
                                    <?php if( Gate::check('Edit Job') ||Gate::check('Delete Job') || Gate::check('Show Job')): ?>
                                        <td>
                                            <?php if($job->status!='in_active'): ?>
                                                <a href="<?php echo e(route('job.requirement',[$job->code,!empty($job)?$job->createdBy->lang:'en'])); ?>" class="edit-icon bg-info copy_link" data-toggle="tooltip" data-original-title="<?php echo e(__('Click to copy')); ?>"><i class="fas fa-link"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Show Job')): ?>
                                                <a href="<?php echo e(route('job.show',$job->id)); ?>" data-title="<?php echo e(__('Job Detail')); ?>" class="edit-icon bg-success" data-toggle="tooltip" data-original-title="<?php echo e(__('View Detail')); ?>"><i class="fas fa-eye"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Job')): ?>
                                                <a href="<?php echo e(route('job.edit',$job->id)); ?>" data-title="<?php echo e(__('Edit Job')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Job')): ?>
                                                <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($job->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['job.destroy', $job->id],'id'=>'delete-form-'.$job->id]); ?>

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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/job/index.blade.php ENDPATH**/ ?>