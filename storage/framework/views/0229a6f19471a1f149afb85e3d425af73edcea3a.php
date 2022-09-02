<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Create Job')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/summernote/summernote-bs4.css')); ?>">
    <link href="<?php echo e(asset('assets/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')); ?>" rel="stylesheet"/>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>

    <script src="<?php echo e(asset('assets/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')); ?>"></script>

    <script>
        var e = $('[data-toggle="tags"]');
        e.length && e.each(function () {
            $(this).tagsinput({tagClass: "badge badge-primary"})
        });


    </script>
    <script src="<?php echo e(asset('css/summernote/summernote-bs4.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo e(Form::open(array('url'=>'job','method'=>'post'))); ?>

    <div class="row">
        <div class="col-md-6 ">
            <div class="card card-fluid">
                <div class="card-body ">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <?php echo Form::label('title', __('Job Title'),['class'=>'form-control-label']); ?>

                            <?php echo Form::text('title', old('title'), ['class' => 'form-control','required' => 'required']); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo Form::label('branch', __('Branch'),['class'=>'form-control-label']); ?>

                            <?php echo e(Form::select('branch', $branches,null, array('class' => 'form-control select2','required'=>'required'))); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo Form::label('category', __('Job Category'),['class'=>'form-control-label']); ?>

                            <?php echo e(Form::select('category', $categories,null, array('class' => 'form-control select2','required'=>'required'))); ?>

                        </div>

                        <div class="form-group col-md-6">
                            <?php echo Form::label('position', __('Positions'),['class'=>'form-control-label']); ?>

                            <?php echo Form::text('position', old('positions'), ['class' => 'form-control','required' => 'required']); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo Form::label('status', __('Status'),['class'=>'form-control-label']); ?>

                            <?php echo e(Form::select('status', $status,null, array('class' => 'form-control select2','required'=>'required'))); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo Form::label('start_date', __('Start Date'),['class'=>'form-control-label']); ?>

                            <?php echo Form::text('start_date', old('start_date'), ['class' => 'form-control datepicker']); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo Form::label('end_date', __('End Date'),['class'=>'form-control-label']); ?>

                            <?php echo Form::text('end_date', old('end_date'), ['class' => 'form-control datepicker']); ?>

                        </div>
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" value="" data-toggle="tags" name="skill" placeholder="Skill"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="card card-fluid">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h6><?php echo e(__('Need to ask ?')); ?></h6>
                                <div class="my-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="applicant[]" value="gender" id="check-gender">
                                        <label class="custom-control-label" for="check-gender"><?php echo e(__('Gender')); ?> </label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="applicant[]" value="dob" id="check-dob">
                                        <label class="custom-control-label" for="check-dob"><?php echo e(__('Date Of Birth')); ?></label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="applicant[]" value="country" id="check-country">
                                        <label class="custom-control-label" for="check-country"><?php echo e(__('Country')); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <h6><?php echo e(__('Need to show option ?')); ?></h6>
                               <div class="my-4">
                                   <div class="custom-control custom-checkbox">
                                       <input type="checkbox" class="custom-control-input" name="visibility[]" value="profile" id="check-profile">
                                       <label class="custom-control-label" for="check-profile"><?php echo e(__('Profile Image')); ?> </label>
                                   </div>
                                   <div class="custom-control custom-checkbox">
                                       <input type="checkbox" class="custom-control-input" name="visibility[]" value="resume" id="check-resume">
                                       <label class="custom-control-label" for="check-resume"><?php echo e(__('Resume')); ?></label>
                                   </div>
                                   <div class="custom-control custom-checkbox">
                                       <input type="checkbox" class="custom-control-input" name="visibility[]" value="letter" id="check-letter">
                                       <label class="custom-control-label" for="check-letter"><?php echo e(__('Cover Letter')); ?></label>
                                   </div>
                                   <div class="custom-control custom-checkbox">
                                       <input type="checkbox" class="custom-control-input" name="visibility[]" value="terms" id="check-terms">
                                       <label class="custom-control-label" for="check-terms"><?php echo e(__('Terms And Conditions')); ?></label>
                                   </div>
                               </div>
                           </div>
                       </div>
                        <div class="form-group col-md-12">
                            <h6><?php echo e(__('Custom Question')); ?></h6>
                            <div class="my-4">
                                <?php $__currentLoopData = $customQuestion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="custom_question[]" value="<?php echo e($question->id); ?>" id="custom_question_<?php echo e($question->id); ?>">
                                        <label class="custom-control-label" for="custom_question_<?php echo e($question->id); ?>"><?php echo e($question->question); ?> </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-fluid">
                <div class="card-body ">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <?php echo Form::label('sescription', __('Job Description'),['class'=>'form-control-label']); ?>

                            <textarea class="form-control summernote-simple" name="description" id="exampleFormControlTextarea1" rows="15"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-fluid">
                <div class="card-body ">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <?php echo Form::label('requirement', __('Job Requirement'),['class'=>'form-control-label']); ?>

                            <textarea class="form-control summernote-simple" name="requirement" id="exampleFormControlTextarea2" rows="8"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-right">
            <div class="form-group">
                <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            </div>
        </div>
        <?php echo e(Form::close()); ?>

    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/job/create.blade.php ENDPATH**/ ?>