<div class="card bg-none card-box">
    <div class="col-md-12">
        <div class="card bg-none card-box">
            <form>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <h5 class="emp-title mb-0"><?php echo e(__('Employee Detail')); ?></h5>
                        <h5 class="emp-title black-text"><?php echo e(!empty($payslip->employees)? \Auth::user()->employeeIdFormat( $payslip->employees->employee_id):''); ?></h5>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5 class="emp-title mb-0"><?php echo e(__('Basic Salary')); ?></h5>
                        <h5 class="emp-title black-text"><?php echo e(\Auth::user()->priceFormat( $payslip->basic_salary)); ?></h5>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5 class="emp-title mb-0"><?php echo e(__('Payroll Month')); ?></h5>
                        <h5 class="emp-title black-text"><?php echo e(\Auth::user()->dateFormat( $payslip->salary_month)); ?></h5>
                    </div>

                    <div class="col-lg-12 our-system">
                        <div class="row">
                            <ul class="nav nav-tabs my-4">
                                <li>
                                    <a data-toggle="tab" href="#allowance" class="active"><?php echo e(__('Allowance')); ?></a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#commission"><?php echo e(__('Commission')); ?></a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#loan"><?php echo e(__('Loan')); ?></a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#deduction"><?php echo e(__('Saturation Deduction')); ?></a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#payment"><?php echo e(__('Other Payment')); ?></a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#overtime"><?php echo e(__('Overtime')); ?></a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="allowance" class="tab-pane in active">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card bg-none mb-0">
                                                <div class="table-responsive">
                                                    <?php
                                                        $allowances = json_decode($payslip->allowance)
                                                    ?>
                                                    <table class="table align-items-center">
                                                        <thead>
                                                        <tr>
                                                            <th><?php echo e(__('Title')); ?></th>
                                                            <th><?php echo e(__('Amount')); ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="list">
                                                        <?php $__currentLoopData = $allowances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allownace): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($allownace->title); ?></td>
                                                                <td><?php echo e(\Auth::user()->priceFormat($allownace->amount)); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="commission" class="tab-pane">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card bg-none mb-0">
                                                <div class="table-responsive">
                                                    <?php
                                                        $commissions = json_decode($payslip->commission);
                                                    ?>
                                                    <table class="table align-items-center">
                                                        <thead>
                                                        <tr>
                                                            <th><?php echo e(__('Title')); ?></th>
                                                            <th><?php echo e(__('Amount')); ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="list">
                                                        <?php $__currentLoopData = $commissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($commission->title); ?></td>
                                                                <td><?php echo e(\Auth::user()->priceFormat($commission->amount)); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="loan" class="tab-pane">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card bg-none mb-0">
                                                <div class="table-responsive">
                                                    <?php
                                                        $loans = json_decode($payslip->loan);
                                                    ?>
                                                    <table class="table align-items-center">
                                                        <thead>
                                                        <tr>
                                                            <th><?php echo e(__('Title')); ?></th>
                                                            <th><?php echo e(__('Amount')); ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="list">
                                                        <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($loan->title); ?></td>
                                                                <td><?php echo e(\Auth::user()->priceFormat($loan->amount)); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="deduction" class="tab-pane">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card bg-none mb-0">
                                                <div class="table-responsive">
                                                    <?php
                                                        $saturation_deductions = json_decode($payslip->saturation_deduction);
                                                    ?>
                                                    <table class="table align-items-center">
                                                        <thead>
                                                        <tr>
                                                            <th><?php echo e(__('Title')); ?></th>
                                                            <th><?php echo e(__('Amount')); ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="list">
                                                        <?php $__currentLoopData = $saturation_deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($deduction->title); ?></td>
                                                                <td><?php echo e(\Auth::user()->priceFormat($deduction->amount)); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="payment" class="tab-pane">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card bg-none mb-0">
                                                <div class="table-responsive">
                                                    <?php
                                                        $other_payments = json_decode($payslip->other_payment);
                                                    ?>
                                                    <table class="table align-items-center">
                                                        <thead>
                                                        <tr>
                                                            <th><?php echo e(__('Title')); ?></th>
                                                            <th><?php echo e(__('Amount')); ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="list">
                                                        <?php $__currentLoopData = $other_payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($payment->title); ?></td>
                                                                <td><?php echo e(\Auth::user()->priceFormat($payment->amount)); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="overtime" class="tab-pane">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card bg-none mb-0">
                                                <div class="table-responsive">
                                                    <?php
                                                        $overtimes = json_decode($payslip->overtime);
                                                    ?>
                                                    <table class="table align-items-center">
                                                        <thead>
                                                        <tr>
                                                            <th><?php echo e(__('Title')); ?></th>
                                                            <th><?php echo e(__('Amount')); ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="list">
                                                        <?php $__currentLoopData = $overtimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overtime): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($overtime->title); ?></td>
                                                                <td><?php echo e(\Auth::user()->priceFormat($overtime->rate)); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4 py-3">
            <h5 class="emp-title mb-0"><?php echo e(__('Net Salary')); ?></h5>
            <h5 class="emp-title black-text"><?php echo e(\Auth::user()->priceFormat($payslip->net_payble)); ?></h5>
        </div>
    </div>
</div>
<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/payslip/show.blade.php ENDPATH**/ ?>