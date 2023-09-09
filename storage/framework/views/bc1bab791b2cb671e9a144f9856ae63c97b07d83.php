<?php $__env->startSection('css'); ?>

<style>
.popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.popup-content {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
    top: 50%;
    position: absolute;
    left: 40%;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    font-size: 24px;
}

.popup-content p {
    padding: 40px;
}
</style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>




    <!-- Start Content-->
    <div class="container-fluid">
        <?php if (isset($component)) { $__componentOriginald4c8f106e1e33ab85c5d037c2504e2574c1b0975 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Alert::class, []); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald4c8f106e1e33ab85c5d037c2504e2574c1b0975)): ?>
<?php $component = $__componentOriginald4c8f106e1e33ab85c5d037c2504e2574c1b0975; ?>
<?php unset($__componentOriginald4c8f106e1e33ab85c5d037c2504e2574c1b0975); ?>
<?php endif; ?>

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('manager.dashboard')); ?>"><?php echo e(env('APP_NAME')); ?></a>
                            </li>
                            <li class="breadcrumb-item"><a
                                    href="<?php echo e(route('manager.orders.index')); ?>"><?php echo e(__('manager.orders')); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo e(__('manager.edit')); ?></li>
                        </ol>
                    </div>
                    <h4 class="page-title"><?php echo e(__('manager.edit')); ?></h4>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3"><?php echo e(__('manager.order')); ?> #<?php echo e($order['id']); ?> </h4>

                        <div class="table-responsive">
                            <table class="table table-bordered table-centered mb-0">
                                <thead class="thead-light">
                                <tr>
                                    <th><?php echo e(__('manager.product_name')); ?></th>
                                    <th><?php echo e(__('manager.products')); ?></th>
                                    <th><?php echo e(__('manager.quantity')); ?></th>
                                    <th><?php echo e(__('manager.price')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $order['carts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($cart['p_name']); ?></td>
                                        <td>
                                            <div>
                                                <?php if(count($cart['product']['product_images'])!=0): ?>
                                                    <img src="<?php echo e(asset('storage/'.$cart['product']['product_images'][0]['url'])); ?>"
                                                         style="object-fit: cover" alt="OOps"
                                                         height="64px"
                                                         width="64px">
                                                <?php else: ?>
                                                    <img src="<?php echo e(\App\Models\Product::getPlaceholderImage()); ?>"
                                                         style="object-fit: cover" alt="OOps"
                                                         height="64px"
                                                         width="64px">
                                                <?php endif; ?>

                                                <?php echo e(\App\Helpers\ProductUtil::getProductItemFeatures($cart['product_item'])); ?>


                                            </div>
                                        </td>
                                        <td>
                                            <?php echo e($cart['quantity']); ?>

                                        </td>
                                        <?php if($cart['p_offer']==0): ?>
                                            <td><?php echo e(\App\Helpers\AppSetting::$currencySign); ?> <?php echo e($cart['p_price']); ?></td>
                                        <?php else: ?>
                                            <td>

                                                <div>
                                                    <span style="font-size: 16px"><?php echo e(\App\Helpers\AppSetting::$currencySign); ?> <?php echo e(\App\Models\Product::getDiscountedPrice($cart['p_price'],$cart['p_offer'])); ?> </span>
                                                    <span style="font-size: 12px;text-decoration: line-through;margin-left: 4px"><?php echo e(\App\Helpers\AppSetting::$currencySign); ?> <?php echo e($cart['p_price']); ?></span>
                                                </div>
                                            </td>

                                        <?php endif; ?>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th scope="row" colspan="3" class="text-right"><?php echo e(__('manager.sub_total')); ?></th>
                                    <td>
                                        <div
                                            class="font-weight-bold"><?php echo e(\App\Helpers\AppSetting::$currencySign); ?> <?php echo e($order['order']); ?></div>
                                    </td>
                                </tr>

                                <?php if($order['coupon_discount']): ?>
                                    <tr>
                                        <th scope="row" colspan="3"
                                            class="text-right"><?php echo e(__('manager.coupon_discount')); ?></th>
                                        <td>
                                            <div>
                                                -<?php echo e(\App\Helpers\AppSetting::$currencySign); ?> <?php echo e($order['coupon_discount']); ?></div>
                                        </td>
                                    </tr>
                                <?php endif; ?>


                                <tr>
                                    <th scope="row" colspan="3" class="text-right"><?php echo e(__('manager.delivery_fee')); ?></th>
                                    <td><?php echo e(\App\Helpers\AppSetting::$currencySign); ?> <?php echo e(round($order['delivery_fee'], 2)); ?></td>
                                </tr>

                                <tr>
                                    <th scope="row" colspan="3" class="text-right"><?php echo e(__('manager.total')); ?></th>
                                    <td>
                                        <div
                                            class="font-weight-bolder"><?php echo e(\App\Helpers\AppSetting::$currencySign); ?> <?php echo e(round($order['total'], 2)); ?></div>
                                    </td>
                                </tr>
                                <tr class="order-revenue-border">
                                    <th scope="row" colspan="3" class="text-right"><?php echo e(__('manager.admin_commission')); ?></th>
                                    <td>
                                        <div
                                            class="font-weight-semibold"><?php echo e(\App\Helpers\AppSetting::$currencySign); ?> <?php echo e($order['admin_revenue']); ?></div>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row" colspan="3" class="text-right"><?php echo e(__('manager.shop_revenue')); ?></th>
                                    <td>
                                        <div
                                            class="font-weight-semibold"><?php echo e(\App\Helpers\AppSetting::$currencySign); ?> <?php echo e($order['shop_revenue']); ?></div>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">


                <?php if(\App\Models\Order::isOrderTypePickup($order['order_type'])): ?>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3"><?php echo e(__('manager.order_status')); ?></h4>
                            <div class="track-order-list mt-4">
                                <ul class="list-unstyled">
                                    <?php if(\App\Models\Order::isCancelStatus($order['status'])): ?>
                                        <p class="text-danger mt-2"><?php echo e(\App\Models\Order::getTextFromStatus($order['status'],$order['order_type'])); ?></p>
                                    <?php elseif($order['status']<5): ?>
                                        <?php for($i=1;$i<4;$i++): ?>
                                            <li class=" <?php if($i<$order['status']): ?> completed <?php endif; ?>">
                                                <?php if($i==$order['status']): ?>
                                                    <span class="active-dot dot"></span>
                                                <?php endif; ?>
                                                <h5 class="mt-0 mb-4"><?php echo e(\App\Models\Order::getTextFromStatus($i,$order['order_type'])); ?></h5>
                                            </li>
                                        <?php endfor; ?>
                                    <?php elseif($order['status']==5): ?>
                                        <p class="text-success mt-2"><?php echo e(__('manager.this_order_has_been_delivered')); ?></p>
                                    <?php elseif($order['status']==6): ?>
                                        <p class="text-success mt-2"><?php echo e(__('manager.this_order_has_been_delivered_and_rated')); ?></p>
                                    <?php endif; ?>
                                </ul>

                                <div class="row">
                                    <div class="col text-right">
                                        <a href="<?php echo e(route('manager.orders.index')); ?>">
                                            <button type="button"
                                                    class="btn w-sm btn-light waves-effect"><?php echo e(__('manager.go_to_orders')); ?>

                                            </button>
                                        </a>
                                        <?php if($order['status'] == 1 ): ?>
                                        <?php echo e(dd($order)); ?>

                                            <?php if( \Carbon\Carbon::now()->diffInHours($order['orderDatetime'], false) >= 0): ?>

                                                <form action="<?php echo e(route('manager.orders.update',['id'=>$order['id']])); ?>"
                                                    method="post" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo e(method_field('PATCH')); ?>

                                                    <input type="hidden" name="status" value="<?php echo e($order['status']+1); ?>">
                                                    <button type="submit"
                                                            class="btn w-sm btn-primary waves-effect waves-light ml-2"><?php echo e(\App\Models\Order::getActionFromStatus($order['status']+1,$order['order_type'])); ?>

                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <form action="<?php echo e(route('manager.orders.update',['id'=>$order['id']])); ?>"
                                                  method="post" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo e(method_field('PATCH')); ?>

                                                <input type="hidden" name="status" value="<?php echo e(\App\Models\Order::$ORDER_CANCELLED_BY_SHOP); ?>">
                                                <button type="submit"
                                                        class="btn w-sm btn-danger waves-effect waves-light ml-2"><?php echo e(__('manager.cancel')); ?>

                                                </button>
                                            </form>
                                        <?php elseif($order['status']==2): ?>
                                            <form
                                                action="<?php echo e(route('manager.orders.update',['id'=>$order['id']])); ?>"
                                                method="post" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo e(method_field('PATCH')); ?>

                                                <input type="hidden" name="status" value="<?php echo e($order['status']+1); ?>">
                                                <button type="submit"
                                                        class="btn w-sm btn-primary waves-effect waves-light ml-2"><?php echo e(\App\Models\Order::getActionFromStatus($order['status']+1,$order['order_type'])); ?>

                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php else: ?>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3"><?php echo e(__('manager.order_status')); ?></h4>
                            <div class="track-order-list mt-4">
                                <ul class="list-unstyled">
                                    <?php if(\App\Models\Order::isCancelStatus($order['status'])): ?>
                                        <p class="text-danger mt-2"><?php echo e(\App\Models\Order::getTextFromStatus($order['status'],$order['order_type'])); ?></p>

                                    <?php elseif($order['status']<5): ?>
                                        <?php for($i=1;$i<5;$i++): ?>
                                            <li class=" <?php if($i<$order['status']): ?> completed <?php endif; ?>">
                                                <?php if($i==$order['status']): ?>
                                                    <span class="active-dot dot"></span>
                                                <?php endif; ?>
                                                <h5 class="mt-0 mb-4"><?php echo e(\App\Models\Order::getTextFromStatus($i,$order['order_type'])); ?></h5>
                                            </li>
                                        <?php endfor; ?>
                                    <?php elseif($order['status']==5): ?>

                                        <p class="text-success mt-2"><?php echo e(__('manager.this_order_has_been_delivered')); ?></p>
                                    <?php elseif($order['status']==6): ?>

                                        <p class="text-success mt-2"><?php echo e(__('manager.this_order_has_been_delivered_and_rated')); ?></p>
                                    <?php endif; ?>
                                </ul>
                                <div class="row">
                                    <div class="col text-right">
                                        <a href="<?php echo e(route('manager.orders.index')); ?>">
                                            <button type="button"
                                                    class="btn w-sm btn-light waves-effect"><?php echo e(__('manager.go_to_orders')); ?>

                                            </button>
                                        </a>
                                        <?php if($order['status']==1): ?>
                                            <?php if(\Carbon\Carbon::now()->lessThan(\Carbon\Carbon::parse($order['orderDatetime']))): ?>
                                                <span class="btn w-sm btn-primary waves-effect waves-light ml-2"  id="showPopupButton">
                                                    <?php echo e(trans('admin.okay')); ?>

                                                </span>
                                            <?php else: ?>
                                                <form action="<?php echo e(route('manager.orders.update',['id'=>$order['id']])); ?>"
                                                    method="post" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo e(method_field('PATCH')); ?>

                                                    <input type="hidden" name="status" value="<?php echo e($order['status']+1); ?>">
                                                    <button type="submit" class="btn w-sm btn-primary waves-effect waves-light ml-2">
                                                        <?php echo e(\App\Models\Order::getActionFromStatus($order['status'] + 1, $order['order_type'])); ?>

                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <form action="<?php echo e(route('manager.orders.update',['id'=>$order['id']])); ?>"
                                                  method="post" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo e(method_field('PATCH')); ?>

                                                <input type="hidden" name="status" value="<?php echo e(\App\Models\Order::$ORDER_CANCELLED_BY_SHOP); ?>">
                                                <button type="submit"
                                                        class="btn w-sm btn-danger waves-effect waves-light ml-2"><?php echo e(__('manager.cancel')); ?>

                                                </button>
                                            </form>
                                        <?php elseif($order['status']==2): ?>
                                            <form
                                                action="<?php echo e(route('manager.delivery-boys.showForAssign',['order_id'=>$order['id']])); ?>"
                                                method="GET" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit"
                                                        class="btn w-sm btn-primary waves-effect waves-light ml-2"><?php echo e(\App\Models\Order::getActionFromStatus($order['status']+1,$order['order_type'])); ?>

                                                </button>
                                            </form>
                                        <?php elseif($order['delivery_boy'] && (!$order['status']==6)): ?>
                                            <a target="_blank" class="ml-1"
                                               href="<?php echo e(\App\Models\Order::generateGoogleMapLocationUrl($order['delivery_boy']['latitude'],$order['delivery_boy']['longitude'])); ?>">
                                                <button type="button"
                                                        class="btn w-sm btn-primary waves-effect"><?php echo e(__('manager.track_order')); ?>

                                                </button>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>

            </div>

        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3"><?php echo e(__('manager.shipping_information')); ?></h4>
                        <h5 class="font-family-primary font-weight-semibold"><?php echo e($order['user']['name']); ?></h5>
                        <?php if(\App\Models\Order::isOrderTypePickup($order['order_type'])): ?>
                            <p class="mb-2"><span
                                    class="font-weight-semibold mr-2"><?php echo e(\App\Models\Order::getTextFromOrderType($order['order_type'])); ?>

                            </p>
                        <?php else: ?>
                            <p class="mb-2"><span
                                    class="font-weight-semibold mr-2"><?php echo e(__('manager.address')); ?>:</span><?php echo e($order['address']['address']); ?> <?php echo e($order['address']['city']); ?> <?php echo e($order['address']['pincode']); ?>

                            </p>
                        <?php endif; ?>

                        <?php if(! \App\Models\Order::isOrderTypePickup($order['order_type'])): ?>
                            <a target="_blank" class="mt-1"
                               href="<?php echo e(\App\Models\Order::generateGoogleMapLocationUrl($order['address']['latitude'],$order['address']['longitude'])); ?>">
                                <button type="button"
                                        class="btn w-sm btn-outline-primary waves-effect"><?php echo e(__('manager.delivery_location')); ?>

                                </button>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div> <!-- end col -->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3"><?php echo e(__('manager.billing_information')); ?></h4>

                        <ul class="list-unstyled mb-0">
                            <li>
                                <p class="mb-2"><span
                                        class="font-weight-bold mr-2"><?php echo e(__('manager.OTP')); ?> :</span> <?php echo e($order['otp']); ?>

                                </p>
                                <p class="mb-2"><span
                                        class="font-weight-bold mr-2"><?php echo e(__('manager.payment_type')); ?> :</span> <?php echo e(\App\Models\Order::getTextFromPaymentType($order['order_payment']['payment_type'])); ?>

                                </p>
                                <?php if(\App\Models\Order::isPaymentByRazorpay($order['order_payment']['payment_type'])): ?>
                                    <p class="mb-2" style="letter-spacing: 0.5px"><span
                                            class="font-weight-semibold mr-2">Razorpay ID:</span> <a target="_blank"
                                                                                                     href=<?php echo e("https://dashboard.razorpay.com/app/payments/".$order['order_payment']['payment_id']); ?>><?php echo e($order['order_payment']['payment_id']); ?></a>
                                    </p>
                              <?php elseif(\App\Models\Order::isPaymentByPaystack($order['order_payment']['payment_type'])): ?>
                                    <p class="mb-2" style="letter-spacing: 0.5px"><span
                                            class="font-weight-semibold mr-2">Razorpay ID:</span> <a target="_blank"
                                                                                                     href=<?php echo e("https://dashboard.paystack.com/#/search?model=transactions&query=".$order['order_payment']['payment_id']); ?>><?php echo e($order['order_payment']['payment_id']); ?></a>
                                    </p>

                                <?php endif; ?>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>

            <?php if(!\App\Models\Order::isOrderTypePickup($order['order_type'])): ?>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3"><?php echo e(__('manager.delivery_boy')); ?></h4>
                            <?php if($order['delivery_boy']): ?>
                                <div class="text-center">
                                    <img src="<?php echo e(asset('/storage/'.$order['delivery_boy']['avatar_url'])); ?>"
                                         class="img-fluid rounded-circle"
                                         alt="" height="44px" width="44px"/>
                                    <h5><b><?php echo e($order['delivery_boy']['name']); ?></b></h5>
                                    <p class="mb-1"><span
                                            class="font-weight-semibold"><?php echo e(__('manager.email')); ?> :</span> <?php echo e($order['delivery_boy']['email']); ?>

                                    </p>
                                    <p class="mb-0"><span
                                            class="font-weight-semibold"><?php echo e(__('manager.phone')); ?> :</span> <?php echo e($order['delivery_boy']['mobile']); ?>

                                    </p>
                                </div>
                            <?php else: ?>
                                <div class="text-center">
                                    <h5><?php echo e(__('manager.first_assign_delivery_boy')); ?></h5>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div> <!-- end col -->
            <?php endif; ?>
        </div>
    </div> <!-- container -->

    
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" id="closePopupButton">&times;</span>
            <p><?php echo e(trans('admin.Wait-date-order')); ?></p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    document.getElementById("showPopupButton").addEventListener("click", function() {
        var popup = document.getElementById("popup");
        popup.style.display = "block";
    });

    document.getElementById("closePopupButton").addEventListener("click", function() {
        var popup = document.getElementById("popup");
        popup.style.display = "none";
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('manager.layouts.app', ['title' => 'Edit Order'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\joudon\wasilapp\resources\views/manager/orders/edit-order.blade.php ENDPATH**/ ?>