<style>
    .select2-container--default.select2-container--focus .select2-selection--multiple,
    .select2-container--default .select2-selection--multiple {
        height: auto !important;
        min-height: 40px !important;
    }

</style>
<div class="card bg-none card-box">
    <?php echo e(Form::open(['url' => 'zoom-meeting', 'enctype' => 'multipart/form-data',"autocomplete"  => "off"])); ?>

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('', __('Title'), ['class' => 'form-control-label'])); ?>

                <?php echo e(Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Enter Meeting Title'), 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group select2_option">
                <?php echo e(Form::label('', __('User'), ['class' => 'form-control-label'])); ?>

                <?php echo Form::select('user_id[]', $employee_option, null, ['multiple' => true, 'class' => 'form-control select2']); ?>

            </div>
        </div>


        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('', __('Start Date'), ['class' => 'form-control-label'])); ?>

                <?php echo Form::text('start_date', null, ['class' => 'form-control datepicker datetime_class_start_date']); ?>

                <input type="hidden" name="start_date" class="start_date" value="">
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('', __('Duration'), ['class' => 'form-control-label'])); ?>

                <?php echo Form::number('duration', null, ['class' => 'form-control', 'required' => true, 'min' => 0]); ?>

            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('password', __('Password'),['class' => 'form-control-label'])); ?>

                <?php echo e(Form::password('password', ['class' => 'form-control', 'placeholder' => __('Enter Password')])); ?>

            </div>
        </div>

    
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/zoom_meeting/create.blade.php ENDPATH**/ ?>