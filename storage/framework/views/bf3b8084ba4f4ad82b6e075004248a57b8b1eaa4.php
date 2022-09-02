<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'loan','method'=>'post'))); ?>

    <?php echo e(Form::hidden('employee_id',$employee->id, array())); ?>

    <div class="row">
        <div class="form-group col-md-12">
            <?php echo e(Form::label('title', __('Title'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('title',null, array('class' => 'form-control ','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('loan_option', __('Loan Options*'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::select('loan_option',$loan_options,null, array('class' => 'form-control select2','required'=>'required'))); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo e(Form::label('amount', __('Loan Amount'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::number('amount',null, array('class' => 'form-control ','required'=>'required','step'=>'0.01'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('start_date', __('Start Date'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('start_date',null, array('class' => 'form-control datepicker','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('end_date', __('End Date'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('end_date',null, array('class' => 'form-control datepicker','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('reason', __('Reason'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::textarea('reason',null, array('class' => 'form-control','rows'=>1,'required'=>'required'))); ?>

        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/loan/create.blade.php ENDPATH**/ ?>