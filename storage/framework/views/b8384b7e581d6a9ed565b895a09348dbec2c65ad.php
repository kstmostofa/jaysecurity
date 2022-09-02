<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'overtime','method'=>'post'))); ?>

    <?php echo e(Form::hidden('employee_id',$employee->id, array())); ?>

    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('title', __('Overtime Title*'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('title',null, array('class' => 'form-control ','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('number_of_days', __('Number of days'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::number('number_of_days',null, array('class' => 'form-control ','required'=>'required','step'=>'0.01'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('hours', __('Hours'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::number('hours',null, array('class' => 'form-control ','required'=>'required','step'=>'0.01'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('rate', __('Rate'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::number('rate',null, array('class' => 'form-control ','required'=>'required','step'=>'0.01'))); ?>

        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/overtime/create.blade.php ENDPATH**/ ?>