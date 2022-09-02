<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Indicator')); ?>

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

        $(document).ready(function () {
            var d_id = $('#department_id').val();
            getDesignation(d_id);
        });

        $(document).on('change', 'select[name=department]', function () {
            var department_id = $(this).val();
            getDesignation(department_id);
        });

        function getDesignation(did) {
            $.ajax({
                url: '<?php echo e(route('employee.json')); ?>',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {
                    $('#designation_id').empty();
                    $('#designation_id').append('<option value=""><?php echo e(__('Select Designation')); ?></option>');
                    $.each(data, function (key, value) {
                        $('#designation_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Indicator')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="#" data-url="<?php echo e(route('indicator.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="<?php echo e(__('Create New Indicator')); ?>">
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
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('Department')); ?></th>
                                <th><?php echo e(__('Designation')); ?></th>
                                <th><?php echo e(__('Overall Rating')); ?></th>
                                <th><?php echo e(__('Added By')); ?></th>
                                <th><?php echo e(__('Created At')); ?></th>
                                <?php if( Gate::check('Edit Indicator') ||Gate::check('Delete Indicator') ||Gate::check('Show Indicator')): ?>
                                    <th width="3%"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            <?php $__currentLoopData = $indicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    if(!empty($indicator->rating)){
                                        $rating = json_decode($indicator->rating,true);
                                      if(!empty($rating)){
                                            $starsum = array_sum($rating);
                                            $overallrating = $starsum/count($rating);
                                        }else{
                                            $overallrating = 0;
                                        }
                                    }
                                    else{
                                        $overallrating = 0;
                                    }
                                ?>
                                <tr>
                                    <td><?php echo e(!empty($indicator->branches)?$indicator->branches->name:''); ?></td>
                                    <td><?php echo e(!empty($indicator->departments)?$indicator->departments->name:''); ?></td>
                                    <td><?php echo e(!empty($indicator->designations)?$indicator->designations->name:''); ?></td>
                                    <td>

                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <?php if($overallrating < $i): ?>
                                                <?php if(is_float($overallrating) && (round($overallrating) == $i)): ?>
                                                    <i class="text-warning fas fa-star-half-alt"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-star"></i>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <i class="text-warning fas fa-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <span class="theme-text-color">(<?php echo e(number_format($overallrating,1)); ?>)</span>
                                    </td>
                                    <td><?php echo e(!empty($indicator->user)?$indicator->user->name:''); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($indicator->created_at)); ?></td>
                                    <?php if( Gate::check('Edit Indicator') ||Gate::check('Delete Indicator') || Gate::check('Show Indicator')): ?>
                                        <td class="text-right action-btns">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Show Indicator')): ?>
                                                <a href="#" data-url="<?php echo e(route('indicator.show',$indicator->id)); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Indicator Detail')); ?>" class="edit-icon bg-success" data-toggle="tooltip" data-original-title="<?php echo e(__('View Detail')); ?>"><i class="fas fa-eye"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Indicator')): ?>
                                                <a href="#" data-url="<?php echo e(route('indicator.edit',$indicator->id)); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Indicator')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Indicator')): ?>
                                                <a href="#" class="delete-icon" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($indicator->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['indicator.destroy', $indicator->id],'id'=>'delete-form-'.$indicator->id]); ?>

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




<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/indicator/index.blade.php ENDPATH**/ ?>