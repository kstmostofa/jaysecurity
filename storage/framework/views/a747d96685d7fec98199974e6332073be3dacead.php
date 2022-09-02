<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'payslip/bulkpayment/'.$date,'method'=>'post'))); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(__('Total Unpaid Employee')); ?> <b><?php echo e(count($unpaidEmployees)); ?></b> <?php echo e(_('out of')); ?> <b><?php echo e(count($Employees)); ?></b>
            </div>
        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Bulk Payment')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/payslip/bulkcreate.blade.php ENDPATH**/ ?>