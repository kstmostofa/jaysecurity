<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url' => 'account-assets'))); ?>

    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('name', __('Name'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('name', '', array('class' => 'form-control','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('amount', __('Amount'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::number('amount', '', array('class' => 'form-control','required'=>'required','step'=>'0.01'))); ?>

        </div>

        <div class="form-group  col-md-6">
            <?php echo e(Form::label('purchase_date', __('Purchase Date'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('purchase_date','', array('class' => 'form-control datepicker'))); ?>

        </div>
        <div class="form-group  col-md-6">
            <?php echo e(Form::label('supported_date', __('Support Until'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('supported_date','', array('class' => 'form-control datepicker'))); ?>

        </div>
        <div class="form-group  col-md-12">
            <?php echo e(Form::label('description', __('Description'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::textarea('description', '', array('class' => 'form-control'))); ?>

        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH C:\xampp\htdocs\jaysecurity\resources\views/assets/create.blade.php ENDPATH**/ ?>