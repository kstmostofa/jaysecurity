<div class="card bg-none card-box">
    <?php echo e(Form::model($employee, array('route' => array('employee.salary.update', $employee->id), 'method' => 'POST'))); ?>

    <div class="row">
        <div class="form-group col-md-12">
            <?php echo e(Form::label('salary_type', __('Payslip Type*'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::select('salary_type',$payslip_type,null, array('class' => 'form-control select2','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('custom_type', __('Salary Type*'),['class'=>'form-control-label'])); ?>

            <select class="select2 form-control select2-multiple" id="custom_type" name="custom_type" data-toggle="select2" data-placeholder="<?php echo e(__('Select Type...')); ?>">
            <option value=""><?php echo e(__('Select Type')); ?></option>
            <option value="0">Salary by designation</option>
            <option value="1">Custom Salary</option>
        </select>
        </div>
        <div class="form-group col-md-12 salary_" style="display: none;">
            <?php if(empty($salary)){
            ?>
            <span style="color: red;"> No Salary is added in DB </span>
            <?php
            }else{ ?>
            <?php echo e(Form::label('salary_id', __('Salary Type*'),['class'=>'form-control-label'])); ?>

            <input class="form-control" type="text" name="salary_amt" readonly value="<?php echo $salary->amt; ?>">
             <input class="form-control" type="hidden" name="salary_id" value="<?php echo $salary->id; ?>">
            <?php } ?> 
        </div>
        <div class="form-group col-md-12 salary" style="display: none;">
            <?php echo e(Form::label('salary', __('Salary'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::number('salary',null, array('class' => 'form-control ','required'=>'required'))); ?>

        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Save Change')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/setsalary/basic_salary.blade.php ENDPATH**/ ?>