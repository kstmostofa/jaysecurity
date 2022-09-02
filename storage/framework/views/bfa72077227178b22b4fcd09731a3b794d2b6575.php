
<div class="card bg-none card-box">
    <?php echo e(Form::model($attendanceEmployee,array('route' => array('attendanceemployee.update', $attendanceEmployee->id), 'method' => 'PUT'))); ?>

    <div class="row">
        <div class="form-group col-lg-6 col-md-6 ">
            <?php echo e(Form::label('employee_id',__('Employee'))); ?>

            <?php echo e(Form::select('employee_id',$employees,null,array('class'=>'form-control select2'))); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('date',__('Date'))); ?>

            <?php echo e(Form::text('date',null,array('class'=>'form-control datepicker'))); ?>

        </div>

        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('clock_in',__('Clock In'))); ?>

            <?php echo e(Form::text('clock_in',null,array('class'=>'form-control timepicker'))); ?>

        </div>

        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('clock_out',__('Clock Out'))); ?>

            <?php echo e(Form::text('clock_out',null,array('class'=>'form-control timepicker'))); ?>

        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>


<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/attendance/edit.blade.php ENDPATH**/ ?>