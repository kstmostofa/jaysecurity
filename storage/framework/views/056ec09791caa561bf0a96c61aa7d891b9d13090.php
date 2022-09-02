<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'award','method'=>'post'))); ?>

    <div class="row">
        <div class="form-group col-md-6 col-lg-6 ">
            <?php echo e(Form::label('employee_id', __('Employee'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::select('employee_id', $employees,null, array('class' => 'form-control select2','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('award_type', __('Award Type'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::select('award_type', $awardtypes,null, array('class' => 'form-control select2','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('date',__('Date'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('date',null,array('class'=>'form-control datepicker'))); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('gift',__('Gift'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('gift',null,array('class'=>'form-control','placeholder'=>__('Enter Gift')))); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('description',__('Description'),['class'=>'form-control-label '])); ?>

            <?php echo e(Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))); ?>

        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/award/create.blade.php ENDPATH**/ ?>