

<?php $__env->startSection('css'); ?>
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
                            <li class="breadcrumb-item active"><?php echo e(__('manager.orders')); ?></li>
                        </ol>
                    </div>
                    <h4 class="page-title"><?php echo e(__('manager.orders')); ?></h4>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">


                        <div class="float-right">
                            <?php echo e($orders->links()); ?>

                        </div>
      
                         <div class="float-right m-4 mx-2 " >
                            <ul class="" id="statu">
                                <a href="<?php echo e(route('manager.orders.index')); ?>"> <li value="">All</li></a>
                                <?php for($i=1;$i<6;$i++): ?>
                                     <a href="<?php echo e(route('manager.status',$i)); ?>"> <li value="<?php echo e($i); ?>"><?php echo e(\App\Models\Order::getTextFromStatus($i,2)); ?></li></a>
                                <?php endfor; ?>

                            </ul>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-hover mb-0">
                                <thead class="thead-light">
                                <tr>
                                    <th><?php echo e(__('manager.order')); ?> ID</th>
                                    <th><?php echo e(__('manager.date')); ?></th>
                                    <th><?php echo e(__('manager.order_type')); ?></th>
                                    <th><?php echo e(__('manager.payment_method')); ?></th>
                                    <th><?php echo e(__('manager.total')); ?></th>
                                    <th style="width: 250px;"><?php echo e(__('manager.order_status')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr href="<?php echo e(route('manager.orders.edit',['id'=>$order['id']])); ?>">

                                        <td><span class=" text-body font-weight-bold">#<?php echo e($order['id']); ?></span></td>
                                        <?php if($order->orderTime ): ?>
                                        <?php $date = strtotime($order->orderTime['order_date']); 
                                                $time = strtotime($order->orderTime['order_time']);  ?>
                                        <td> <?php echo e(date('M d Y', $date)); ?>

                                                <small
                                                class="text-muted"> <?php echo e(date('h:i A', $time)); ?> </small>
                                             </td>
                                        <?php else: ?>
                                        <td> <?php echo e(\Carbon\Carbon::parse($order['created_at'])->setTimezone(\App\Helpers\AppSetting::$timezone)->format('M d Y')); ?>

                                            <small
                                                class="text-muted"><?php echo e(\Carbon\Carbon::parse($order['created_at'])->setTimezone(\App\Helpers\AppSetting::$timezone)->format('h:i A')); ?></small>
                                        </td>
                                        <?php endif; ?>
                                        <td><?php echo e(\App\Models\Order::getTextFromOrderType($order['order_type'])); ?></td>
                                        <td><?php echo e(\App\Models\Order::getTextFromPaymentType($order['orderPayment']['payment_type'])); ?></td>
                                        <td>$ <?php echo e(round($order['total'], 2)); ?></td>
                                        <td>
                                            <?php if(\App\Models\Order::isCancelStatus($order['status'])): ?>
                                                <span
                                                    class="text-danger"><?php echo e(\App\Models\Order::getTextFromStatus($order['status'],$order['order_type'])); ?></span>
                                            <?php elseif(\App\Models\Order::isPaymentConfirm($order['status'])): ?>
                                                <a href="<?php echo e(route('manager.orders.edit',['id'=>$order['id']])); ?>"> <?php echo e(\App\Models\Order::getTextFromStatus($order['status'],$order['order_type'])); ?></a>
                                            <?php else: ?>
                                                <span
                                                    class="text-danger"><?php echo e(\App\Models\Order::getTextFromStatus($order['status'],$order['order_type'])); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>


                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div>
        </div>
    </div> <!-- container -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('manager.layouts.app', ['title' => 'Orders'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\joudon\wasilapp\resources\views/manager/orders/orders.blade.php ENDPATH**/ ?>