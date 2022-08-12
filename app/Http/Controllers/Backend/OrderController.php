<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    public function index()
    {
        $data=DB::select("SELECT
	addresses.adress, 
	addresses.city, 
	addresses.postcode as postcode, 
	addresses.country_id as country, 
	addresses.zone_id as zone, 
	users.name AS uname, 
	users.email, 
	orders.tracking, 
	orders.comment, 
	orders.amount, 
	orders.payment_id, 
	orders.status, 
	orders.payment_status, 
	orders.payer_email, 
	orders.id
FROM
	users
	INNER JOIN
	orders
	ON 
		users.id = orders.user_id
	INNER JOIN
	addresses
	ON 
		addresses.user_id = users.id");

        return view('backend.order.index',['data'=>$data]);
    }

    public function show($id)
    {
        $data=OrderProduct::where('order_id',$id)->get();
        $order=DB::select("SELECT
	addresses.adress,
	addresses.city,
	users.name AS uname,
	users.phone,
	users.email,
	orders.tracking,
	orders.comment,
	orders.amount,
	orders.payment_id,
	orders.status,
	orders.payment_status,
	orders.id,
	addresses.country_id AS country,
	addresses.zone_id AS zone,
	addresses.postcode AS postcode,
    orders.created_at
FROM
	orders
	INNER JOIN
	users
	ON
		orders.user_id = users.id
	INNER JOIN
	addresses
	ON
		orders.adress_id = addresses.id
WHERE
	orders.id = $id");


        return view('backend.order.detail',['data'=>$data,'order'=>$order]);



    }


    public function historyadd(Request $request)
    {
        $order=Order::find($request->oid);
        $order->status=$request->status;
        $order->history=$request->history;
        $order->save();

        return Redirect::back()->with('success', 'İşlem Başarılı');



    }
}
