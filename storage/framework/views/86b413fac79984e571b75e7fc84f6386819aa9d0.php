<div class="card bg-none card-box">
    <?php echo e(Form::open(array('route'=>array('create.ip'),'method'=>'post'))); ?>

    <div class="row">
        <div class="form-group col-md-12">
            <?php echo e(Form::label('ip',__('IP'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('ip',null,array('class'=>'form-control'))); ?>

        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/restrict_ip/create.blade.php ENDPATH**/ ?>