<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class OrderReceiptController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function show($id)
    {

        $order = Order::with( 'deliveryBoy','user','address','orderPayment' )->where('id','=',$id)->get()->toArray()[0];


        return view('user.order-receipt')->with([
            'order'=>$order
        ]);
    }


}
/*
public function index()
{

}

public function create()
{

}


public function store(Request $request)
{

}

public function show($id)
{
}


public function edit($id)
{

}


public function update(Request $request)
{

}


public function destroy($id){

}
*/
