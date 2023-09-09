<?php

use App\Helpers\TextUtil;
use Illuminate\Support\Facades\Route;
use App\Models\Order;
use App\Models\ShopRequest;
use App\Models\DeliveryBoy;
use Carbon\Carbon;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/test',[App\Http\Controllers\Controller::class,'test'])->name('test');
// Route::get('/test',function(){

// 	   dd('$response');
//         // $booking = session()->get('booking');
//         $url = 'https://softya.com/demo/public/api/customers';

//         $response = Http::timeout(60)->get($url);


//         $body = $response->getBody()->getContents();
//         dd($body);

// })->name('test');
Route::get('/testView',[App\Http\Controllers\Controller::class,'testView']);

Route::get('privacy-policy',[App\Http\Controllers\Controller::class,'privacy']);
Route::get('admin/privacy-policy',[App\Http\Controllers\Admin\AdminController::class,'create_privacy'])->name('user.privacy');
Route::put('admin/privacy-policy/update',[App\Http\Controllers\Admin\AdminController::class,'updatePrivacy']);



Route::prefix('/user')->group(function (){

    Route::get('/mobile/orders/{order_id}/payment/stripe/pay/', 'User\OrderPaymentController@stripePaymentViaMobile');
    Route::post('/mobile/orders/payment/stripe/callback/', 'User\OrderPaymentController@stripeCallbackViaMobile')->name('user.mobile.orders_payment.stripe.callback');
});

