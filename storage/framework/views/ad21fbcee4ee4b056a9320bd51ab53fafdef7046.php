<!-- bundle -->
<!-- Vendor js -->
<script src="<?php echo e(asset('assets/js/vendor.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/toastr.min.js')); ?>"></script><!-- Toastr JS -->

<?php echo $__env->yieldContent('script'); ?>
<!-- App js -->
<script src="<?php echo e(asset('assets/js/app.min.js')); ?>"></script>
   <script type="text/javascript">
   
        let are_you_sure = "<?php echo e(trans('messages.are_you_sure')); ?>";
        let yes = "<?php echo e(trans('messages.yes')); ?>";
        let no = "<?php echo e(trans('messages.no')); ?>";
        let wrong = "<?php echo e(trans('messages.wrong')); ?>";
        let cannot_delete = "<?php echo e(trans('messages.cannot_delete')); ?>";
        let last_image = "<?php echo e(trans('messages.last_image')); ?>";
        let record_safe = "<?php echo e(trans('messages.record_safe')); ?>";
        let select = "<?php echo e(trans('labels.select')); ?>";
        let variation = "<?php echo e(trans('labels.variation')); ?>";
        let enter_variation = "<?php echo e(trans('labels.variation')); ?>";
        let product_price = "<?php echo e(trans('labels.product_price')); ?>";
        let enter_product_price = "<?php echo e(trans('labels.product_price')); ?>";
        let sale_price = "<?php echo e(trans('labels.sale_price')); ?>";
        let enter_sale_price = "<?php echo e(trans('labels.sale_price')); ?>";

        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        <?php if(Session::has('success')): ?>
            toastr.success("<?php echo e(session('success')); ?>");
        <?php endif; ?>
        <?php if(Session::has('error')): ?>
            toastr.error("<?php echo e(session('error')); ?>");
        <?php endif; ?>
        var noticount = 0;
        (function noti() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "<?php echo e(url('manager/getorder')); ?>",
                method: 'GET', //Get method,
                dataType: "json",
                success: function(response) {
                    order_count = localStorage.getItem("order_count");
                  
                    if (response.order_count != 0) {
                         if (localStorage.getItem("order_count") < response.order_count) {
                            localStorage.setItem("order_count", response.order_count);
                            jQuery("#order-modal").modal('show'); 
                        }else{
                            localStorage.setItem("order_count", response.order_count);

                        }
                   
                    } else {
                        localStorage.setItem("order_count", response.order_count);
                    }
                   
              
                    setTimeout(noti, 20000);
                }
            });
        })();
    </script>
<?php echo $__env->yieldContent('script-bottom'); ?>
<?php /**PATH C:\wamp\www\wasilapp\resources\views/manager/layouts/shared/footer-script.blade.php ENDPATH**/ ?>