<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8" />
    <title>
        <?php echo $__env->yieldContent('title'); ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('assets/img/favicon.png')); ?>">

    <!-- App css -->
    <?php echo $__env->make('common.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</head>

<body>

    <main class="tt-main-wrapper bg-secondary-subtle h-100">
        <!-- contents -->
        <?php echo $__env->yieldContent('contents'); ?>
    </main>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\themetags\writerap\resources\views/layouts/setup.blade.php ENDPATH**/ ?>