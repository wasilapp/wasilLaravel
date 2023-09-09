@extends('manager.layouts.app', ['title' => 'Edit Order'])

@section('css')

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

@endsection

@section('content')

{{-- dd($order['status']) --}}
{{-- dd(\Carbon\Carbon::now()) --}}
{{-- @if( \Carbon\Carbon::now()->diffInHours($order['orderDatetime'], false) >= 0)
{{ dd($order) }}
@endif --}}
    <!-- Start Content-->
    <div class="container-fluid">
        <x-alert></x-alert>

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">{{env('APP_NAME')}}</a>
                            </li>
                            <li class="breadcrumb-item"><a
                                    href="{{route('manager.orders.index')}}">{{__('manager.orders')}}</a></li>
                            <li class="breadcrumb-item active">{{__('manager.edit')}}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{__('manager.edit')}}</h4>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">{{__('manager.order')}} #{{$order['id']}} </h4>

                        <div class="table-responsive">
                            <table class="table table-bordered table-centered mb-0">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{__('manager.product_name')}}</th>
                                    <th>{{__('manager.products')}}</th>
                                    <th>{{__('manager.quantity')}}</th>
                                    <th>{{__('manager.price')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order['carts'] as $cart)
                                    <tr>
                                        <td>{{$cart['p_name']}}</td>
                                        <td>
                                            <div>
                                                @if(count($cart['product']['product_images'])!=0)
                                                    <img src="{{asset('storage/'.$cart['product']['product_images'][0]['url'])}}"
                                                         style="object-fit: cover" alt="OOps"
                                                         height="64px"
                                                         width="64px">
                                                @else
                                                    <img src="{{\App\Models\Product::getPlaceholderImage()}}"
                                                         style="object-fit: cover" alt="OOps"
                                                         height="64px"
                                                         width="64px">
                                                @endif

                                                {{\App\Helpers\ProductUtil::getProductItemFeatures($cart['product_item'])}}

                                            </div>
                                        </td>
                                        <td>
                                            {{$cart['quantity']}}
                                        </td>
                                        @if($cart['p_offer']==0)
                                            <td>{{\App\Helpers\AppSetting::$currencySign}} {{$cart['p_price']}}</td>
                                        @else
                                            <td>

                                                <div>
                                                    <span style="font-size: 16px">{{\App\Helpers\AppSetting::$currencySign}} {{\App\Models\Product::getDiscountedPrice($cart['p_price'],$cart['p_offer'])}} </span>
                                                    <span style="font-size: 12px;text-decoration: line-through;margin-left: 4px">{{\App\Helpers\AppSetting::$currencySign}} {{$cart['p_price']}}</span>
                                                </div>
                                            </td>

                                        @endif

                                    </tr>
                                @endforeach
                                <tr>
                                    <th scope="row" colspan="3" class="text-right">{{__('manager.sub_total')}}</th>
                                    <td>
                                        <div
                                            class="font-weight-bold">{{\App\Helpers\AppSetting::$currencySign}} {{$order['order']}}</div>
                                    </td>
                                </tr>

                                @if($order['coupon_discount'])
                                    <tr>
                                        <th scope="row" colspan="3"
                                            class="text-right">{{__('manager.coupon_discount')}}</th>
                                        <td>
                                            <div>
                                                -{{\App\Helpers\AppSetting::$currencySign}} {{$order['coupon_discount']}}</div>
                                        </td>
                                    </tr>
                                @endif


                                <tr>
                                    <th scope="row" colspan="3" class="text-right">{{__('manager.delivery_fee')}}</th>
                                    <td>{{\App\Helpers\AppSetting::$currencySign}} {{round($order['delivery_fee'], 2)}}</td>
                                </tr>

                                <tr>
                                    <th scope="row" colspan="3" class="text-right">{{__('manager.total')}}</th>
                                    <td>
                                        <div
                                            class="font-weight-bolder">{{\App\Helpers\AppSetting::$currencySign}} {{round($order['total'], 2)}}</div>
                                    </td>
                                </tr>
                                <tr class="order-revenue-border">
                                    <th scope="row" colspan="3" class="text-right">{{__('manager.admin_commission')}}</th>
                                    <td>
                                        <div
                                            class="font-weight-semibold">{{\App\Helpers\AppSetting::$currencySign}} {{$order['admin_revenue']}}</div>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row" colspan="3" class="text-right">{{__('manager.shop_revenue')}}</th>
                                    <td>
                                        <div
                                            class="font-weight-semibold">{{\App\Helpers\AppSetting::$currencySign}} {{$order['shop_revenue']}}</div>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">


                @if(\App\Models\Order::isOrderTypePickup($order['order_type']))
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">{{__('manager.order_status')}}</h4>
                            <div class="track-order-list mt-4">
                                <ul class="list-unstyled">
                                    @if(\App\Models\Order::isCancelStatus($order['status']))
                                        <p class="text-danger mt-2">{{\App\Models\Order::getTextFromStatus($order['status'],$order['order_type'])}}</p>
                                    @elseif($order['status']<5)
                                        @for($i=1;$i<4;$i++)
                                            <li class=" @if($i<$order['status']) completed @endif">
                                                @if($i==$order['status'])
                                                    <span class="active-dot dot"></span>
                                                @endif
                                                <h5 class="mt-0 mb-4">{{\App\Models\Order::getTextFromStatus($i,$order['order_type'])}}</h5>
                                            </li>
                                        @endfor
                                    @elseif($order['status']==5)
                                        <p class="text-success mt-2">{{__('manager.this_order_has_been_delivered')}}</p>
                                    @elseif($order['status']==6)
                                        <p class="text-success mt-2">{{__('manager.this_order_has_been_delivered_and_rated')}}</p>
                                    @endif
                                </ul>

                                <div class="row">
                                    <div class="col text-right">
                                        <a href="{{route('manager.orders.index')}}">
                                            <button type="button"
                                                    class="btn w-sm btn-light waves-effect">{{__('manager.go_to_orders')}}
                                            </button>
                                        </a>
                                        @if($order['status'] == 1 )
                                        {{ dd($order) }}
                                            @if( \Carbon\Carbon::now()->diffInHours($order['orderDatetime'], false) >= 0)

                                                <form action="{{route('manager.orders.update',['id'=>$order['id']])}}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    {{method_field('PATCH')}}
                                                    <input type="hidden" name="status" value="{{$order['status']+1}}">
                                                    <button type="submit"
                                                            class="btn w-sm btn-primary waves-effect waves-light ml-2">{{\App\Models\Order::getActionFromStatus($order['status']+1,$order['order_type'])}}
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{route('manager.orders.update',['id'=>$order['id']])}}"
                                                  method="post" class="d-inline">
                                                @csrf
                                                {{method_field('PATCH')}}
                                                <input type="hidden" name="status" value="{{\App\Models\Order::$ORDER_CANCELLED_BY_SHOP}}">
                                                <button type="submit"
                                                        class="btn w-sm btn-danger waves-effect waves-light ml-2">{{__('manager.cancel')}}
                                                </button>
                                            </form>
                                        @elseif($order['status']==2)
                                            <form
                                                action="{{route('manager.orders.update',['id'=>$order['id']])}}"
                                                method="post" class="d-inline">
                                                @csrf
                                                {{method_field('PATCH')}}
                                                <input type="hidden" name="status" value="{{$order['status']+1}}">
                                                <button type="submit"
                                                        class="btn w-sm btn-primary waves-effect waves-light ml-2">{{\App\Models\Order::getActionFromStatus($order['status']+1,$order['order_type'])}}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">{{__('manager.order_status')}}</h4>
                            <div class="track-order-list mt-4">
                                <ul class="list-unstyled">
                                    @if(\App\Models\Order::isCancelStatus($order['status']))
                                        <p class="text-danger mt-2">{{\App\Models\Order::getTextFromStatus($order['status'],$order['order_type'])}}</p>

                                    @elseif($order['status']<5)
                                        @for($i=1;$i<5;$i++)
                                            <li class=" @if($i<$order['status']) completed @endif">
                                                @if($i==$order['status'])
                                                    <span class="active-dot dot"></span>
                                                @endif
                                                <h5 class="mt-0 mb-4">{{\App\Models\Order::getTextFromStatus($i,$order['order_type'])}}</h5>
                                            </li>
                                        @endfor
                                    @elseif($order['status']==5)

                                        <p class="text-success mt-2">{{__('manager.this_order_has_been_delivered')}}</p>
                                    @elseif($order['status']==6)

                                        <p class="text-success mt-2">{{__('manager.this_order_has_been_delivered_and_rated')}}</p>
                                    @endif
                                </ul>
                                <div class="row">
                                    <div class="col text-right">
                                        <a href="{{route('manager.orders.index')}}">
                                            <button type="button"
                                                    class="btn w-sm btn-light waves-effect">{{__('manager.go_to_orders')}}
                                            </button>
                                        </a>
                                        @if($order['status']==1)
                                            @if(\Carbon\Carbon::now()->diffInHours($order['orderDatetime'], false) >= 0)
                                                <form action="{{route('manager.orders.update',['id'=>$order['id']])}}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    {{method_field('PATCH')}}
                                                    <input type="hidden" name="status" value="{{$order['status']+1}}">
                                                        <button type="submit" class="btn w-sm btn-primary waves-effect waves-light ml-2">
                                                            {{ \App\Models\Order::getActionFromStatus($order['status'] + 1, $order['order_type']) }}
                                                        </button>
                                                </form>
                                            @else
                                                <span class="btn w-sm btn-primary waves-effect waves-light ml-2"  id="showPopupButton">
                                                    {{ trans('admin.okay') }}
                                                </span>
                                            @endif
                                            <form action="{{route('manager.orders.update',['id'=>$order['id']])}}"
                                                  method="post" class="d-inline">
                                                @csrf
                                                {{method_field('PATCH')}}
                                                <input type="hidden" name="status" value="{{\App\Models\Order::$ORDER_CANCELLED_BY_SHOP}}">
                                                <button type="submit"
                                                        class="btn w-sm btn-danger waves-effect waves-light ml-2">{{__('manager.cancel')}}
                                                </button>
                                            </form>
                                        @elseif($order['status']==2)
                                            <form
                                                action="{{route('manager.delivery-boys.showForAssign',['order_id'=>$order['id']])}}"
                                                method="GET" class="d-inline">
                                                @csrf
                                                <button type="submit"
                                                        class="btn w-sm btn-primary waves-effect waves-light ml-2">{{\App\Models\Order::getActionFromStatus($order['status']+1,$order['order_type'])}}
                                                </button>
                                            </form>
                                        @elseif($order['delivery_boy'] && (!$order['status']==6))
                                            <a target="_blank" class="ml-1"
                                               href="{{\App\Models\Order::generateGoogleMapLocationUrl($order['delivery_boy']['latitude'],$order['delivery_boy']['longitude'])}}">
                                                <button type="button"
                                                        class="btn w-sm btn-primary waves-effect">{{__('manager.track_order')}}
                                                </button>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endif

            </div>

        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">{{__('manager.shipping_information')}}</h4>
                        <h5 class="font-family-primary font-weight-semibold">{{$order['user']['name']}}</h5>
                        @if(\App\Models\Order::isOrderTypePickup($order['order_type']))
                            <p class="mb-2"><span
                                    class="font-weight-semibold mr-2">{{\App\Models\Order::getTextFromOrderType($order['order_type'])}}
                            </p>
                        @else
                            <p class="mb-2"><span
                                    class="font-weight-semibold mr-2">{{__('manager.address')}}:</span>{{$order['address']['address']}} {{$order['address']['city']}} {{$order['address']['pincode']}}
                            </p>
                        @endif

                        @if(! \App\Models\Order::isOrderTypePickup($order['order_type']))
                            <a target="_blank" class="mt-1"
                               href="{{\App\Models\Order::generateGoogleMapLocationUrl($order['address']['latitude'],$order['address']['longitude'])}}">
                                <button type="button"
                                        class="btn w-sm btn-outline-primary waves-effect">{{__('manager.delivery_location')}}
                                </button>
                            </a>
                        @endif
                    </div>
                </div>
            </div> <!-- end col -->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">{{__('manager.billing_information')}}</h4>

                        <ul class="list-unstyled mb-0">
                            <li>
                                <p class="mb-2"><span
                                        class="font-weight-bold mr-2">{{__('manager.OTP')}} :</span> {{$order['otp']}}
                                </p>
                                <p class="mb-2"><span
                                        class="font-weight-bold mr-2">{{__('manager.payment_type')}} :</span> {{\App\Models\Order::getTextFromPaymentType($order['order_payment']['payment_type'])}}
                                </p>
                                @if(\App\Models\Order::isPaymentByRazorpay($order['order_payment']['payment_type']))
                                    <p class="mb-2" style="letter-spacing: 0.5px"><span
                                            class="font-weight-semibold mr-2">Razorpay ID:</span> <a target="_blank"
                                                                                                     href={{"https://dashboard.razorpay.com/app/payments/".$order['order_payment']['payment_id']}}>{{$order['order_payment']['payment_id']}}</a>
                                    </p>
                              @elseif(\App\Models\Order::isPaymentByPaystack($order['order_payment']['payment_type']))
                                    <p class="mb-2" style="letter-spacing: 0.5px"><span
                                            class="font-weight-semibold mr-2">Razorpay ID:</span> <a target="_blank"
                                                                                                     href={{"https://dashboard.paystack.com/#/search?model=transactions&query=".$order['order_payment']['payment_id']}}>{{$order['order_payment']['payment_id']}}</a>
                                    </p>

                                @endif
                            </li>
                        </ul>

                    </div>
                </div>
            </div>

            @if(!\App\Models\Order::isOrderTypePickup($order['order_type']))
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">{{__('manager.delivery_boy')}}</h4>
                            @if($order['delivery_boy'])
                                <div class="text-center">
                                    <img src="{{asset('/storage/'.$order['delivery_boy']['avatar_url'])}}"
                                         class="img-fluid rounded-circle"
                                         alt="" height="44px" width="44px"/>
                                    <h5><b>{{$order['delivery_boy']['name']}}</b></h5>
                                    <p class="mb-1"><span
                                            class="font-weight-semibold">{{__('manager.email')}} :</span> {{$order['delivery_boy']['email']}}
                                    </p>
                                    <p class="mb-0"><span
                                            class="font-weight-semibold">{{__('manager.phone')}} :</span> {{$order['delivery_boy']['mobile']}}
                                    </p>
                                </div>
                            @else
                                <div class="text-center">
                                    <h5>{{__('manager.first_assign_delivery_boy')}}</h5>
                                </div>
                            @endif

                        </div>
                    </div>
                </div> <!-- end col -->
            @endif
        </div>
    </div> <!-- container -->

    {{-- pop window --}}
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" id="closePopupButton">&times;</span>
            <p>{{ trans('admin.Wait-date-order') }}</p>
        </div>
    </div>
@endsection

@section('script')
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
@endsection
