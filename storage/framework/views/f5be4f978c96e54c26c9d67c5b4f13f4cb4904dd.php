<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Monthly Attendance')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
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
                jsPDF: {unit: 'in', format: 'A2'}
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="row d-flex justify-content-end">
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
            <?php echo e(Form::open(array('route' => array('report.monthly.attendance'),'method'=>'get','id'=>'report_monthly_attendance'))); ?>

            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('month',__('Month'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::month('month',isset($_GET['month'])?$_GET['month']:date('Y-m'),array('class'=>'month-btn form-control'))); ?>

                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12 col-12">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('branch', __('Branch'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::select('branch', $branch,isset($_GET['branch'])?$_GET['branch']:'', array('class' => 'form-control select2'))); ?>

                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12 col-12">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('department', __('Department'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::select('department', $department,isset($_GET['department'])?$_GET['department']:'', array('class' => 'form-control select2'))); ?>

                </div>
            </div>
        </div>
        <div class="col-auto my-custom">
            <a href="#" class="apply-btn" onclick="document.getElementById('report_monthly_attendance').submit(); return false;" data-toggle="tooltip" data-original-title="<?php echo e(__('apply')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="<?php echo e(route('report.monthly.attendance')); ?>" class="reset-btn" data-toggle="tooltip" data-original-title="<?php echo e(__('Reset')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
            </a>

            <a href="<?php echo e(route('report.attendance',[isset($_GET['month'])?$_GET['month']:date('Y-m'),(isset($_GET['branch']) && !empty($_GET['branch'])) ?$_GET['branch']:0,(isset($_GET['department']) && !empty($_GET['department'])) ?$_GET['department']:0])); ?>" class="action-btn" >
                <span class="btn-inner--icon"><i class="fas fa-download"></i></span>
            </a>
        </div>
    </div>
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="printableArea">
        <div class="row mt-3">
            <div class="col">
                <input type="hidden" value="<?php echo e($data['branch'] .' '.__('Branch') .' '.$data['curMonth'].' '.__('Attendance Report of').' '. $data['department'].' '.'Department'); ?>" id="filename">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Report')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e(__('Attendance Summary')); ?></h5>
                </div>
            </div>
            <?php if($data['branch']!='All'): ?>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Branch')); ?> :</h5>
                        <h5 class="report-text mb-0"><?php echo e($data['branch']); ?></h5>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($data['department']!='All'): ?>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Department')); ?> :</h5>
                        <h5 class="report-text mb-0"><?php echo e($data['department']); ?></h5>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Duration')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e($data['curMonth']); ?></h5>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 col-lg-3">
                <div class="card p-4 mb-4">
                    <div class="float-left">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Attendance')); ?></h5>
                        <h5 class="report-text mb-0"><?php echo e(__('Total present')); ?>: <?php echo e($data['totalPresent']); ?></h5>
                    </div>
                    <div class="float-right">
                        <h5 class="report-text gray-text mb-0"></h5>
                        <h5 class="report-text mb-0"><?php echo e(__('Total leave')); ?> : <?php echo e($data['totalLeave']); ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-lg-3">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Overtime')); ?></h5>
                    <h5 class="report-text mb-0"><?php echo e(__('Total overtime in hours')); ?> : <?php echo e(number_format($data['totalOvertime'],2)); ?></h5>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-lg-3">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Early leave')); ?></h5>
                    <h5 class="report-text mb-0"><?php echo e(__('Total early leave in hours')); ?> : <?php echo e(number_format($data['totalEarlyLeave'],2)); ?></h5>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-lg-3">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Employee late')); ?></h5>
                    <h5 class="report-text mb-0"><?php echo e(__('Total late in hours')); ?> : <?php echo e(number_format($data['totalLate'],2)); ?></h5>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="table-responsive py-4 attendance-table-responsive">
                        <table class="table table-striped mb-0" id="dataTable-1">
                            <thead>
                            <tr>
                                <th class="active"><?php echo e(__('Name')); ?></th>
                                <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e($date); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $employeesAttendance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($attendance['name']); ?></td>
                                    <?php $__currentLoopData = $attendance['status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td>
                                            <?php if($status=='P'): ?>
                                                <i class="custom-badge badge-success"><?php echo e(__('P')); ?></i>
                                            <?php elseif($status=='A'): ?>
                                                <i class="custom-badge badge-danger"><?php echo e(__('A')); ?></i>
                                            <?php endif; ?>
                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/report/monthlyAttendance.blade.php ENDPATH**/ ?>