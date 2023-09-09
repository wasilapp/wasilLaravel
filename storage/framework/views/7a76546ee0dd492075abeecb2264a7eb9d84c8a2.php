<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo $__env->make('manager.layouts.shared/title-meta', ['title' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('manager.layouts.shared/head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
</head>

<body <?php echo $__env->yieldContent('body-extra'); ?>>
<!-- Begin page -->
<div id="wrapper">
    <?php echo $__env->make('manager.layouts.shared/topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('manager.layouts.shared/left-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <div class="content-page">
        <div class="content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        <!-- content -->

        <?php echo $__env->make('manager.layouts.shared/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
</div>
<div class="modal fade" id="order-modal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-notify modal-info" role="document">
                    <div class="modal-content text-center">
                        <div class="modal-header d-flex justify-content-center">
                            <p class="heading"><?php echo e(trans('admin.be_up_to_date')); ?></p>
                        </div>
                        <div class="modal-body"><i class="fa fa-bell fa-4x animated rotateIn mb-4"></i>
                            <p><?php echo e(trans('admin.new_order_arrive')); ?></p>
                        </div>
                        <div class="modal-footer flex-center">
                            <a role="button" class="btn btn-outline-secondary-modal waves-effect"
                                onClick="window.location.reload();"
                                data-bs-dismiss="modal"><?php echo e(trans('admin.okay')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
<!-- END wrapper -->

<?php echo $__env->make('manager.layouts.shared.right-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php echo $__env->make('manager.layouts.shared/footer-script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html>
<?php /**PATH C:\wamp\www\wasilapp\resources\views/manager/layouts/app.blade.php ENDPATH**/ ?>