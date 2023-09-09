<div>
    <?php if(session()->has('message')): ?>
        <div aria-live="polite" aria-atomic="true" class="show" style="position: relative;z-index: 1000">
            <div style="position: absolute; top: 1rem; right: 0;">
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php echo e(session()->get('message')); ?>

                </div>
            </div>
        </div>
    <?php elseif(session()->has('error')): ?>
            <div aria-live="polite" aria-atomic="true" class="show" style="position: relative;z-index: 1000">
                <div style="position: absolute; top: 1rem; right: 0;">
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo e(session()->get('error')); ?>

                    </div>
                </div>
            </div>
    <?php endif; ?>
</div>

<script>
    window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 3000);

</script>
<?php /**PATH C:\wamp\www\wasilapp\resources\views/components/alert.blade.php ENDPATH**/ ?>