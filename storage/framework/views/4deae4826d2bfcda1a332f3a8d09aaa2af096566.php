

<?php $__env->startSection('css'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="error-text-box">
                    <svg viewBox="0 0 600 200">
                        <!-- Symbol-->
                        <symbol id="s-text">
                            <text text-anchor="middle" x="50%" y="50%" dy=".35em"><?php echo e($code); ?>!</text>
                        </symbol>
                        <!-- Duplicate symbols-->
                        <use class="text" xlink:href="#s-text"></use>
                        <use class="text" xlink:href="#s-text"></use>
                        <use class="text" xlink:href="#s-text"></use>
                        <use class="text" xlink:href="#s-text"></use>
                        <use class="text" xlink:href="#s-text"></use>
                    </svg>
                </div>
                <div class="text-center">
                    <h3 class="mt-0 mb-2"><?php echo e($error); ?></h3>
                    <p class="text-muted mb-3"><?php echo e($message); ?></p>

                    <a href="<?php echo e($redirect_url); ?>" class="btn btn-primary waves-effect waves-light"><?php echo e($redirect_text); ?></a>
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->


    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('manager.layouts.app', ['title' => 'Errors'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\joudon\wasilapp\resources\views/manager/error-page.blade.php ENDPATH**/ ?>