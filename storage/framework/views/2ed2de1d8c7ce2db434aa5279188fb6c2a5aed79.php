<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Income Vs Expense')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('theme-script'); ?>
    <script src="<?php echo e(asset('assets/libs/apexcharts/dist/apexcharts.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-page'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
    <script>
        var options = {
            colors: ['#6777ef', '#fc544b'],
            series: <?php echo json_encode($data); ?>,
            chart: {
                type: 'bar',
                height: 400,
                toolbar: {
                    show: false
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: false,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: <?php echo json_encode($labels); ?>,
            },
            yaxis: {
                title: {
                    text: "<?php echo e(\App\Models\Utility::getValByName('site_currency_symbol')); ?> "
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "<?php echo e(\App\Models\Utility::getValByName('site_currency_symbol')); ?> " + val
                    }
                }
            },
            legend: {
                show: true,
                horizontalAlign: 'right',
            },

        };
        var chart = new ApexCharts(document.querySelector("#chart-finance"), options);
        setTimeout(function () {
            chart.render();
        }, 500);

        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A2'}
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('action-button'); ?>

    <div class="row d-flex justify-content-end">
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <?php echo e(Form::open(array('route' => array('report.income-expense'),'method'=>'get','id'=>'report_income_expense'))); ?>

            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('start_month',__('Start Month'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::month('start_month',isset($_GET['start_month'])?$_GET['start_month']:'',array('class'=>'month-btn form-control'))); ?>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('end_month',__('End Month'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::month('end_month',isset($_GET['end_month'])?$_GET['end_month']:'',array('class'=>'month-btn form-control'))); ?>

                </div>
            </div>
        </div>
        <div class="col-auto my-custom">
            <a href="#" class="apply-btn" onclick="document.getElementById('report_income_expense').submit(); return false;" data-toggle="tooltip" data-original-title="<?php echo e(__('apply')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="<?php echo e(route('report.income-expense')); ?>" class="reset-btn" data-toggle="tooltip" data-original-title="<?php echo e(__('Reset')); ?>">
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
    <div id="printableArea">
        <div class="row mt-3">
            <div class="col-xl-3 col-md-6 col-lg-3">
                <div class="card p-4 mb-4">
                    <input type="hidden" value="<?php echo e(__('Income vs Expense Report of').' '); ?><?php echo e($filter['startDateRange'].' to '.$filter['endDateRange']); ?>" id="filename">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Report')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e(__('Income vs Expense Summary')); ?></h5>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-lg-3">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Duration')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e($filter['startDateRange'].' to '.$filter['endDateRange']); ?></h5>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-lg-3">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Total Income')); ?> : <span class="text-green"><?php echo e(\Auth::user()->priceFormat($incomeCount)); ?></span></h5>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-lg-3">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Total Expense')); ?> : <span class="text-red"><?php echo e(\Auth::user()->priceFormat($expenseCount)); ?></span></h5>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card bg-none">
                <div id="chart-finance" data-color="primary" class="p-3"></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/report/income_expense.blade.php ENDPATH**/ ?>