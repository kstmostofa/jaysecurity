<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Account Balances')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable" >
                            <thead>
                            <tr>
                                <th><?php echo e(__('Account Name')); ?></th>
                                <th><?php echo e(__('Initial Balance')); ?></th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            <?php $totalInitialBalance = 0; ?>
                            <?php $__currentLoopData = $accountLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountlist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $totalInitialBalance = $accountlist->initial_balance + $totalInitialBalance;
                                ?>
                                <tr>
                                    <td><?php echo e($accountlist->account_name); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat($accountlist->initial_balance)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-left text-dark"><?php echo e(__('Total')); ?></td>
                                <td><?php echo e(\Auth::user()->priceFormat($totalInitialBalance)); ?></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/accountlist/account_balance.blade.php ENDPATH**/ ?>