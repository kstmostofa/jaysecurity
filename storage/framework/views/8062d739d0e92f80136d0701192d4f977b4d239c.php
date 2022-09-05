<title><?php echo e(config('chatify.name')); ?></title>


<meta name="route" content="<?php echo e($route); ?>">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">



<script src="<?php echo e(asset('js/chatify/font.awesome.min.js')); ?>"></script>


<link href="<?php echo e(asset('css/chatify/style.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('css/chatify/'.$dark_mode.'.mode.css')); ?>" rel="stylesheet" />



<?php echo $__env->make('Chatify::layouts.messengerColor', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\xampp\htdocs\jaysecurity\resources\views/vendor/Chatify/layouts/headLinks.blade.php ENDPATH**/ ?>