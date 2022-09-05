
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Payroll')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/jszip.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/pdfmake.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/vfs_fonts.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/dataTables.buttons.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/buttons.html5.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>

    <script>
        $('input[name="type"]:radio').on('change', function (e) {
            var type = $(this).val();
            if (type == 'monthly') {
                $('.month').addClass('d-block');
                $('.month').removeClass('d-none');
                $('.year').addClass('d-none');
                $('.year').removeClass('d-block');
            } else {
                $('.year').addClass('d-block');
                $('.year').removeClass('d-none');
                $('.month').addClass('d-none');
                $('.month').removeClass('d-block');
            }
        });

        $('input[name="type"]:radio:checked').trigger('change');

    </script>

    <script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
    <script>
        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A4'}
            };
            html2pdf().set(opt).from(element).save();
        }

        $(document).ready(function () {
            var filename = $('#filename').val();
            $('#report-dataTable').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'pdf',
                        title: filename
                    },
                    {
                        extend: 'excel',
                        title: filename
                    }, {
                        extend: 'csv',
                        title: filename
                    }
                ]
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="row d-flex justify-content-end">
        <div class="col-auto">
            <?php echo e(Form::open(array('route' => array('report.payroll'),'method'=>'get','id'=>'report_payroll'))); ?>

            <div class="all-select-box">
                <div class="btn-box">
                    <label class="text-type"><?php echo e(__('Type')); ?></label> <br>
                    <div class="d-flex radio-check">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="monthly" value="monthly" name="type" class="custom-control-input monthly" <?php echo e(isset($_GET['type']) && $_GET['type']=='monthly' ?'checked':'checked'); ?>>
                            <label class="custom-control-label" for="monthly"><?php echo e(__('Monthly')); ?></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="yearly" value="yearly" name="type" class="custom-control-input yearly" <?php echo e(isset($_GET['type']) && $_GET['type']=='yearly' ?'checked':''); ?>>
                            <label class="custom-control-label" for="yearly"><?php echo e(__('Yearly')); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 month">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('month',__('Month'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::month('month',isset($_GET['month'])?$_GET['month']:date('Y-m'),array('class'=>'month-btn form-control'))); ?>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 year d-none">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('year', __('Year'),['class'=>'text-type'])); ?>

                    <select class="form-control select2" id="year" name="year" tabindex="-1" aria-hidden="true">
                        <?php for($filterYear['starting_year']; $filterYear['starting_year'] <= $filterYear['ending_year']; $filterYear['starting_year']++): ?>
                            <option <?php echo e((isset($_GET['year']) && $_GET['year'] == $filterYear['starting_year'] ?'selected':'')); ?> <?php echo e((!isset($_GET['year']) && date('Y') == $filterYear['starting_year'] ?'selected':'')); ?> value="<?php echo e($filterYear['starting_year']); ?>"><?php echo e($filterYear['starting_year']); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('branch', __('Branch'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::select('branch', $branch,isset($_GET['branch'])?$_GET['branch']:'', array('class' => 'form-control select2'))); ?>

                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('department', __('Department'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::select('department', $department,isset($_GET['department'])?$_GET['department']:'', array('class' => 'form-control select2'))); ?>

                </div>
            </div>
        </div>
        <div class="col-auto my-custom">
            <a href="#" class="apply-btn" onclick="document.getElementById('report_payroll').submit(); return false;" data-toggle="tooltip" data-original-title="<?php echo e(__('apply')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="<?php echo e(route('report.payroll')); ?>" class="reset-btn" data-toggle="tooltip" data-original-title="<?php echo e(__('Reset')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
            </a>
            <a href="#" class="action-btn" onclick="saveAsPDF()" data-toggle="tooltip" data-original-title="<?php echo e(__('Download')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-download"></i></span>
            </a>
        </div>

    </div>
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div id="printableArea" class="mt-4">

        <div class="row mt-3">
            <div class="col">
                <input type="hidden" value="<?php echo e($filterYear['branch'] .' '.__('Branch') .' '.$filterYear['dateYearRange'].' '.$filterYear['type'].' '.__('Payroll Report of').' '. $filterYear['department'].' '.'Department'); ?>" id="filename">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Report')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e($filterYear['type'].' '.__('Payroll Summary')); ?></h5>
                </div>
            </div>
            <?php if($filterYear['branch']!='All'): ?>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Branch')); ?> :</h5>
                        <h5 class="report-text mb-0"><?php echo e($filterYear['branch']); ?></h5>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($filterYear['department']!='All'): ?>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Department')); ?> :</h5>
                        <h5 class="report-text mb-0"><?php echo e($filterYear['department']); ?></h5>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Duration')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e($filterYear['dateYearRange']); ?></h5>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Total Basic Salary')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e(\Auth::user()->priceFormat($filterData['totalBasicSalary'])); ?></h5>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Total Net Salary')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e(\Auth::user()->priceFormat($filterData['totalNetSalary'])); ?></h5>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Total Allowance')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e(\Auth::user()->priceFormat($filterData['totalAllowance'])); ?></h5>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Total Commission')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e(\Auth::user()->priceFormat($filterData['totalCommision'])); ?></h5>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Total Loan')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e(\Auth::user()->priceFormat($filterData['totalLoan'])); ?></h5>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Total Saturation Deduction')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e(\Auth::user()->priceFormat($filterData['totalSaturationDeduction'])); ?></h5>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Total Other Payment')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e(\Auth::user()->priceFormat($filterData['totalOtherPayment'])); ?></h5>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Total Overtime')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e(\Auth::user()->priceFormat($filterData['totalOverTime'])); ?></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive py-4">
                        <table class="table table-striped mb-0" id="report-dataTable">
                            <thead>
                            <tr>
                                <th><?php echo e(__('Employee ID')); ?></th>
                                <th><?php echo e(__('Employee')); ?></th>
                                <th><?php echo e(__('Salary')); ?></th>
                                <th><?php echo e(__('Net Salary')); ?></th>
                                <th><?php echo e(__('Month')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $payslips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payslip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td><a href="<?php echo e(route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($payslip->employee_id))); ?>" class="btn btn-sm btn-primary"><?php echo e(!empty($payslip->employees)?\Auth::user()->employeeIdFormat($payslip->employees->employee_id):''); ?></a></td>
                                    <td><?php echo e((!empty($payslip->employees)) ? $payslip->employees->name:''); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat($payslip->basic_salary)); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat($payslip->net_payble)); ?></td>
                                    <td><?php echo e($payslip->salary_month); ?></td>
                                    <td>
                                        <?php if($payslip->status==0): ?>
                                            <div class="badge badge-danger"><a href="#" class="text-white"><?php echo e(__('UnPaid')); ?></a></div>
                                        <?php else: ?>
                                            <div class="badge badge-success"><a href="#" class="text-white"><?php echo e(__('Paid')); ?></a></div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jaysecurity\resources\views/report/payroll.blade.php ENDPATH**/ ?>