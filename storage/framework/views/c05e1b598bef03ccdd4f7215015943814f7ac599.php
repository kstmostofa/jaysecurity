<div class="card bg-none card-box">
<?php echo e(Form::model($otherpayment,array('route' => array('otherpayment.update', $otherpayment->id), 'method' => 'PUT'))); ?>

<div class="card-body p-0">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('title', __('Title'))); ?>

                <?php echo e(Form::text('title',null, array('class' => 'form-control ','required'=>'required'))); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('amount', __('Amount'))); ?>

                <?php echo e(Form::number('amount',null, array('class' => 'form-control ','required'=>'required','step'=>'0.01'))); ?>

            </div>
        </div>
    </div>
    <div class="col-12">
        <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn-create badge-blue">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
    </div>
</div>

<?php echo e(Form::close()); ?>

</div>

<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/otherpayment/edit.blade.php ENDPATH**/ ?>