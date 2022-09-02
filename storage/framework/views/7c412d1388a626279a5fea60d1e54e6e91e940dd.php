<div class="card bg-none card-box">
    <?php echo Form::open(['route' => 'user.store', 'method' => 'post', 'enctype' => 'multipart/form-data']); ?>

    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            <?php echo Form::label('name', __('Name'), ['class' => 'form-control-label']); ?>

            <?php echo Form::text('name', null, ['class' => 'form-control', 'required' => 'required']); ?>

        </div>

        <div class="form-group col-lg-6 col-md-6">
            <?php echo Form::label('email', __('Email'), ['class' => 'form-control-label']); ?>

            <?php echo Form::text('email', null, ['class' => 'form-control', 'required' => 'required']); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo Form::label('password', __('Password'), ['class' => 'form-control-label']); ?>

            <?php echo Form::password('password', ['class' => 'form-control', 'required' => 'required']); ?>

        </div>


        <?php if(\Auth::user()->type != 'super admin'): ?>
            <div class="form-group col-lg-6 col-md-6">
                <?php echo e(Form::label('role', __('User Role'), ['class' => 'form-control-label'])); ?>

                <?php echo Form::select('role', $roles, null, ['class' => 'form-control select2 user_role', 'required' => 'required']); ?>

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
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('branch', __('Branch'), ['class' => 'form-control-label'])); ?>

            <?php echo Form::select('branch', $branch, null, ['class' => 'form-control select2', 'required' => 'required']); ?>

            <?php $__errorArgs = ['branch'];
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
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('avatar', __('Avatar'), ['class' => 'form-control-label'])); ?>

            <div class="choose-file form-group">
                <label for="document" class="form-control-label">
                    <div>Choose file here</div>
                    <input type="file" name="avatar" class="form-control">
                </label>
            </div>

        </div>

        <div class="col-md-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo Form::close(); ?>

</div>
<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).ready(function() {
            $('.user_role').select2({
                placeholder: 'Select Role',
                allowClear: true
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /Users/mostofa/Desktop/Upwork/jaysecurity/resources/views/user/create.blade.php ENDPATH**/ ?>