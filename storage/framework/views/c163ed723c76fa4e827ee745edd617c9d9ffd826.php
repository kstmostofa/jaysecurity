<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'accountlist','method'=>'post'))); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('account_name',__('Account Name'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::text('account_name',null,array('class'=>'form-control','placeholder'=>__('Enter Account Name')))); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('initial_balance',__('Initial Balance'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::number('initial_balance',null,array('class'=>'form-control','placeholder'=>__('Enter Initial Balance')))); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('account_number',__('Account Number'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::number('account_number',null,array('class'=>'form-control','placeholder'=>__('Enter Account Number')))); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('branch_code',__('Branch Code'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::text('branch_code',null,array('class'=>'form-control','placeholder'=>__('Enter Branch Code')))); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('bank_branch',__('Bank Branch'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::text('bank_branch',null,array('class'=>'form-control','placeholder'=>__('Enter Bank Branch')))); ?>

            </div>
        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/accountlist/create.blade.php ENDPATH**/ ?>