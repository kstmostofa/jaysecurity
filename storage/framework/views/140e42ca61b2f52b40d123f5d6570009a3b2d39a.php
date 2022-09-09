<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Forgot Password')); ?>

<?php $__env->stopSection(); ?>
<?php
    $logo=asset(Storage::url('uploads/logo/'));
?>

<?php $__env->startPush('custom-scripts'); ?>
<?php if(env('RECAPTCHA_MODULE') == 'yes'): ?>
        <?php echo NoCaptcha::renderJs(); ?>

<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="login-contain">
        <div class="login-inner-contain">
            <a class="navbar-brand" href="#">
                <img src="<?php echo e($logo.'/logo.png'); ?>" class="navbar-brand-img auth-logo" alt="logo">
            </a>
            <div class="login-form">
                <div class="page-title"><h5><?php echo e(__('Forgot Password')); ?></h5></div>
                <small class="text-muted"><?php echo e(__('We will send a link to reset your password')); ?></small>
                <?php if(session('status')): ?>
                    <small class="text-muted"><?php echo e(session('status')); ?></small>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('password.email')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label class="form-control-label" for="email"><?php echo e(__('E-Mail Address')); ?></label>
                        <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                        </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <?php if(env('RECAPTCHA_MODULE') == 'yes'): ?>
                    <div class="form-group ">
                        <?php echo NoCaptcha::display(); ?>

                        <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="small text-danger" role="alert">
                            <strong><?php echo e($message); ?></strong>
                        </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <?php endif; ?>

                    <button type="submit" class="btn-login"><?php echo e(__('Send Password Reset Link')); ?></button>
                    <div class="or-text"><?php echo e(__('OR')); ?></div>
                    <a href="<?php echo e(route('login')); ?>" class="text-xs text-primary"><?php echo e(__('Login')); ?></a>
                </form>
            </div>
            <h5 class="copyright-text">
                <?php echo e((Utility::getValByName('footer_text')) ? Utility::getValByName('footer_text') :  __('Copyright HRMGo')); ?> <?php echo e(date('Y')); ?>

            </h5>

            <div class="all-select">
                <a href="#" class="monthly-btn">
                    <span class="monthly-text"><?php echo e(__('Change Language')); ?></span>
                    <select class="select-box" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" id="language">
                        <?php $__currentLoopData = Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php if($lang == $language): ?> selected <?php endif; ?> value="<?php echo e(route('change.langPass',$language)); ?>"><?php echo e(Str::upper($language)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/forgot-password.blade.php ENDPATH**/ ?>