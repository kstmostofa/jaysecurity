<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Payslip')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Pay Slip')): ?>
        <?php echo e(Form::open(array('route'=>array('payslip.store'),'method'=>'POST','class'=>'w-50 float-left','id'=>'payslip_form'))); ?>

        <div class="row d-flex justify-content-end">
            <div class="col-xl-3 col-lg-3 col-md-6">
                <div class="all-select-box">
                    <div class="btn-box">
                        <?php echo e(Form::label('month',__('Select Month'),['class'=>'text-type'])); ?>

                        <?php echo e(Form::select('month',$month,null,array('class'=>'form-control month select2' ))); ?>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6">
                <div class="all-select-box">
                    <div class="btn-box">
                        <?php echo e(Form::label('year',__('Select Year'),['class'=>'text-type'])); ?>

                        <?php echo e(Form::select('year',$year,null,array('class'=>'form-control year select2' ))); ?>

                    </div>
                </div>
            </div>
            <div class="col-auto text-right payslip-btn">
                <a href="#" class="btn btn-xs btn-white btn-icon-only width-auto" onclick="document.getElementById('payslip_form').submit(); return false;">
                    <?php echo e(__('Generate Payslip')); ?>

                </a>
            </div>
        </div>
        <?php echo e(Form::close()); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form>
                        <div class="d-flex justify-content-between w-100">
                            <h6><?php echo e(__('Find Employee Payslip')); ?></h6>
                            <div class="float-right col-4">
                                <select class="form-control month_date select2" name="year" tabindex="-1" aria-hidden="true">
                                    <option value="--">--</option>
                                    <?php $__currentLoopData = $month; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$mon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($k); ?>"><?php echo e($mon); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="float-right col-4">
                                <?php echo e(Form::select('year',$year,null,array('class'=>'form-control year_date select2'))); ?>

                            </div>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Pay Slip')): ?>
                                <input type="button" value="<?php echo e(__('Bulk Payment')); ?>" class="btn-create badge-blue float-right search mt-0" id="bulk_payment">
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" id="dataTable1">
                            <thead>
                            <tr>
                                <th><?php echo e(__('Id')); ?></th>
                                <th><?php echo e(__('Employee Id')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Payroll Type')); ?></th>
                                <th><?php echo e(__('Salary')); ?></th>
                                <th><?php echo e(__('Net Salary')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#dataTable1').DataTable({
                "aoColumnDefs": [
                    {
                        "aTargets": [6],
                        "mData": null,
                        "mRender": function (data, type, full) {
                            var month = $(".month_date").val();
                            var year = $(".year_date").val();
                            var datePicker = year + '-' + month;
                            var id = data[0];

                            if (data[6] == 'Paid')
                                return '<div class="badge badge-pill badge-success"><a href="#" class="text-white">' + data[6] + '</a></div>';
                            else
                                return '<div class="badge badge-pill badge-danger"><a href="#" class="text-white">' + data[6] + '</a></div>';
                        }
                    },
                    {
                        "aTargets": [7],
                        "mData": null,
                        "mRender": function (data, type, full) {

                            var month = $(".month_date").val();
                            var year = $(".year_date").val();
                            var datePicker = year + '-' + month;

                            var id = data[0];
                            var payslip_id = data[7];

                            var clickToPaid = '';
                            var payslip = '';
                            var view = '';
                            var edit = '';
                            var deleted = '';
                            var form = '';

                            if (data[7] != 0) {
                                var payslip = '<a href="#" data-url="<?php echo e(url('payslip/pdf/')); ?>/' + id + '/' + datePicker + '" data-size="md-pdf"  data-ajax-popup="true" class="view-btn yellow-bg" data-title="<?php echo e(__('Employee Payslip')); ?>">' + '<?php echo e(__('Payslip')); ?>' + '</a> ';
                            }

                            if (data[6] == "UnPaid" && data[7] != 0) {
                                clickToPaid = '<a href="<?php echo e(url('payslip/paysalary/')); ?>/' + id + '/' + datePicker + '"  class="view-btn green-bg">' + '<?php echo e(__('Click To Paid')); ?>' + '</a>  ';
                            }

                            if (data[7] != 0) {
                                view = '<a href="#" data-url="<?php echo e(url('payslip/showemployee/')); ?>/' + payslip_id + '"  data-ajax-popup="true" class="view-btn gray-bg" data-title="<?php echo e(__('View Employee Detail')); ?>">' + '<?php echo e(__('View')); ?>' + '</a>';
                            }

                            if (data[7] != 0 && data[6] == "UnPaid") {
                                edit = '<a href="#" data-url="<?php echo e(url('payslip/editemployee/')); ?>/' + payslip_id + '"  data-ajax-popup="true" class="view-btn blue-bg" data-title="<?php echo e(__('Edit Employee salary')); ?>">' + '<?php echo e(__('Edit')); ?>' + '</a>';
                            }

                            var url = '<?php echo e(route("payslip.delete", ":id")); ?>';
                            url = url.replace(':id', payslip_id);

                            <?php if(\Auth::user()->type!='employee'): ?>
                            if (data[7] != 0) {
                                deleted = '<a href="#"  data-url="' + url + '" class="payslip_delete view-btn red-bg" >' + '<?php echo e(__('Delete')); ?>' + '</a>';
                            }
                            <?php endif; ?>

                                return view + payslip + clickToPaid + edit + deleted + form;
                        }
                    },
                ]
            });

            function callback() {
                var month = $(".month_date").val();
                var year = $(".year_date").val();
                var datePicker = year + '-' + month;

                $.ajax({
                    url: '<?php echo e(route('payslip.search_json')); ?>',
                    type: 'POST',
                    data: {
                        "datePicker": datePicker, "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function (data) {

                        table.rows().remove().draw();
                        table.rows.add(data).draw();
                        table.column(0).visible(false);
                        $('[data-toggle="tooltip"]').tooltip();

                        if (!(data)) {
                            show_toastr('error', 'Employee payslip not found ! please generate first.', 'error');
                        }
                    },
                    error: function (data) {

                    }
                });
            }

            $(document).on("change", ".month_date,.year_date", function () {
                callback();
            });

            //bulkpayment Click
            $(document).on("click", "#bulk_payment", function () {
                var month = $(".month_date").val();
                var year = $(".year_date").val();
                var datePicker = year + '_' + month;

            });
            $(document).on('click', '#bulk_payment', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {
                var month = $(".month_date").val();
                var year = $(".year_date").val();
                var datePicker = year + '-' + month;

                var title = 'Bulk Payment';
                var size = 'md';
                var url = 'payslip/bulk_pay_create/' + datePicker;

                // return false;

                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $.ajax({
                    url: url,
                    success: function (data) {

                        // alert(data);
                        // return false;
                        if (data.length) {
                            $('#commonModal .modal-body').html(data);
                            $("#commonModal").modal('show');
                            // common_bind();
                        } else {
                            show_toastr('Error', 'Permission denied.');
                            $("#commonModal").modal('hide');
                        }
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('Error', data.error);
                    }
                });
            });

            $(document).on("click", ".payslip_delete", function () {
                var confirmation = confirm("are you sure you want to delete this payslip?");
                var url = $(this).data('url');
                if (confirmation) {
                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "JSON",
                        success: function (data) {

                            show_toastr('Success', 'Payslip successfully deleted', 'success');

                            setTimeout(function () {
                                location.reload();
                            }, 800)


                        },

                    });

                }
            });

        });


    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/payslip/index.blade.php ENDPATH**/ ?>