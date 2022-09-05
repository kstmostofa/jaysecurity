
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Plan')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Plan')): ?>
        <?php if(!empty($admin_payment_setting) && (($admin_payment_setting['is_stripe_enabled'] == 'on' && !empty($admin_payment_setting['stripe_key']) && !empty($admin_payment_setting['stripe_secret'])) || ($admin_payment_setting['is_paypal_enabled'] == 'on' && !empty($admin_payment_setting['paypal_client_id']) && !empty($admin_payment_setting['paypal_secret_key'])))): ?>
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                    <a href="#" data-url="<?php echo e(route('plans.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-toggle="tooltip" data-title="<?php echo e(__('Create New Plan')); ?>" data-original-title="<?php echo e(__('Create Plan')); ?>">
                        <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 mb-4">
                <div class="plan-3">
                    <h6><?php echo e($plan->name); ?></h6>
                    <p class="price">
                        <sup><?php echo e((!empty(env('CURRENCY_SYMBOL'))?env('CURRENCY_SYMBOL'):'$').$plan->price); ?></sup>

                        <sub><?php echo e(__('Duration : ').ucfirst($plan->duration)); ?></sub>
                    </p>
                    <p class="price-text"></p>
                    <ul class="plan-detail">
                        <li><?php echo e(($plan->max_users==-1)?__('Unlimited'):$plan->max_users); ?> <?php echo e(__('Users')); ?></li>
                        <li><?php echo e(($plan->max_employees==-1)?__('Unlimited'):$plan->max_employees); ?> <?php echo e(__('Employees')); ?></li>
                    </ul>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Plan')): ?>
                        <a title="<?php echo e(__('Edit Plan')); ?>" href="#" class="button text-xs" data-url="<?php echo e(route('plans.edit',$plan->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Plan')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                            <i class="far fa-edit"></i>
                        </a>
                    <?php endif; ?>
                    <?php if(!empty($admin_payment_setting) && ($admin_payment_setting['is_stripe_enabled'] == 'on'  || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_paystack_enabled'] == 'on'|| $admin_payment_setting['is_flutterwave_enabled'] == 'on'|| $admin_payment_setting['is_razorpay_enabled'] == 'on'|| $admin_payment_setting['is_mercado_enabled'] == 'on'|| $admin_payment_setting['is_paytm_enabled'] == 'on'|| $admin_payment_setting['is_mollie_enabled'] == 'on'||
                    $admin_payment_setting['is_paypal_enabled'] == 'on'|| $admin_payment_setting['is_skrill_enabled'] == 'on' || $admin_payment_setting['is_coingate_enabled'] == 'on') ): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Buy Plan')): ?>
                    <?php if(($plan->id != \Auth::user()->plan) && \Auth::user()->type!='super admin' ): ?>
                    <?php if($plan->price > 0): ?>
                                    <a href="<?php echo e(route('stripe',\Illuminate\Support\Facades\Crypt::encrypt($plan->id))); ?>" class="button text-xs"><?php echo e(__('Buy Plan')); ?></a>
                                    
                                <?php else: ?>
                                    <a href="#" class="button text-xs"><?php echo e(__('Free')); ?></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php if($plan->id != 1 && \Auth::user()->type !=  'super admin'): ?>
                        <?php if(\Auth::user()->requested_plan != $plan->id): ?>
                            <?php if(\Auth::user()->plan == $plan->id): ?>
                            <a href="#" class="badge badge-pill badge-success">
                                <span class="btn-inner--icon">active</span>
                            </a>
                            <?php else: ?>
                            <a href="<?php echo e(route('plan_request',\Illuminate\Support\Facades\Crypt::encrypt($plan->id))); ?>" class="badge badge-pill badge-success">
                                <span class="btn-inner--icon"><i class="fas fa-share"></i></span>
                            </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if(\Auth::user()->plan == $plan->id): ?>
                            <a href="#" class="badge badge-pill badge-success">
                                <span class="btn-inner--icon">active</span>
                            </a>
                            <?php else: ?>
                            <a href="#" class="badge badge-pill badge-danger" data-toggle="tooltip"
                                data-original-title="<?php echo e(__('Delete')); ?>"
                                data-confirm="<?php echo e(__('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?')); ?>"
                                data-confirm-yes="document.getElementById('delete-form-<?php echo e($plan->id); ?>').submit();">
                                <span class="btn-inner--icon"><i class="fas fa-times"></i></span>
                            </a>
                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['plans.destroy', $plan->id], 'id' => 'delete-form-' . $plan->id]); ?>

                            <?php echo Form::close(); ?>

                            <?php endif; ?>
                        
                            
                        <?php endif; ?>
                    <?php endif; ?>
                   
                    <?php
                        $plan_expire_date = \Auth::user()->plan_expire_date;
                        // dd(\Auth::user()->plan);
                    ?>
                    <?php if(\Auth::user()->type =='company' && \Auth::user()->plan == $plan->id): ?>
                        <p class="server-plan text-white">
                            <?php echo e(__('Plan Expired : ')); ?> <?php echo e(!empty($plan_expire_date) ? \Auth::user()->dateFormat($plan_expire_date):'Unlimited'); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jaysecurity\resources\views/plan/index.blade.php ENDPATH**/ ?>