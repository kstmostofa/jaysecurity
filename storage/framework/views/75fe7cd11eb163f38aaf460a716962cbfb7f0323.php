<div class="card bg-none card-box">
    <?php echo e(Form::model($user, array('route' => array('user.update', $user->id), 'method' => 'PUT'))); ?>

    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            <?php echo Form::label('name', __('Name'),['class'=>'form-control-label']); ?>

            <?php echo Form::text('name', null, ['class' => 'form-control','required' => 'required']); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo Form::label('email', __('Email'),['class'=>'form-control-label']); ?>

            <?php echo Form::text('email', null, ['class' => 'form-control','required' => 'required']); ?>

        </div>

        <?php if(\Auth::user()->type != 'super admin'): ?>
            <div class="form-group  col-lg-6 col-md-6">
                <?php echo e(Form::label('role', __('User Role'),['class'=>'form-control-label'])); ?>

                <?php echo Form::select('role', $roles, $user->roles,array('class' => 'form-control select2','required'=>'required')); ?>

                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-role" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        <?php endif; ?>
        <div class="col-md-12">
            <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo Form::close(); ?>

</div>
<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/user/edit.blade.php ENDPATH**/ ?>