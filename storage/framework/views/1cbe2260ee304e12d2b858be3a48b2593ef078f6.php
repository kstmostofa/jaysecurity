<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('theme-script'); ?>
    <script src="<?php echo e(asset('assets/libs/apexcharts/dist/apexcharts.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        var e = $("#chart-sales");
        e.length && e.each(function () {
            !function (e) {
                var t = {
                    chart: {width: "100%", zoom: {enabled: !1}, toolbar: {show: !1}, shadow: {enabled: !1}},
                    stroke: {width: 6, curve: "smooth"},
                    series: [{name: "<?php echo e(__('Order')); ?>", data: <?php echo json_encode($chartData['data']); ?>}],
                    xaxis: {labels: {format: "MMM", style: {colors: PurposeStyle.colors.gray[600], fontSize: "14px", fontFamily: PurposeStyle.fonts.base, cssClass: "apexcharts-xaxis-label"}}, axisBorder: {show: !1}, axisTicks: {show: !0, borderType: "solid", color: PurposeStyle.colors.gray[300], height: 6, offsetX: 0, offsetY: 0}, type: "text", categories: <?php echo json_encode($chartData['label']); ?>},
                    yaxis: {labels: {style: {color: PurposeStyle.colors.gray[600], fontSize: "12px", fontFamily: PurposeStyle.fonts.base}}, axisBorder: {show: !1}, axisTicks: {show: !0, borderType: "solid", color: PurposeStyle.colors.gray[300], height: 6, offsetX: 0, offsetY: 0}},
                    fill: {type: "solid"},
                    markers: {size: 4, opacity: .7, strokeColor: "#fff", strokeWidth: 3, hover: {size: 7}},
                    grid: {borderColor: PurposeStyle.colors.gray[300], strokeDashArray: 5},
                    dataLabels: {enabled: !1}
                }, a = (e.data().dataset, e.data().labels, e.data().color), n = e.data().height, o = e.data().type;
                t.colors = [PurposeStyle.colors.theme[a]], t.markers.colors = [PurposeStyle.colors.theme[a]], t.chart.height = n || 350, t.chart.type = o || "line";
                var i = new ApexCharts(e[0], t);
                setTimeout(function () {
                    i.render()
                }, 300)
            }($(this))
        })
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="card card-box">
                <div class="left-card">
                    <div class="icon-box"><i class="fas fa-users"></i></div>
                    <h4><?php echo e(__('Total Users')); ?></h4>
                </div>
                <div class="number-icon"><?php echo e($user->total_user); ?></div>
                <div class="user-text">
                    <h5><?php echo e(__('PAID USERS')); ?> : <span class="text-dark"><?php echo e($user['total_paid_user']); ?></span></h5>
                </div>
            </div>
            <img src="<?php echo e(asset('assets/img/dot-icon.png')); ?>" alt="" class="dotted-icon">
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="card card-box">
                <div class="left-card">
                    <div class="icon-box yellow-bg"><i class="fas fa-shopping-cart"></i></div>
                    <h4><?php echo e(__('Total Orders')); ?></h4>
                </div>
                <div class="number-icon"><?php echo e($user->total_orders); ?></div>
                <div class="user-text">
                    <h5><?php echo e(__('Total Order Amount')); ?> : <span class="text-dark"><?php echo e((!empty(env('CURRENCY_SYMBOL'))?env('CURRENCY_SYMBOL'):'$').$user['total_orders_price']); ?></span></h5>
                </div>
            </div>
            <img src="<?php echo e(asset('assets/img/dot-icon.png')); ?>" alt="" class="dotted-icon">
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="card card-box">
                <div class="left-card">
                    <div class="icon-box green-bg"><i class="fas fa-trophy"></i></div>
                    <h4><?php echo e(__('Total Plans')); ?></h4>
                </div>
                <div class="number-icon"><?php echo e($user['total_plan']); ?></div>
                <div class="user-text">
                    <h5><?php echo e(__('Most Purchase Plan')); ?> : <span class="text-dark"><?php echo e($user['most_purchese_plan']); ?></span></h5>
                </div>
            </div>
            <img src="<?php echo e(asset('assets/img/dot-icon.png')); ?>" alt="" class="dotted-icon">
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h4 class="h4 font-weight-400"><?php echo e(__('Recent Order')); ?></h4>
            <div class="card bg-none">
                <div class="chart">
                    <div id="chart-sales" data-color="primary" data-height="280" class="p-3"></div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/dashboard/super_admin.blade.php ENDPATH**/ ?>