<div class="card bg-none card-box">
    <?php echo e(Form::open(['url' => 'indicator', 'method' => 'post'])); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('branch', __('Branch'), ['class' => 'form-control-label'])); ?>

                <?php echo e(Form::select('branch', $brances, null, ['class' => 'form-control select2', 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('department', __('Department'), ['class' => 'form-control-label'])); ?>

                <?php echo e(Form::select('department', $departments, null, ['class' => 'form-control select2', 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('designation', __('Designation'), ['class' => 'form-control-label'])); ?>

                <?php echo e(Form::select('designation', $degisnation, null, ['class' => 'form-control select2', 'required' => 'required'])); ?>

            </div>
        </div>

    </div>
    <div class="row">
        <?php $__currentLoopData = $performance_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $performance_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12 mt-3">
                <h6><?php echo e($performance_type->name); ?></h6>
                <hr class="mt-0">
            </div>

            <?php $__currentLoopData = $performance_type->types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $types): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6">
                    <?php echo e($types->name); ?>

                </div>
                <div class="col-6">
                    <fieldset id='demo1' class="rating">
                        <input class="stars" type="radio" id="technical-5-<?php echo e($types->id); ?>"
                            name="rating[<?php echo e($types->id); ?>]" value="5" />
                        <label class="full" for="technical-5-<?php echo e($types->id); ?>"
                            title="Awesome - 5 stars"></label>
                        <input class="stars" type="radio" id="technical-4-<?php echo e($types->id); ?>"
                            name="rating[<?php echo e($types->id); ?>]" value="4" />
                        <label class="full" for="technical-4-<?php echo e($types->id); ?>"
                            title="Pretty good - 4 stars"></label>
                        <input class="stars" type="radio" id="technical-3-<?php echo e($types->id); ?>"
                            name="rating[<?php echo e($types->id); ?>]" value="3" />
                        <label class="full" for="technical-3-<?php echo e($types->id); ?>"
                            title="Meh - 3 stars"></label>
                        <input class="stars" type="radio" id="technical-2-<?php echo e($types->id); ?>"
                            name="rating[<?php echo e($types->id); ?>]" value="2" />
                        <label class="full" for="technical-2-<?php echo e($types->id); ?>"
                            title="Kinda bad - 2 stars"></label>
                        <input class="stars" type="radio" id="technical-1-<?php echo e($types->id); ?>"
                            name="rating[<?php echo e($types->id); ?>]" value="1" />
                        <label class="full" for="technical-1-<?php echo e($types->id); ?>"
                            title="Sucks big time - 1 star"></label>
                    </fieldset>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    

    <div class="row">
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/indicator/create.blade.php ENDPATH**/ ?>