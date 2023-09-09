<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Manager;
use App\Models\Shop;
use App\Models\ShopRevenue;
use App\Models\ShopReview;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::with('manager')->paginate(10);

        foreach ($shops as $shop) {
            $productsCount = 0;
            $revenue = 0;
            $shopRevenues = ShopRevenue::where('shop_id', '=', $shop->id)->get();
            foreach ($shopRevenues as $shopRevenue) {
                $productsCount += $shopRevenue->products_count;
                $revenue += $shopRevenue->revenue;
            }
            $shop['revenue'] = $revenue;
            $shop['products_count'] = $productsCount;
        }

        return view('admin.shops.shops')->with([
            'shops' => $shops
        ]);
    }


    public function create()
    {
        $categories = Category::get();

        return view('admin.shops.create-shop')->with([
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required|unique:shops',
                'mobile' => 'required|unique:shops',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'image' => 'required',
                'delivery_range'=>'required',
            ]);

        $shop = new Shop();

        $path = $request->file('image')->store('shop_images', 'public');
        $shop->image_url = $path;
        $shop->name = $request->get('name');
        $shop->email = $request->get('email');
        $shop->mobile = $request->get('mobile');
        $shop->category_id = $request->get('category');
        $shop->address = $request->get('address');
        $shop->latitude = $request->get('latitude');
        $shop->longitude = $request->get('longitude');
        $shop->default_tax = $request->get('default_tax') ?? 0;
        $shop->delivery_range = $request->get('delivery_range');

        $number = $this->generateBarcodeNumber();

        $shop->barcode = $number;
        if ($request->get('available_for_delivery')) {
            $shop->available_for_delivery = true;
        } else {
            $shop->available_for_delivery = false;
        }

        if ($request->get('open')) {
            $shop->open = true;
        } else {
            $shop->open = false;
        }

        if ($shop->save()) {
            return redirect(route('manager.shops.index'))->with([
                'message' => 'Shop has been created'
            ]);
        } else {
            return redirect(route('manager.shops.index'))->with([
                'error' => 'Something wrong'
            ]);
        }

    }

    public function show($id)
    {
        $shop = Shop::with('manager')->find($id);
        $available_managers = Manager::doesnthave('shop')->get();
        if ($shop) {
            $shopRevenues = ShopRevenue::where('shop_id', '=', $shop->id)->get();
            $productsCount = 0;
            $revenue = 0;
            foreach ($shopRevenues as $shopRevenue) {
                $productsCount += $shopRevenue->products_count;
                $revenue += $shopRevenue->revenue;
            }


            $xAxis = [];
            $productsCountData = [];
            $ordersCountData = [];
            $revenueCountData = [];
            for ($i = 6; $i >= 0; $i--) {
                $singleProductsCountData = 0;
                $singleOrderCountData = 0;
                $singleRevenueCountData = 0;

                $carbonDate = Carbon::today()->subDays($i)->toDateString();
                array_push($xAxis, Carbon::today()->subDays($i)->shortDayName);
                $dateShopRevenue = ShopRevenue::whereDate('created_at', '=', $carbonDate)->where('shop_id', '=', $shop->id)->get();
                foreach ($dateShopRevenue as $singleRevenue) {
                    $singleOrderCountData++;
                    $singleProductsCountData += $singleRevenue->products_count;
                    $singleRevenueCountData += $singleRevenue->revenue;
                }
                array_push($productsCountData, $singleProductsCountData);
                array_push($ordersCountData, $singleOrderCountData);
                array_push($revenueCountData, $singleRevenueCountData);
            }

            $totalWeeklyProducts = 0;
            $totalWeeklyOrders = 0;
            $totalWeeklyRevenue = 0;

            for ($i = 0; $i < 7; $i++) {
                $totalWeeklyProducts += $productsCountData[$i];
                $totalWeeklyOrders += $ordersCountData[$i];
                $totalWeeklyRevenue += $revenueCountData[$i];
            }

            $chart = new LarapexChart();

            $chart->setType('line')
                ->setXAxis($xAxis)
                ->setDataset([
                    [
                        'name' => 'Products',
                        'data' => $productsCountData
                    ],
                    [
                        'name' => 'Orders',
                        'data' => $ordersCountData
                    ],
                    [
                        'name' => 'Revenues',
                        'data' => $revenueCountData
                    ],

                ]);


            return view('admin.shops.show-shop')->with([
                'products_count' => $productsCount,
                'revenue' => $revenue,
                'orders_count' => $shopRevenues->count(),
                'chart' => $chart,
                'total_weekly_products' => $totalWeeklyProducts,
                'total_weekly_orders' => $totalWeeklyOrders,
                'total_weekly_revenue' => $totalWeeklyRevenue,
                'shop' => $shop,
                'available_managers' => $available_managers
            ]);
        } else {
            return view('manager.error-page')->with([
                'code' => 502,
                'error' => 'This shop is not available',
                'message' => 'Please go to your shop and join',
                'redirect_text' => 'Go to Shop',
                'redirect_url' => route('admin.shops.index')
            ]);
        }

    }


    public function edit($id)
    {
        $shop = Shop::with('manager')->find($id);
        $available_managers = Manager::doesnthave('shop')->get();
        return view('admin.shops.edit-shop')->with([
            'shop' => $shop,
            'available_managers' => $available_managers,

        ]);
    }


    public function update(Request $request, $id)
    {

        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required|unique:shops,email,' . $id,
                'mobile' => 'required|unique:shops,mobile,' . $id,

                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'delivery_range'=>'required',


            ]);


        $shop = Shop::find($id);

        if ($request->hasFile('image')) {
            Shop::updateShopImage($request, $id);
        }

        $shop->name = $request->get('name');
        $shop->email = $request->get('email');
        $shop->mobile = $request->get('mobile');

        $shop->address = $request->get('address');
        $shop->latitude = $request->get('latitude');
        $shop->longitude = $request->get('longitude');
        $shop->default_tax = $request->get('default_tax');

        $shop->delivery_range = $request->get('delivery_range');

        if ($request->get('available_for_delivery')) {
            $shop->available_for_delivery = true;
        } else {
            $shop->available_for_delivery = false;
        }

        if ($request->get('open')) {
            $shop->open = true;
        } else {
            $shop->open = false;
        }

        if ($shop->save()) {
            return redirect()->back()->with([
                'message' => 'Shop has been updated'
            ]);
        } else {
            return redirect()->back()->with([
                'error' => 'Something wrong'
            ]);
        }

    }

   public function destroy($id){
         $shop = Shop::findOrFail($id);
        DB::beginTransaction();
        try{

            $deliveries = DB::table('delivery_boys')->where('shop_id',$id);
            if(count($deliveries->get()) > 0){
            DB::table('assign_to_deliveries')->whereIn('delivery_boy_id' , [$deliveries->pluck('id')])->delete();}
            DB::table('orders')->where('shop_id',$id)->delete();
            DB::table('delivery_boys')->where('shop_id',$id)->delete();
            DB::table('managers')->where('id',$shop->manager_id)->delete();


            $shop->delete();
            DB::commit();
            return redirect(route('admin.shops.index'))->with('message', 'Shop deleted');
        }catch(Exception $e){
            DB::rollBack();
            return redirect(route('admin.shops.index'))->with('error', 'Shop not deleted');

        }

    }

    public function showReviews($id)
    {
        $shop = Shop::find($id);

        if ($shop) {
            $shopReviews = ShopReview::with('user')->where('shop_id', '=', $shop->id)->get();
            return view('admin.shops.shop-reviews')->with([
                'shopReviews' => $shopReviews
            ]);

        } else {
            return view('admin.error-page')->with([
                'code' => 502,
                'error' => 'This shop is not available',
                'message' => 'Please go to your shop',
                'redirect_text' => 'Go to shop',
                'redirect_url' => route('admin.shops.index')
            ]);
        }


    }

    function generateBarcodeNumber() {
        $number = mt_rand(100000, 999999); // better than rand()

        // call the same function if the barcode exists already
        if (Shop::where('barcode',$number)->exists()) {
            return generateBarcodeNumber();
        }

        // otherwise, it's valid and can be used
        return $number;
    }
}
