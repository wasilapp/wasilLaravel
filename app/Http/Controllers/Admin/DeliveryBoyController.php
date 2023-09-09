<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\DeliveryBoy;
use App\Models\DeliveryBoyRevenue;
use App\Models\DeliveryBoyReview;
use App\Models\Manager;
use App\Models\Shop;
use App\Models\ShopRevenue;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DeliveryBoyController extends Controller
{
    public function index()
    {
        $deliveryBoys = DeliveryBoy::paginate(10);

        foreach ($deliveryBoys as $deliveryBoy) {
            $ordersCount=0;
            $revenue=0;
            $deliveryBoyRevenues = DeliveryBoyRevenue::where('delivery_boy_id','=',$deliveryBoy->id)->get();
            foreach ($deliveryBoyRevenues as $deliveryBoyRevenue) {
                $ordersCount += 1;
                $revenue += $deliveryBoyRevenue->revenue;
            }
            $deliveryBoy['revenue']=$revenue;
            $deliveryBoy['orders_count']=$ordersCount;
        }

        return view('admin.delivery-boy.delivery-boys')->with([
            'delivery_boys'=>$deliveryBoys
        ]);
    }


    public function create()
    {
        $categories = Category::where('active',1)->get();

        return view('admin.delivery-boy.create-delivery-boys',compact('categories'));
    }


    public function store(Request $request)
    {

    $this->validate(
            $request,
            [
                'name' => 'required',//
                'mobile' => 'required',//
                'password' => 'required',
                'category_id' => 'required',
                'driving_license' => 'required',
                'profile_pic' => 'required',
                'car_number' => 'required'
            ]
        );

           if(DeliveryBoy::where('mobile','LIKE','%'.$request->mobile)->first()){
           return response(['message'=>"Number is  registered"], 200);

       }

        $str =$request->get('mobile');
        $deliveryBoy = new DeliveryBoy();
        $deliveryBoy->name = $request->get('name');
        $deliveryBoy->car_number = $request->get('car_number');
        $deliveryBoy->mobile = "+962".$str;
        $deliveryBoy->password = Hash::make($request->get('password'));
        $deliveryBoy->category_id = $request->get('category_id');
        $path = $request->file('driving_license')->store('driving_license_avatars', 'public');
        $avatar_url= $request->file('profile_pic')->store('driver_avatars', 'public');
        $deliveryBoy->driving_license = $path;
        $deliveryBoy->is_verified = 1;
        if($request->email){
            $this->validate($request,[
                'email' => 'required|email|unique:delivery_boys',
            ]);
            $deliveryBoy->email = $request->get('email');
        }
        if($request->shop_id){
             $deliveryBoy->shop_id = $request->get('shop_id');
        }

        $deliveryBoy->avatar_url = $avatar_url;
        $deliveryBoy->mobile_verified = 1;
        if($deliveryBoy->save()){
            return redirect()->route('admin.delivery-boys.index')->with('success','Delivery added successfully');

        }
        return redirect()->back()->with('faild','Something wrong');

    }

    public function show($id)
    {

        $deliveryBoy = DeliveryBoy::where('id',$id)->first();
           return view('admin.delivery-boy.manage-delivery-boys')->with([
            'delivery_boy'=>$deliveryBoy
        ]);
    }


    public function update(Request $request, $id){
        // dd($request->all());
        $this->validate(
            $request,
            [
                'name' => 'required',//
                'mobile' => 'required',//
                'password' => 'required',
                'category_id' => 'required',
                'driving_license' => 'required',
                'profile_pic' => 'required',
                'car_number' => 'required',
                // 'shop_id'=>'required'
            ]
        );

           if(DeliveryBoy::where('mobile','LIKE','%'.$request->mobile)->first()){
           return response(['message'=>"Number is  registered"], 200);

       }

        $str =$request->get('mobile');
        $deliveryBoy = new DeliveryBoy();
        $deliveryBoy->name = $request->get('name');
        // $deliveryBoy->shop_id = $request->get('shop_id');
        $deliveryBoy->car_number = $request->get('car_number');
        $deliveryBoy->mobile = "+962".$str;
        $deliveryBoy->password = Hash::make($request->get('password'));
        $deliveryBoy->category_id = $request->get('category_id');
        $path = $request->file('driving_license')->store('driving_license_avatars', 'public');
        $avatar_url= $request->file('profile_pic')->store('driver_avatars', 'public');
        $deliveryBoy->driving_license = $path;
        $deliveryBoy->is_verified = 1;
        if($request->email){
            $this->validate($request,[
                'email' => 'required|email|unique:delivery_boys',
            ]);
            $deliveryBoy->email = $request->get('email');
        }

        if($request->shop_id){
            $deliveryBoy->shop_id = $request->get('shop_id');
        }
        $deliveryBoy->avatar_url = $avatar_url;
        $deliveryBoy->mobile_verified = 1;
        if($deliveryBoy->save()){
            return redirect()->route('admin.delivery-boys.index')->with('success','Delivery added successfully');

        }
        return redirect()->back()->with('faild','Something wrong');

    }


    public function destroy($id)
    {
        try {
           $deliveryBoy = DeliveryBoy::find($id);

            if (!$deliveryBoy) {
                return response()->json(['message' => 'DeliveryBoy not found'], 404);
            }

            $deliveryBoy->orders()->delete();
            $deliveryBoy->transactions()->delete();
            if ($deliveryBoy->avatar_url) {
                Storage::disk('public')->delete($deliveryBoy->avatar_url);
            }

            if ($deliveryBoy->driving_license_url) {
                Storage::disk('public')->delete($deliveryBoy->driving_license_url);
            }
            $deliveryBoy->delete();

            return redirect(route('admin.delivery-boys.index'))->with([
                    'message' => 'DeliveryBoy Deleted'
                ]);
        } catch (\Exception $e) {
            // return $e;
            return redirect()->back()->with([
                 'error' => $e->getMessage()
            ]);
        }

    }


    public function showReviews($id){

         $deliveryBoyReviews =  DeliveryBoyReview::with('user')->where('delivery_boy_id','=',$id)->get();

         return view('admin.delivery-boy.show-reviews-delivery-boy')->with([
             'deliveryBoyReviews'=>$deliveryBoyReviews
         ]);

    }




}
