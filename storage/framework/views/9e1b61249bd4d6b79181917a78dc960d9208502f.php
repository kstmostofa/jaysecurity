<div class="card bg-none card-box">
    <div class="row px-3">
        <div class="col-md-4 mb-3">
            <h5 class="emp-title mb-0"><?php echo e(__('Employee')); ?></h5>
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
            <?php echo e(Form::open(array('route'=>array('payslip.updateemployee',$payslip->employee_id),'method'=>'post'))); ?>

            <?php echo Form::hidden('payslip_id', $payslip->id, ['class' => 'form-control']); ?>

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
                <div class="tab-content pt-4">
                    <div id="allowance" class="tab-pane in active">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card bg-none mb-0">
                                    <div class="row px-3">
                                        <?php
                                            $allowances = json_decode($payslip->allowance);
                                        ?>
                                        <?php $__currentLoopData = $allowances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allownace): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-12 form-group">
                                                <?php echo Form::label('title', $allownace->title,['class'=>'form-control-label']); ?>

                                                <?php echo Form::text('allowance[]', $allownace->amount, ['class' => 'form-control']); ?>

                                                <?php echo Form::hidden('allowance_id[]', $allownace->id, ['class' => 'form-control']); ?>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="commission" class="tab-pane">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card bg-none mb-0">
                                    <div class="row px-3">
                                        <?php
                                            $commissions = json_decode($payslip->commission);
                                        ?>
                                        <?php $__currentLoopData = $commissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-12 form-group">
                                                <?php echo Form::label('title', $commission->title,['class'=>'form-control-label']); ?>

                                                <?php echo Form::text('commission[]', $commission->amount, ['class' => 'form-control']); ?>

                                                <?php echo Form::hidden('commission_id[]', $commission->id, ['class' => 'form-control']); ?>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="loan" class="tab-pane">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card bg-none mb-0">
                                    <div class="row px-3">
                                        <?php
                                            $loans = json_decode($payslip->loan);
                                        ?>
                                        <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-12 form-group">
                                                <?php echo Form::label('title', $loan->title,['class'=>'form-control-label']); ?>

                                                <?php echo Form::text('loan[]', $loan->amount, ['class' => 'form-control']); ?>

                                                <?php echo Form::hidden('loan_id[]', $loan->id, ['class' => 'form-control']); ?>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="deduction" class="tab-pane">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card bg-none mb-0">
                                    <div class="row px-3">
                                        <?php
                                            $saturation_deductions = json_decode($payslip->saturation_deduction);
                                        ?>
                                        <?php $__currentLoopData = $saturation_deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-12 form-group">
                                                <?php echo Form::label('title', $deduction->title,['class'=>'form-control-label']); ?>

                                                <?php echo Form::text('saturation_deductions[]', $deduction->amount, ['class' => 'form-control']); ?>

                                                <?php echo Form::hidden('saturation_deductions_id[]', $deduction->id, ['class' => 'form-control']); ?>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="payment" class="tab-pane">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card bg-none mb-0">
                                    <div class="row px-3">
                                        <?php
                                            $other_payments = json_decode($payslip->other_payment);
                                        ?>
                                        <?php $__currentLoopData = $other_payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-12 form-group">
                                                <?php echo Form::label('title', $payment->title,['class'=>'form-control-label']); ?>

                                                <?php echo Form::text('other_payment[]', $payment->amount, ['class' => 'form-control']); ?>

                                                <?php echo Form::hidden('other_payment_id[]', $payment->id, ['class' => 'form-control']); ?>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="overtime" class="tab-pane">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card bg-none mb-0">
                                    <div class="row px-3">
                                        <?php
                                            $overtimes = json_decode($payslip->overtime);
                                        ?>
                                        <?php $__currentLoopData = $overtimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overtime): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-6 form-group">
                                                <?php echo Form::label('rate', $overtime->title.' '.__('Rate'),['class'=>'form-control-label']); ?>

                                                <?php echo Form::text('rate[]', $overtime->rate, ['class' => 'form-control']); ?>

                                                <?php echo Form::hidden('rate_id[]', $overtime->id, ['class' => 'form-control']); ?>

                                            </div>
                                            <div class="col-md-6 form-group">
                                                <?php echo Form::label('hours',$overtime->title.' '.__('Hours'),['class'=>'form-control-label']); ?>

                                                <?php echo Form::text('hours[]', $overtime->rate, ['class' => 'form-control']); ?>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-4 text-right">
                <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn-create badge-blue">
                <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </div>
</div>
<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/payslip/salaryEdit.blade.php ENDPATH**/ ?>