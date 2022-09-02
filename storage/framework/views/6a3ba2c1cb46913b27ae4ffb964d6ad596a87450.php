<section class="pricing-plan bg-gredient3">
    <div class="container our-system">
        <div class="row">
            <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-md-4 col-sm-6 py-2">
                    <div class="plan-2">
                        <h6 class="text-center"><?php echo e($plan->name); ?></h6>
                        <p class="price">
                            <sup><?php echo e((env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$')); ?></sup>
                            <?php echo e(number_format($plan->price)); ?>

                            <sub>/ <?php echo e($plan->duration); ?></sub>
                        </p>
                        <ul class="plan-detail">
                            <li><?php echo e(($plan->max_users==-1)?__('Unlimited'):$plan->max_users); ?> <?php echo e(__('Users')); ?></li>
                            <li><?php echo e(($plan->max_employees==-1)?__('Unlimited'):$plan->max_employees); ?> <?php echo e(__('Employees')); ?></li>
                        </ul>
                        <a href="<?php echo e(route('register')); ?>" class="button">Active</a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<div id="ul-section">
    <ul class="list-group list-group-horizontal tooltip1text" style="z-index:1000;">
        <li class="list-group-item">
            <button class="btn btn-default" id="delete"><i class="fa fa-trash"></i></button>
        </li>
        <li class="list-group-item">
            <button class="btn btn-default" onclick="copySection(this)" id="copy_btn"><i class="fa fa-copy"></i></button>
        </li>
        <li class="list-group-item"><a class="btn btn-default handle"><i class="fa fa-arrows"></i></a></li>
    </ul>
</div>


<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/custom_landing_page/plan-section.blade.php ENDPATH**/ ?>