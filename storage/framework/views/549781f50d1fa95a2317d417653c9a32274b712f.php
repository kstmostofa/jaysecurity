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

                <?php echo Form::select('role', $roles, $user->roles,array('class' => 'form-control select2 user_role','required'=>'required')); ?>

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
        <div class="form-group col-lg-6 col-md-6" id="branch">
            <?php echo e(Form::label('branch', __('Branch'), ['class' => 'form-control-label'])); ?>

            <?php echo Form::select('branch', $branch, $user->branch_id, array('class' => 'form-control select2 branch', 'required' => 'required')); ?>

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
        <?php if(Auth::user()->type == "company"): ?>
                    <div class="form-group col-lg-6 col-md-6">
                        <label for="" class="form-control-label">Status</label>
                       <select name="status" id="status" class="form-control form-control-sm">
                            <option value="">Select Status</option>
                            <option value="Pending" <?php if($user->status == 'Pending'): ?> selected <?php endif; ?> >Pending</option>
                            <option value="Active" <?php if($user->status == 'Active'): ?> selected <?php endif; ?>>Active</option>
                            <option value="Reject" <?php if($user->status == 'Reject'): ?> selected <?php endif; ?>>Reject</option>
                       </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6" id="note">
                        <label for=""  class="form-control-label">Note</label>
                        <textarea name="note"  id="" cols="5" rows="2" class="form-control"><?php echo e($user->note); ?></textarea>
                    </div>
                    <?php endif; ?>
        <div class="col-md-12">
            <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.user_role').on('change', function() {
        if ($(this).val() == '6') {
            $('#branch').show();
        } else {
            $('#branch').hide();
        }
    })
        
    });
    </script>

<script>
    $("#branch").hide()
    $(".user_role").load("change", function() {
        $('.user_role').on('change', function() {
        if ($(this).val() == '6') {
            $('#branch').show();
        } else {
            $('#branch').hide();
        }
    })
    })

</script>

<script>
    $('#note').hide();
    $('#status').on('change', function() {
        if ($(this).val() === 'Reject') {
            $('#note').show();
        } else{
            $('#note').hide();  
        }
    })
</script>
    
    <?php echo Form::close(); ?>

</div>
<?php /**PATH /var/www/html/resources/views/user/edit.blade.php ENDPATH**/ ?>