Route::get('/',function(){
    return redirect('/ar');
});
if(str_contains(request()->url(),'/ar')){
    $locale = 'ar';
}
else{
    $locale = 'en';
}
Route::group(['middleware'=>'locale', 'prefix' => $locale],function (){

    Route::prefix('admin')->group(function (){



        Route::get('/login',[App\Http\Controllers\Admin\Auth\LoginController::class,'showLoginForm']);
        Route::get('/register','Admin\Auth\RegisterController@showRegisterForm')->name('manager.register');
        Route::post('/login','Admin\Auth\LoginController@login')->name('admin.login');
        Route::post('/register','Admin\Auth\RegisterController@create')->name('admin.register');


        //Password  Reset
        Route::post('/password/email','Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
        Route::get('/password/reset','Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
        Route::post('/password/reset','Admin\Auth\ResetPasswordController@reset');
        Route::get('/password/reset/{token}','Admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');

    });

    Route::prefix('manager')->group(function (){

        Route::get('/login','Manager\Auth\LoginController@showLoginForm');
        Route::get('/register','Manager\Auth\RegisterController@showRegisterForm');
        Route::post('/login','Manager\Auth\LoginController@login')->name('manager.login');
        Route::post('/register','Manager\Auth\RegisterController@create')->name('manager.register');


        //Password  Reset
        Route::post('/password/email','Manager\Auth\ForgotPasswordController@sendResetLinkEmail')->name('manager.password.email');
        Route::get('/password/reset','Manager\Auth\ForgotPasswordController@showLinkRequestForm')->name('manager.password.request');
        Route::post('/password/reset','Manager\Auth\ResetPasswordController@reset');
        Route::get('/password/reset/{token}','Manager\Auth\ResetPasswordController@showResetForm')->name('manager.password.reset');

        //Print Receipt
       // Route::get('/orders/{id}/receipt','Manager\OrderReceiptController@show')->name('user.orders.receipt');



    });

    Route::prefix('user')->group(function (){

        Route::get('/login','User\Auth\LoginController@showLoginForm');
        Route::get('/register','User\Auth\RegisterController@showRegisterForm');
        Route::post('/login','User\Auth\LoginController@login')->name('user.login');
        Route::post('/register','User\Auth\RegisterController@create')->name('user.register');


        //Password  Reset
        Route::post('/password/email','User\Auth\ForgotPasswordController@sendResetLinkEmail')->name('user.password.email');
        Route::get('/password/reset','User\Auth\ForgotPasswordController@showLinkRequestForm')->name('user.password.request');
        Route::post('/password/reset','User\Auth\ResetPasswordController@reset');
        Route::get('/password/reset/{token}','User\Auth\ResetPasswordController@showResetForm')->name('user.password.reset');

    });

    Route::group(['middleware'=>'auth:admin','prefix'=>'/admin'],function (){
        Route::get('/status/{id}/orders' , function($id){
            $orders =  Order::with('shop', 'orderPayment')->where('status',$id)->orderBy('updated_at','DESC')->paginate(10);
                return view('admin.orders.orders')->with([
                    'orders'=>$orders
                ]);
        })->name('status');

        //----------------------------- Auth -----------------------------------//
        Route::get('/logout','Admin\Auth\LoginController@logout')->name('admin.logout');

         Route::get('/create/privacy','Admin\AdminController@create_privacy')->name('user.create.privacy');
         Route::post('/create/privacy','Admin\AdminController@updatePrivacy')->name('user.store.privacy');

        // ------------------------ Admin ---------------------------//
        Route::get('/','Admin\AdminController@index')->name('admin.dashboard');
        Route::get('/setting','Admin\AdminController@edit')->name('admin.setting.edit');
        Route::patch('/setting','Admin\AdminController@update')->name('admin.setting.update');
        Route::patch('/setting/updateLocale/{langCode}','Admin\AdminController@updateLocale')->name('admin.setting.updateLocale');

        //----------------------- Add Data -----------------------------//
        Route::get('/app_data','Admin\AppDataController@index')->name('admin.appdata.index');
        Route::post('/app_data','Admin\AppDataController@create')->name('admin.appdata.create');


        //----------------------- Banner -----------------------------//
        Route::get('/banners','Admin\BannerController@index')->name('admin.banners.index');
        Route::post('/banners','Admin\BannerController@store')->name('admin.banners.store');
        Route::delete('/banners','Admin\BannerController@destroy')->name('admin.banners.destroy');



        //-------------------------------- Category --------------------------------//

        //Index
        Route::get('/users/','Admin\UserController@index')->name('admin.users.index');
        Route::get('/users/{id}','Admin\UserController@edit')->name('admin.users.edit');
        Route::patch('/users/{id}','Admin\UserController@update')->name('admin.users.update');
        Route::DELETE('/users/{id}','Admin\UserController@destroy')->name('admin.users.destroy');


        //-------------------------------- Category --------------------------------//

        //Index
        Route::get('/categories/','Admin\CategoryController@index')->name('admin.categories.index');

        //Create
        Route::get('/categories/create','Admin\CategoryController@create')->name('admin.categories.create');
        Route::post('/categories','Admin\CategoryController@store')->name('admin.categories.store');

        //Read
        Route::get('/categories/{id}','Admin\CategoryController@show')->name('admin.categories.show');

        //Update
        Route::get('/categories/{id}/edit','Admin\CategoryController@edit')->name('admin.categories.edit');
        Route::patch('/categories/{id}','Admin\CategoryController@update')->name('admin.categories.update');

        //Delete
        Route::get('/categories/{id}/delete','Admin\CategoryController@destroy')->name('admin.categories.delete');

        //-------------------------------- Sub - Category --------------------------------//

        //Index
        Route::get('/sub_categories/','Admin\SubCategoryController@index')->name('admin.sub-categories.index');

        //Create
        Route::get('/sub_categories/create','Admin\SubCategoryController@create')->name('admin.sub-categories.create');
        Route::post('/sub_categories','Admin\SubCategoryController@store')->name('admin.sub-categories.store');

        //Read
        Route::get('/sub_categories/{id}','Admin\SubCategoryController@show')->name('admin.sub-categories.show');

        //Update
        Route::get('/sub_categories/{id}/edit','Admin\SubCategoryController@edit')->name('admin.sub-categories.edit');
        Route::patch('/sub_categories/{id}','Admin\SubCategoryController@update')->name('admin.sub-categories.update');

        //Delete
        Route::get('/sub_categories/{id}/delete','Admin\SubCategoryController@destroy')->name('admin.sub-categories.delete');



        //-------------------------------- Coupon --------------------------------//

        //Index
        Route::get('/coupons','Admin\CouponController@index')->name('admin.coupons.index');

        //Create
        Route::get('/coupons/create','Admin\CouponController@create')->name('admin.coupons.create');
        Route::post('/coupons','Admin\CouponController@store')->name('admin.coupons.store');

        //Read
        Route::get('/coupons/{id}','Admin\CouponController@show')->name('admin.coupons.show');

        //Update
        Route::get('/coupons/{id}/edit','Admin\CouponController@edit')->name('admin.coupons.edit');
        Route::patch('/coupons/{id}','Admin\CouponController@update')->name('admin.coupons.update');

        //Delete
        Route::delete('/coupons/{id}','Admin\CouponController@destroy')->name('admin.coupons.destroy');


//--------------------------------Wallet  Coupon --------------------------------//

        //Index
        Route::get('/wallet-coupons','Admin\WalletCouponsController@index')->name('admin.wallet-coupons.index');

        // //Create
        Route::get('/wallet-coupons/create','Admin\WalletCouponsController@create')->name('admin.wallet-coupons.create');
        Route::post('/wallet-coupons','Admin\WalletCouponsController@store')->name('admin.wallet-coupons.store');

        // //Read
        Route::get('/wallet-coupons/{id}','Admin\WalletCouponsController@show')->name('admin.wallet-coupons.show');

        // //Update
        // Route::get('/coupons/{id}/edit','Admin\CouponController@edit')->name('admin.coupons.edit');
        Route::patch('/wallet-coupons/{id}','Admin\WalletCouponsController@update')->name('admin.wallet-coupons.update');

        // //Delete
        // Route::delete('/coupons/{id}','Admin\CouponController@destroy')->name('admin.coupons.destroy');



        //-------------------------------- Product --------------------------------//

        //Index
        Route::get('/products','Admin\ProductController@index')->name('admin.products.index');



        //Read
        Route::get('/products/{id}','Admin\ProductController@show')->name('admin.products.show');

        //Update
        Route::get('/products/{id}/edit','Admin\ProductController@edit')->name('admin.products.edit');
        Route::get('/products/{id}/images','Admin\ProductImageController@edit')->name('admin.product-images.edit');
        Route::post('/products/{id}/images','Admin\ProductImageController@store')->name('admin.product-images.store');
        Route::patch('/products/{id}','Admin\ProductController@update')->name('admin.products.update');


        //Delete
        Route::delete('/products/{id}','Admin\ProductController@destroy')->name('admin.products.destroy');

        //Delete Product Image
        Route::delete('/productImages','Admin\ProductImageController@destroy')->name('admin.product-images.delete');





        //------------------------------ Order ----------------------------------------//

        //Index
        Route::get('/orders','Admin\OrderController@index')->name('admin.orders.index');

        //edit
        Route::get('/orders/show/{id}','Admin\OrderController@show')->name('admin.orders.show');
        Route::get('/orders/{id}','Admin\OrderController@update')->name('admin.orders.update');


        //----------------------------- Shop ------------------------------------//

        //index
        Route::get('/shops','Admin\ShopController@index')->name('admin.shops.index');

        //create
        Route::get('/shops/create','Admin\ShopController@create')->name('admin.shops.create');
        Route::post('/shops','Admin\ShopController@store')->name('admin.shops.store');

        //show
        Route::get('/shops/{id}','Admin\ShopController@show')->name('admin.shops.show');

        Route::get('/shops/{id}/delete','Admin\ShopController@destroy')->name('admin.shops.delete');
        //update
        Route::get('/shops/{id}/edit','Admin\ShopController@edit')->name('admin.shops.edit');
        Route::patch('/shops/{id}/edit','Admin\ShopController@update')->name('admin.shops.update');


        //Shop Reviews
        Route::get('/shops/{id}/reviews','Admin\ShopController@showReviews')->name('admin.shops.reviews.show');




        //---------------------------- Shop Review -----------------------------//

        //Delete
        Route::delete('/shops-reviews/{id}','Admin\ShopReviewController@destroy')->name('admin.shops.reviews.delete');



        //------------------------------ Shop Request --------------------------//
        Route::get('/shop_requests','Admin\ShopRequestController@index')->name('admin.shop_requests.index');
        Route::patch('/shop_requests/{id}','Admin\ShopRequestController@update')->name('admin.shop_requests.update');


        //------------------------------ Delivery Boy --------------------------//
        //index
        Route::get('/delivery-boys','Admin\DeliveryBoyController@index')->name('admin.delivery-boys.index');
        Route::get('/delivery-boys/{id}/reviews','Admin\DeliveryBoyController@showReviews')->name('admin.delivery-boy.reviews.show');
        Route::get('/delivery-boys/{id}','Admin\DeliveryBoyController@show')->name('admin.delivery-boy.show');
        Route::get('/delivery-boy/create','Admin\DeliveryBoyController@create')->name('admin.delivery-boy.create');
        Route::post('/delivery-boys','Admin\DeliveryBoyController@store')->name('admin.delivery-boy.store');
        Route::post('/delivery-boys/{id}','Admin\DeliveryBoyController@update')->name('admin.delivery-boy.update');
        Route::DELETE('/delivery-boys/{id}','Admin\DeliveryBoyController@destroy')->name('admin.delivery-boy.destroy');


        //Delete review
        Route::delete('/delivery-boy-reviews/{id}','Admin\DeliveryBoyReviewController@destroy')->name('admin.delivery-boy.review.delete');




        //Index
        Route::get('/transactions','Admin\TransactionController@index')->name('admin.transactions.index');
        Route::get('/transactions/{id}','Admin\TransactionController@show')->name('admin.transactions.show');
        Route::get('/transactions/{id}/add','Admin\TransactionController@add')->name('admin.transactions.create');
        Route::post('/transactions/{id}','Admin\TransactionController@store_add')->name('admin.transactions.store');
        Route::get('/transaction/{id}/add_delivery_transaction','Admin\TransactionController@add_delivery_transaction')->name('admin.transactions.add_delivery_transaction');
        Route::get('/transactions/get_total/{id}','Admin\TransactionController@get_total')->name('ordertotal');



        //capture payment
        Route::post('/capture_transaction/{id}','Admin\TransactionController@capturePayment')->name('admin.transaction.capture');
        Route::post('/refund_transaction/{id}','Admin\TransactionController@refundPayment')->name('admin.transaction.refund');



        //-----------------  FCM Notifications ------------------------//
        Route::get('/notifications','Admin\NotificationController@create')->name('admin.notifications.create');
        Route::post('/notifications','Admin\NotificationController@send')->name('admin.notifications.send');


    });



    Route::group(['middleware'=>['auth:manager','numberVerification:manager'],'prefix'=>'/manager'],function (){
          Route::get('/status/{id}/orders' , function($id){
            $orders =  Order::with('shop', 'orderPayment')->where('status',$id)->orderBy('updated_at','DESC')->paginate(10);
                return view('manager.orders.orders')->with([
                    'orders'=>$orders
                ]);

        })->name('manager.status');


        Route::get('/getorder' , function(){
           $todayorders = Order::with('user')->where('shop_id', auth()->user()->shop->id)->whereDate('created_at', Carbon::today())->where('is_notification',1)->count();
           Order::with('user')->where('shop_id', auth()->user()->shop->id)->where('created_at', Carbon::today())->where('is_notification',1)->update([
               'is_notification' => 0
               ]);
            $data = ['order_count' => $todayorders];
            return json_encode($data);
        });


        //--------------------------- Auth -------------------------------------//
        Route::get('/logout','Manager\Auth\LoginController@logout')->name('manager.logout');



        //-------------------------- Manager -----------------------------------//
        Route::get('/','Manager\ManagerController@index')->name('manager.dashboard');
        Route::get('/setting','Manager\ManagerController@edit')->name('manager.setting.edit');
        Route::patch('/setting','Manager\ManagerController@update')->name('manager.setting.update');
        Route::patch('/setting/updateLocale/{langCode}','Manager\ManagerController@updateLocale')->name('manager.setting.updateLocale');






        //-------------------------------- Shop --------------------------------//

        //Index
        Route::get('/shops','Manager\ShopController@index')->name('manager.shops.index');

        //Create is not available

        //Read
        Route::get('/shops/{id}','Manager\ShopController@show')->name('manager.shops.show');

        //Update
        Route::get('/shops/{id}/edit','Manager\ShopController@edit')->name('manager.shops.edit');
        Route::patch('/shops/{id}','Manager\ShopController@update')->name('manager.shops.update');

        //Delete
        Route::delete('/shops/{id}','Manager\ShopController@destroy')->name('manager.shops.destroy');

        //Shop Reviews
        Route::get('/shops/{id}/reviews','Manager\ShopController@showReviews')->name('manager.shops.show_reviews');

       //-------------------------------- Code --------------------------------//

        //Index
        Route::get('/codes','Manager\CodeController@index')->name('manager.codes.index');

        //Create is not available
        Route::get('/codes/create','Manager\CodeController@create')->name('manager.codes.create');

        Route::post('/codes/store','Manager\CodeController@store')->name('manager.codes.store');

        //Update
        Route::get('/codes/{id}/edit','Manager\CodeController@edit')->name('manager.codes.edit');
        Route::patch('/codes/{id}','Manager\CodeController@update')->name('manager.codes.update');

        //Delete
        // Route::delete('/codes/{id}','Manager\CodeController@destroy')->name('manager.shops.destroy');


        //-------------------------------- Shop Request --------------------------------//

        Route::post('/shop_requests','Manager\ShopRequestController@store')->name('manager.shop_requests.store');

        //Delete
        Route::delete('/shop_requests/{id}','Manager\ShopRequestController@destroy')->name('manager.shop_requests.destroy');





        //-------------------------------- Product --------------------------------//

        //Index
        Route::get('/products','Manager\ProductController@index')->name('manager.products.index');

        //Create
        Route::get('/products/create','Manager\ProductController@create')->name('manager.products.create');
        Route::post('/products','Manager\ProductController@store')->name('manager.products.store');
        Route::post('/products/{id}/images','Manager\ProductImageController@store')->name('manager.product-images.store');

        //Read

        Route::get('/products/{id}','Manager\ProductController@show')->name('manager.products.show');

        //Update
        Route::get('/products/{id}/edit','Manager\ProductController@edit')->name('manager.products.edit');
        Route::get('/products/{id}/images','Manager\ProductImageController@edit')->name('manager.product-images.edit');
        Route::patch('/products/{id}','Manager\ProductController@update')->name('manager.products.update');

        //Delete
        Route::delete('/products/{id}','Manager\ProductController@destroy')->name('manager.products.destroy');




        //-------------------------------- Product Images --------------------------------//


        //Delete
        Route::delete('/productImages','Manager\ProductImageController@destroy')->name('manager.product-images.delete');


        //--------------------------------- Reviews -----------------------------------//

        //Index
        Route::get('/reviews','Manager\ProductReviewController@index')->name('manager.reviews.index');




        //---------------------------------- Order -----------------------------------//

        //Index
        Route::get('/orders','Manager\OrderController@index')->name('manager.orders.index');

        //Update
        Route::get('/orders/{id}/edit','Manager\OrderController@edit')->name('manager.orders.edit');
        Route::patch('/orders/{id}','Manager\OrderController@update')->name('manager.orders.update');

     //---------------------------------- Scheduled Order  -----------------------------------//

        //Index
        Route::get('/scheduledorders','Manager\ScheduledOrderController@index')->name('manager.schedule-orders.index');


        //----------------------------- Shop Revenues ------------------------------------//
        //index
        Route::get('/shop-revenues','Manager\ShopRevenueController@index')->name('manager.shop-revenues.index');


        //------------------------------ Transactions --------------------------//
        //index
        Route::get('/transaction','Manager\TransactionController@index')->name('manager.transaction.index');




        //---------------------------------------- Coupon -------------------------//
        Route::get('/coupons','Manager\ShopCouponController@index')->name('manager.coupons.index');
        Route::patch('/coupons','Manager\ShopCouponController@update')->name('manager.coupons.update');




        //----------------------------- Delivery Boy ---------------------------------//

        //Index
        Route::get('/delivery_boys','Manager\DeliveryBoyController@index')->name('manager.delivery-boys.index');



        //Show reviews
        Route::get('/delivery-boys/{id}/reviews','Manager\DeliveryBoyController@showReviews')->name('manager.delivery-boy.reviews.show');


        //Assign
        Route::get('/delivery_boys/assign/{order_id}','Manager\DeliveryBoyController@showForAssign')->name('manager.delivery-boys.showForAssign');
        Route::post('/delivery_boys/assign/{order_id}/{delivery_boy_id}','Manager\DeliveryBoyController@assign')->name('manager.delivery-boys.assign');

        Route::get('/delivery-boy/create','Manager\DeliveryBoyController@create')->name('manager.delivery-boy.create');
        Route::post('/delivery-boys','Manager\DeliveryBoyController@store')->name('manager.delivery-boy.store');

        Route::get('/transactions','Manager\TransactionController@index')->name('manager.transactions.index');
        Route::get('/transactions/{id}/show','Manager\TransactionController@show')->name('manager.transactions.show');




    });


    Route::group(['middleware'=>['auth:user'],'prefix'=>'/user'],function () {
        Route::get('/mobile_verification','User\Auth\NumberVerificationController@showNumberVerificationForm')->name('user.auth.numberVerificationForm');
        Route::post('/verify_mobile_number','User\Auth\NumberVerificationController@verifyMobileNumber')->name('user.auth.verify_mobile_number');
        Route::post('/mobile_verified','User\Auth\NumberVerificationController@mobileVerified')->name('user.auth.mobile_verified');

        //--------------------------- Blocked -------------------------------------//
        Route::get('/block','User\Auth\BlockController@show')->name('user.block.show');

        //--------------------------- Auth -------------------------------------//
        Route::get('/logout','User\Auth\LoginController@logout')->name('user.logout');

    });


    Route::group(['middleware'=>['auth:user','numberVerification:user','blocked:user'],'prefix'=>'/user'],function (){


        //-------------------------- User -----------------------------------//
        Route::get('/','User\UserController@index')->name('user.dashboard');
        Route::get('/setting','User\UserController@edit')->name('user.setting.edit');
        Route::patch('/setting','User\UserController@update')->name('user.setting.update');
        Route::patch('/setting/updateLocale/{langCode}','User\UserController@updateLocale')->name('user.setting.updateLocale');


        //-------------------------------- Product --------------------------------//

        //Index
        Route::get('/products','User\ProductController@index')->name('user.products.index');


        //Show
        Route::get('/products/{id}','User\ProductController@show')->name('user.products.show');

        //Show Reviews
        Route::get('/products/{id}/reviews', 'User\ProductController@showReviews')->name('user.product.reviews.show');


        //----------------- Category -------------------------------//
        Route::get('/categories/{id}', 'User\CategoryController@show')->name('user.categories.show');

        //----------------- Sub Category -------------------------------//
        Route::get('/sub_categories/{id}', 'User\SubCategoryController@show')->name('user.sub-categories.show');




        //--------------- Favourite ------------------------//
        Route::get('/favorites', 'User\FavoriteController@index')->name('user.favorites.index');
        Route::post('/favorites', 'User\FavoriteController@store')->name('user.favorites.store');



        //----------------- Cart -------------------------------//
        Route::get('/carts', 'User\CartController@index')->name('user.carts.index');
        Route::post('/carts', 'User\CartController@store')->name('user.carts.store');
        Route::delete('/carts', 'User\CartController@destroy')->name('user.carts.delete');
        Route::patch('/carts/{id}', 'User\CartController@update')->name('user.carts.update');


        //----------------------------------- Order ----------------------------------------//
        Route::get('/orders', 'User\OrderController@index')->name('user.orders.index');
        Route::patch('/orders/{id}', 'User\OrderController@update')->name('user.orders.update');
        Route::get('/orders/{id}', 'User\OrderController@show')->name('user.orders.show');
        Route::post('/orders', 'User\OrderController@store')->name('user.orders.store');
        Route::get('/orders/{id}/reviews', 'User\OrderController@showReviews')->name('user.order.review.show');



        //---------------- Shop --------------------------//
        Route::get('/shops/{id}', 'User\ShopController@show')->name('user.shops.show');
        Route::get('/shops', 'User\ShopController@index')->name('user.shops.index');
        Route::get('/shops/{id}/reviews', 'User\ShopController@showReviews')->name('user.shop.reviews.show');



        //--------------------- Order Payment -----------------------------------------------//
        Route::get('/orders/{id}/payment', 'User\OrderPaymentController@index')->name('user.orders_payment.index');

        //Paystack Gateway
        Route::post('orders/payment/paystack/pay', 'User\OrderPaymentController@paystackPayment')->name('user.orders_payment.paystack.pay');
        Route::get('orders/payment/paystack/callback', 'User\OrderPaymentController@handleGatewayCallback');

        //Stripe Gateway
        Route::get('orders/payment/stripe/pay', 'User\OrderPaymentController@stripePayment')->name('user.orders_payment.stripe.pay');
        Route::post('orders/payment/stripe/callback', 'User\OrderPaymentController@handleStripePaymentCallback')->name('user.orders_payment.stripe.callback');


        //----------------- Order Checkout -------------------------------//
        Route::get('/checkout', 'User\CheckoutController@index')->name('user.checkout.index');



        //-------------------- Address ------------------------//
        Route::get('/addresses', 'User\UserAddressController@index')->name('user.addresses.index');
        Route::get('/addresses/create', 'User\UserAddressController@create')->name('user.addresses.create');
        Route::post('/addresses', 'User\UserAddressController@store')->name('user.addresses.store');
        Route::delete('/addresses/{id}', 'User\UserAddressController@destroy')->name('user.addresses.delete');


        //-------------------- Shop Review ----------------------//
        Route::post('/shop-reviews', 'User\ShopReviewController@store')->name('user.shop_reviews.store');

        //-------------------- Product Review ----------------------//
        Route::post('/product-reviews', 'User\ProductReviewController@store')->name('user.product_reviews.store');


        //-------------------- Delivery Boy Review ----------------------//
        Route::post('/delivery-boy-reviews', 'User\DeliveryBoyReviewController@store')->name('user.delivery_boy_reviews.store');





    });


    Route::prefix('user')->group(function (){

        //Password  Reset
        Route::post('/password/reset','User\Auth\ResetPasswordController@reset')->name('user.password.reset');
        Route::get('/password/reset/{token}','User\Auth\ResetPasswordController@showResetForm')->name('user.password.resetForm');


        //Print Receipt
       // Route::get('/orders/{id}/receipt','User\OrderReceiptController@show')->name('user.orders.receipt');



    });

    Route::prefix('delivery-boy')->group(function (){

        //Password  Reset
        Route::post('/password/reset','DeliveryBoy\Auth\ResetPasswordController@reset')->name('delivery-boy.password.reset');
        Route::get('/password/reset/{token}','DeliveryBoy\Auth\ResetPasswordController@showResetForm')->name('delivery-boy.password.resetForm');


        //Print Receipt
        Route::get('/orders/{id}/receipt','DeliveryBoy\OrderReceiptController@show')->name('delivery-boy.orders.receipt');

    });



    Route::group(['middleware' => 'auth', 'prefix' => '/'], function () {

    });

    Route::get('/', function () {
        return view('home');
    })->name('home');
  Route::get('admin/{id}/verify', function ($id) {
        $del = DeliveryBoy::findOrFail($id);
        $del->is_verified = 1;
        $del->is_offline = 0;
        $del->save();
        return redirect()->back()->with(['success' => 'Updated']);
    })->name('admin.verify');



//Auth::routes();


});

   Route::get('admin/getorder' , function(){
           $todayorders = Order::whereDate('created_at', Carbon::today())->where('is_notification',1)->count();

            $shopRequests = ShopRequest::count();
            $deliveryCount = DeliveryBoy::where('is_verified',0)->count();

            $data = ['order_count' => $todayorders,
                    'shop_count' => $shopRequests,
                    'delivery_count' =>$deliveryCount];
            return json_encode($data);

   });
//Applications
Route::get('/downloads/apk',function (){
    return redirect(TextUtil::$DOCS_APK);
})->name('downloads.apk');

Route::get('/downloads/apk/emall',function (){
    return redirect(TextUtil::$EMALL_APK_DOWNLOAD);
})->name('downloads.apk.emall');

Route::get('/downloads/apk/manager',function (){
    return redirect(TextUtil::$MANAGER_APK_DOWNLOAD);
})->name('downloads.apk.manager');


Route::get('/downloads/apk/delivery-boy',function (){
    return redirect(TextUtil::$DELIVERY_BOY_APK_DOWNLOAD);
})->name('downloads.apk.delivery-boy');

