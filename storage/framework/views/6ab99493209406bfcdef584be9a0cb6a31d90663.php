<!-- Topbar Start -->
<div class="navbar-custom">
    <div class="container-fluid">
        <ul class="list-unstyled topnav-menu float-right mb-0">


            <li class="dropdown d-none d-lg-inline-block">
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen"
                   href="#">
                    <i class="fe-maximize noti-icon"></i>
                </a>
            </li>

            <li class="dropdown d-none d-lg-inline-block topbar-dropdown">
               
                <?php if(str_contains(request()->url(),'/ar')): ?>
                 <?php 
                    $route = request()->url(); 
                    $route = str_replace('/ar' , '/en',$route);
                    ?>
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light "  href="<?php echo e($route); ?>"
                   >
                    <img src="<?php echo e(asset('assets/images/flags/en.jpg')); ?>" 
                         height="16">
                </a>
                <?php else: ?>
                 <?php 
                    $route = request()->url(); 
                    $route = str_replace('/en' , '/ar',$route);
                ?>
                   <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light"   href="<?php echo e($route); ?>"
                    >
                    <img src="<?php echo e(asset('assets/images/flags/ar.png')); ?>" 
                         height="16">
                </a>
                <?php endif; ?>
              
 
            </li>

            

            <li class="dropdown notification-list">
                <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                    <i class="fe-settings noti-icon"></i>
                </a>
            </li>

            <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown"
                   href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="<?php echo e(\App\Helpers\TextUtil::getImageUrl(auth()->user()->avatar_url,\App\Helpers\TextUtil::$PLACEHOLDER_AVATAR_URL)); ?>" alt="user-image"
                         class="rounded-circle">
                    <span class="pro-user-name ml-1">
                        <?php echo e(auth()->user()->name); ?> <i class="mdi mdi-chevron-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0"><?php echo e(__('manager.welcome')); ?> !</h6>
                    </div>

                    <!-- item-->
                    <a href="<?php echo e(route('manager.setting.edit')); ?>" class="dropdown-item notify-item">
                        <i class="fe-settings"></i>
                        <span><?php echo e(__('manager.setting')); ?></span>
                    </a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item notify-item" href="<?php echo e(route('manager.logout')); ?>">
                        <i class="fe-log-out"></i>
                        <span><?php echo e(__('manager.logout')); ?></span>
                    </a>
                </div>
            </li>


        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="<?php echo e(route('manager.dashboard')); ?>" class="logo text-center logo-light">

                <span class="logo-sm">
                    <img  src="<?php echo e(asset('assets/images/logo-light-sm.png')); ?>"alt="" height="24">
                </span>
                <span class="logo-lg">
                    <img style="    width: 81px;
    height: auto;" src="<?php echo e(asset('assets/images/logo-light.png')); ?>"alt="" height="24">
                </span>
            </a>
            <a href="<?php echo e(route('manager.dashboard')); ?>" class="logo text-center logo-dark">

                <span class="logo-sm">
                    <img src="<?php echo e(asset('assets/images/logo-dark-sm.png')); ?>"alt="" height="24">
                </span>
                <span class="logo-lg">
                    <img src="<?php echo e(asset('assets/images/logo-dark.png')); ?>"alt="" height="24">
                </span>
            </a>
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>

        </ul>
        <div class="clearfix"></div>
    </div>
</div>
<!-- end Topbar -->
<?php /**PATH D:\joudon\wasilapp\resources\views/manager/layouts/shared/topbar.blade.php ENDPATH**/ ?>