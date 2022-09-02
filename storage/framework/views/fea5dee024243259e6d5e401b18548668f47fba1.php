<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Zoom Meeting')); ?>

<?php $__env->stopSection(); ?>

<style>
    .ranges {
        display: none;
    }

</style>


<?php $__env->startSection('action-button'); ?>

    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12 col-12">
        <div class="all-button-box">
            <a href="<?php echo e(route('zoom_meeting.calender')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto"><i
                    class="far fa-calendar-alt"></i> <?php echo e(__('Calendar View')); ?> </a>
        </div>
    </div>

    <?php if(\Auth::user()->type == 'company'): ?>
        <a href="#" data-url="<?php echo e(route('zoom-meeting.create')); ?>" data-size="xl" data-ajax-popup="true"
            data-title="<?php echo e(__('Create New Zoom Meeting')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto">
            <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

        </a>
    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center dataTable">
                <thead>
                    <tr>
                        <th><?php echo e(__('Title')); ?></th>
                        <th><?php echo e(__('Meeting Time')); ?></th>
                        <th><?php echo e(__('Duration')); ?></th>
                        <th><?php echo e(__('User')); ?></th>
                        <th><?php echo e(__('Join URL')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th class="text-right" width="3%"> <?php echo e(__('Action')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $ZoomMeetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ZoomMeeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($ZoomMeeting->title); ?></td>
                            <td><?php echo e($ZoomMeeting->start_date); ?></td>
                            <td><?php echo e($ZoomMeeting->duration); ?> <?php echo e(__(' Minute')); ?></td>

                            <td>
                                <div class="avatar-group">
                                    <?php $__currentLoopData = $ZoomMeeting->users($ZoomMeeting->user_id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projectUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="#" class="avatar rounded-circle avatar-sm avatar-group">
                                            <img alt="" <?php if(!empty($users->avatar)): ?> src="<?php echo e($profile . '/' . $projectUser->avatar); ?>" <?php else: ?>  avatar="<?php echo e(!empty($projectUser) ? $projectUser->name : ''); ?>" <?php endif; ?>
                                                data-original-title="<?php echo e(!empty($projectUser) ? $projectUser->name : ''); ?>"
                                                data-toggle="tooltip"
                                                data-original-title="<?php echo e(!empty($projectUser) ? $projectUser->name : ''); ?>"
                                                class="">
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </td>

                            <td>
                                <?php if($ZoomMeeting->created_by == \Auth::user()->id && $ZoomMeeting->checkDateTime()): ?>
                                    <a href="<?php echo e($ZoomMeeting->start_url); ?>" target="_blank"> <?php echo e(__('Start meeting')); ?> <i
                                            class="fas fa-external-link-square-alt "></i></a>
                                <?php elseif($ZoomMeeting->checkDateTime()): ?>
                                    <a href="<?php echo e($ZoomMeeting->join_url); ?>" target="_blank"> <?php echo e(__('Join meeting')); ?> <i
                                            class="fas fa-external-link-square-alt "></i></a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if($ZoomMeeting->checkDateTime()): ?>
                                    <?php if($ZoomMeeting->status == 'waiting'): ?>
                                        <span class="badge badge-info"><?php echo e(ucfirst($ZoomMeeting->status)); ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-success"><?php echo e(ucfirst($ZoomMeeting->status)); ?></span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge badge-danger"><?php echo e(__('End')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-right">
                                <div class="actions ml-3 rtl-actions">
                                    

                                    <a href="#" class="action-item text-danger mr-2 emp_delete delete-icon" data-toggle="tooltip"
                                        data-original-title="<?php echo e(__('Delete')); ?>"
                                        data-confirm="<?php echo e(__('Are You Sure?')); ?>|<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                        data-confirm-yes="document.getElementById('delete-form-<?php echo e($ZoomMeeting->id); ?>').submit();">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['zoom-meeting.destroy', $ZoomMeeting->id], 'id' => 'delete-form-' . $ZoomMeeting->id]); ?>

                                    <?php echo Form::close(); ?>

                                    <span class="clearfix"></span>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script>
        function ddatetime_range() {
            $('.datetime_class_start_date').daterangepicker({
                "singleDatePicker": true,
                "timePicker": true,
                "autoApply": false,
                "locale": {
                    "format": 'YYYY-MM-DD H:mm'
                },
                "timePicker24Hour": true,
            }, function(start, end, label) {
                $('.start_date').val(start.format('YYYY-MM-DD H:mm'));
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/zoom_meeting/index.blade.php ENDPATH**/ ?>