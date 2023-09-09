<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="h-100" data-simplebar>
        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">


                <li>
                    <a href="<?php echo e(route('manager.dashboard')); ?>">
                        <i data-feather="activity"></i>
                        <span> <?php echo e(__('manager.dashboard')); ?> </span>
                    </a>
                </li>

                <li class="menu-title"><?php echo e(__('manager.navigation')); ?></li>

                <li>
                    <a href="<?php echo e(route('manager.orders.index')); ?>">
                        <i data-feather="shopping-bag"></i>
                        <span>  <?php echo e(__('manager.orders')); ?> </span>
                    </a>
                </li>
                
                 <li>
                    <a href="<?php echo e(route('manager.schedule-orders.index')); ?>">
                        <i data-feather="shopping-bag"></i>
                        <span>  <?php echo e(__('manager.schedule-orders')); ?> </span>
                    </a>
                </li>

                

                <!--<li>-->
                <!--    <a href="<?php echo e(route('manager.codes.index')); ?>">-->
                <!--        <i data-feather="star"></i>-->
                <!--        <span> <?php echo e(__('manager.codes')); ?> </span>-->
                <!--    </a>-->
                <!--</li>-->

                <!--<li>-->
                <!--    <a href="<?php echo e(route('manager.reviews.index')); ?>">-->
                <!--        <i data-feather="star"></i>-->
                <!--        <span> <?php echo e(__('manager.reviews')); ?> </span>-->
                <!--    </a>-->
                <!--</li>-->


                <li>
                    <a href="<?php echo e(route('manager.shops.index')); ?>">
                        <i data-feather="home"></i>
                        <span>  <?php echo e(__('manager.my_shop')); ?> </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo e(route('manager.delivery-boys.index')); ?>">
                        <i data-feather="truck"></i>
                        <span> <?php echo e(__('manager.delivery_boy')); ?> </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo e(route('manager.coupons.index')); ?>">
                        <i data-feather="tag"></i>
                        <span>  <?php echo e(__('manager.coupon')); ?>  <span
                                class="badge badge-primary ml-1"><?php echo e(__('manager.BETA')); ?></span> </span>
                    </a>
                </li>
                
                <li>
                    <a href="<?php echo e(route('manager.transactions.index')); ?>">
                        <i data-feather="dollar-sign"></i>
                        <span>  <?php echo e(__('admin.transactions')); ?> </span>
                    </a>
                </li>


                <!--<li class="menu-title"><?php echo e(__('manager.transaction')); ?></li>-->


                <!--<li>-->
                <!--    <a href="<?php echo e(route('manager.shop-revenues.index')); ?>">-->
                <!--        <i data-feather="airplay"></i>-->
                <!--        <span>  <?php echo e(__('manager.shop_revenues')); ?> </span>-->
                <!--    </a>-->
                <!--</li>-->


                <!--<li>-->
                <!--    <a href="<?php echo e(route('manager.transaction.index')); ?>">-->
                <!--        <i data-feather="dollar-sign"></i>-->
                <!--        <span>  <?php echo e(__('manager.transaction')); ?> </span>-->
                <!--    </a>-->
                <!--</li>-->


                <li class="menu-title"><?php echo e(__('manager.other')); ?></li>

                <li>
                    <a href="<?php echo e(route('manager.setting.edit')); ?>">
                        <i data-feather="settings">></i>
                        <span> <?php echo e(__('manager.setting')); ?> </span>
                    </a>
                </li>

            </ul>


        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
<?php /**PATH C:\wamp\www\wasilapp\resources\views/manager/layouts/shared/left-sidebar.blade.php ENDPATH**/ ?>