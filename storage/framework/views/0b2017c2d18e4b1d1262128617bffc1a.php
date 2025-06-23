<?php $__env->startSection('contents'); ?>
    <div class="container h-100 d-flex flex-column justify-content-center">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card shadow">
                    <div class="card-header">
                        <h1 class="h3">Installation</h1>
                        <p class="mb-0">You need to know the mentioned informations before proceeding.</p>
                    </div>
                    <div class="card-body pb-4">
                        <ol class="list-group list-group-flush">
                            <li
                                class="list-group-item text-semibold d-flex align-items-center justify-content-between py-2 px-0">
                                <span>Database Name</span>
                                <i class="las la-check-circle fs-4 text-primary"></i>
                            </li>
                            <li
                                class="list-group-item text-semibold d-flex align-items-center justify-content-between py-2 px-0">

                                <span>Database Username</span>
                                <i class="las la-check-circle fs-4 text-primary"></i>
                            </li>
                            <li
                                class="list-group-item text-semibold d-flex align-items-center justify-content-between py-2 px-0">

                                <span>Database Password</span>
                                <i class="las la-check-circle fs-4 text-primary"></i>

                            </li>
                            <li
                                class="list-group-item text-semibold d-flex align-items-center justify-content-between py-2 px-0">

                                <span>Database Hostname</span>
                                <i class="las la-check-circle fs-4 text-primary"></i>

                            </li>
                           
                        </ol>
                        <br>
                        <a href="<?php echo e(route('installation.checklist')); ?>" class="btn btn-primary">
                            Proceed to Next <i class="las la-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.setup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\themetags\writerap\resources\views/setup/init.blade.php ENDPATH**/ ?>