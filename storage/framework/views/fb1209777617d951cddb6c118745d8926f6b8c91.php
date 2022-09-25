<div class="card bg-none card-box">
    <div class="table-responsive">
        <table class="table table-striped mb-0 dataTable">
            <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($plan->name); ?> </td>
                    <td><?php echo e((!empty(env('CURRENCY_SYMBOL'))?env('CURRENCY_SYMBOL'):'$').$plan->price); ?> <?php echo e(' / '. $plan->duration); ?></td>
                    <td><?php echo e(__('Users')); ?> : <?php echo e($plan->max_users); ?></td>
                    <td><?php echo e(__('Employees')); ?> : <?php echo e($plan->max_employees); ?></td>
                    <td class="Action">
                        <?php if($user->plan==$plan->id): ?>
                            <span class="btn badge-success btn-xs rounded-pill my-auto"><i class="fas fa-check text-white"></i></span>
                        <?php else: ?>
                            <a href="<?php echo e(route('plan.active',[$user->id,$plan->id])); ?>" class="btn badge-blue btn-xs rounded-pill my-auto text-white" title="<?php echo e(__('Click to Upgrade Plan')); ?>"><i class="fas fa-cart-plus"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
    </div>
</div>
<?php /**PATH /var/www/html/resources/views/user/plan.blade.php ENDPATH**/ ?>