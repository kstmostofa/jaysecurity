<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'ticket','method'=>'post'))); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('title',__('Subject'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Ticket Subject')))); ?>

            </div>
        </div>
    </div>
    <?php if(\Auth::user()->type!='employee'): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('employee_id',__('Ticket for Employee'),['class'=>'form-control-label'])); ?>

                    <?php echo e(Form::select('employee_id',$employees,null,array('class'=>'form-control select2','placeholder'=>__('Select Employee')))); ?>

                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('priority',__('Priority'),['class'=>'form-control-label'])); ?>

                <select name="priority" id="" class="form-control select2">
                    <option value="low"><?php echo e(__('Low')); ?></option>
                    <option value="medium"><?php echo e(__('Medium')); ?></option>
                    <option value="high"><?php echo e(__('High')); ?></option>
                    <option value="critical"><?php echo e(__('critical')); ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('end_date',__('End Date'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::text('end_date',null,array('class'=>'form-control datepicker'))); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('description',__('Description'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Ticket Description')))); ?>

            </div>
        </div>

        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/ticket/create.blade.php ENDPATH**/ ?>