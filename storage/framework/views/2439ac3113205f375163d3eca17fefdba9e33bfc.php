<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Appraisal')); ?>

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
            var employee = $('#employee').val();
            getEmployee(employee);
        });

        $(document).on('change', 'select[name=branch]', function () {
            var branch = $(this).val();
            getEmployee(branch);
        });

        function getEmployee(did) {
            $.ajax({
                url: '<?php echo e(route('branch.employee.json')); ?>',
                type: 'POST',
                data: {
                    "branch": did, "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {
                    $('#employee').empty();
                    $('#employee').append('<option value=""><?php echo e(__('Select Branch')); ?></option>');
                    $.each(data, function (key, value) {
                        $('#employee').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }


    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Appraisal')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
            <a href="#" data-url="<?php echo e(route('appraisal.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="<?php echo e(__('Create New Appraisal')); ?>">
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
                                <th><?php echo e(__('Department')); ?></th>
                                <th><?php echo e(__('Designation')); ?></th>
                                <th><?php echo e(__('Employee')); ?></th>
                                <th><?php echo e(__('Overall Rating')); ?></th>
                                <th><?php echo e(__('Appraisal Date')); ?></th>
                                <?php if( Gate::check('Edit Appraisal') ||Gate::check('Delete Appraisal') ||Gate::check('Show Appraisal')): ?>
                                    <th width="3%"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            <?php $__currentLoopData = $appraisals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appraisal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    if(!empty($appraisal->rating)){
                                        $rating = json_decode($appraisal->rating,true);
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
                                    <td><?php echo e(!empty($appraisal->branches)?$appraisal->branches->name:''); ?></td>
                                    <td><?php echo e(!empty($appraisal->employees)?!empty($appraisal->employees->department)?$appraisal->employees->department->name:'':''); ?></td>
                                    <td><?php echo e(!empty($appraisal->employees)?!empty($appraisal->employees->designation)?$appraisal->employees->designation->name:'':''); ?></td>
                                    <td><?php echo e(!empty($appraisal->employees)?$appraisal->employees->name:''); ?></td>
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
                                    <td><?php echo e($appraisal->appraisal_date); ?></td>
                                    <?php if( Gate::check('Edit Appraisal') ||Gate::check('Delete Appraisal') ||Gate::check('Show Appraisal')): ?>
                                        <td class="text-right action-btns">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Show Appraisal')): ?>
                                                <a href="#" data-url="<?php echo e(route('appraisal.show',$appraisal->id)); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Appraisal Detail')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('View Detail')); ?>" class="edit-icon bg-success"><i class="fas fa-eye"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Appraisal')): ?>
                                                <a href="#" data-url="<?php echo e(route('appraisal.edit',$appraisal->id)); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Appraisal')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>" class="edit-icon"><i class="fas fa-pencil-alt"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Appraisal')): ?>
                                                <a href="#" class="delete-icon" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($appraisal->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['appraisal.destroy', $appraisal->id],'id'=>'delete-form-'.$appraisal->id]); ?>

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




<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/appraisal/index.blade.php ENDPATH**/ ?>