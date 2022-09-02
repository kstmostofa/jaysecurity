<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Leave Report')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>

    <script type="text/javascript" src="<?php echo e(asset('js/jszip.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/pdfmake.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/vfs_fonts.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/dataTables.buttons.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/buttons.html5.js')); ?>"></script>
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="row d-flex justify-content-end">
        <div class="col-xl-2 col-lg-2">
            <?php echo e(Form::open(array('route' => array('report.leave'),'method'=>'get','id'=>'report_leave'))); ?>

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
        <div class="col-xl-3 col-lg-3 month">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('month',__('Month'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::month('month',isset($_GET['month'])?$_GET['month']:date('Y-m'),array('class'=>'month-btn form-control'))); ?>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 year d-none">
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
        <div class="col-xl-2 col-lg-3">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('branch', __('Branch'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::select('branch', $branch,isset($_GET['branch'])?$_GET['branch']:'', array('class' => 'form-control select2'))); ?>

                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-3">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('department', __('Department'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::select('department', $department,isset($_GET['department'])?$_GET['department']:'', array('class' => 'form-control select2'))); ?>

                </div>
            </div>
        </div>
        <div class="col-auto my-custom">
            <a href="#" class="apply-btn" onclick="document.getElementById('report_leave').submit(); return false;" data-toggle="tooltip" data-original-title="<?php echo e(__('apply')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="<?php echo e(route('report.leave')); ?>" class="reset-btn" data-toggle="tooltip" data-original-title="<?php echo e(__('Reset')); ?>">
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
                <input type="hidden" value="<?php echo e($filterYear['branch'] .' '.__('Branch') .' '.$filterYear['dateYearRange'].' '.$filterYear['type'].' '.__('Leave Report of').' '. $filterYear['department'].' '.'Department'); ?>" id="filename">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Report')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e($filterYear['type'].' '.__('Leave Summary')); ?></h5>
                </div>
            </div>
            <?php if($filterYear['branch']!='All'): ?>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Branch')); ?> :</h5>
                        <h5 class="report-text mb-0"><?php echo e(($filterYear['branch'])); ?></h5>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($filterYear['branch']!='All'): ?>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Department')); ?> :</h5>
                        <h5 class="report-text mb-0"><?php echo e(($filterYear['department'])); ?></h5>
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
            <div class="col-xl-4 col-md-4 col-lg-4">
                <div class="card p-4 mb-4">
                    <div class="float-left">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Approved Leaves')); ?> :</h5>
                        <h5 class="report-text mb-0"><?php echo e($filter['totalApproved']); ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 col-lg-4">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Rejected Leave')); ?></h5>
                    <h5 class="report-text mb-0"><?php echo e($filter['totalReject']); ?></h5>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 col-lg-4">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Pending Leaves')); ?></h5>
                    <h5 class="report-text mb-0"><?php echo e($filter['totalPending']); ?></h5>
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
                                <th><?php echo e(__('Approved Leaves')); ?></th>
                                <th><?php echo e(__('Rejected Leaves')); ?></th>
                                <th><?php echo e(__('Pending Leaves')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(\Auth::user()->employeeIdFormat($leave['employee_id'])); ?></td>
                                    <td><?php echo e($leave['employee']); ?></td>
                                    <td>
                                        <div class="m-view-btn badge-success"><?php echo e($leave['approved']); ?>

                                            <a href="#" data-url="<?php echo e(route('report.employee.leave',[$leave['id'],'Approve',isset($_GET['type']) ?$_GET['type']:'no',isset($_GET['month'])?$_GET['month']:date('Y-m'),isset($_GET['year'])?$_GET['year']:date('Y')])); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Approved Leave Detail')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('View')); ?>"><?php echo e(__('View')); ?></a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="m-view-btn badge-danger"><?php echo e($leave['reject']); ?>

                                            <a href="#" data-url="<?php echo e(route('report.employee.leave',[$leave['id'],'Reject',isset($_GET['type']) ?$_GET['type']:'no',isset($_GET['month'])?$_GET['month']:date('Y-m'),isset($_GET['year'])?$_GET['year']:date('Y')])); ?>" class="table-action table-action-delete" data-ajax-popup="true" data-title="<?php echo e(__('Rejected Leave Detail')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('View')); ?>"><?php echo e(__('View')); ?></a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="m-view-btn m-blue-bg"><?php echo e($leave['pending']); ?>

                                            <a href="#" data-url="<?php echo e(route('report.employee.leave',[$leave['id'],'Pending',isset($_GET['type']) ?$_GET['type']:'no',isset($_GET['month'])?$_GET['month']:date('Y-m'),isset($_GET['year'])?$_GET['year']:date('Y')])); ?>" class="table-action table-action-delete" data-ajax-popup="true" data-title="<?php echo e(__('Pending Leave Detail')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('View')); ?>"><?php echo e(__('View')); ?></a>
                                        </div>
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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/report/leave.blade.php ENDPATH**/ ?>