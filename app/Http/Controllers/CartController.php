<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MongoDB\Driver\Session;
use Termwind\Components\Dd;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $find = Cart::where('session_id', session()->getId())->get();
        $sonuc = false;

        Log::info(count($find));
        if (count($find) < 1) {
            $cart = new Cart();
            $cart->user_id = auth()->check() ? auth()->id() : 0;
            $cart->session_id = session()->getId();
            $cart->product_id = $request->pid;
            $cart->variant_id = $request->pvid;
            $cart->quantity = $request->quantity;
            $cart->save();
            $sonuc = true;
        } else {
            foreach ($find as $rs) {
                if ($rs->product_id == $request->pid) {
                    $quantity = (int)$rs->quantity + (int)$request->quantity;


                    $q = Cart::find($rs->id);
                    $q->quantity = $quantity;
                    $q->save();
                    $sonuc = true;
                } else {
                    $sonuc = false;
                }

            }

            if ($sonuc == false) {
                $cart = new Cart();
                $cart->user_id = auth()->check() ? auth()->id() : 0;
                $cart->session_id = session()->getId();
                $cart->product_id = $request->pid;
                $cart->variant_id = $request->pvid;
                $cart->quantity = $request->quantity;
                $cart->save();
                $sonuc = true;
            }

        }


        if ($sonuc) {

            $success = true;
            $message = "Sepete Eklendi";
        } else {
            $success = false;
            $message = "Üretici Bulunamadı";
        }

        //  return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if (auth()->check()) {
            $data = DB::select('SELECT
	products.price as price, 
	products.image as image, 
	products.discount_price as discount_price , 
	products.name as name, 
	products.isVariable as isvariable, 
	products.sku as sku ,
	carts.quantity, 
	carts.product_id as pid, 
	carts.variant_id as pvid, 
	product_variants.name as pvname, 
	product_variants.sku as pvsku, 
	product_variants.price as pvprice, 
	product_variants.discount_price as pvdprice,
	product_variants.image as pvimage
FROM
	carts
	INNER JOIN
	products
	ON 
		carts.product_id = products.id
	 LEFT JOIN
	product_variants
	ON 
		carts.variant_id = product_variants.id
WHERE
	carts.user_id = "' . $id . '"');
        } else {
            $data = DB::select('SELECT
		products.price as price, 
	products.image as image, 
	products.discount_price as discount_price , 
	products.name as name, 
	products.isVariable as isvariable, 
	products.sku as sku ,
	carts.quantity, 
	carts.product_id as pid, 
	carts.variant_id as pvid, 
	product_variants.name as pvname, 
	product_variants.sku as pvsku, 
	product_variants.price as pvprice, 
	product_variants.discount_price as pvdprice,
	product_variants.image as pvimage
FROM
	carts
	INNER JOIN
	products
	ON 
		carts.product_id = products.id
	 LEFT JOIN
	product_variants
	ON 
		carts.variant_id = product_variants.id
WHERE
	carts.session_id = "' . $id . '"');


        }




        return view('cart', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function checkout()
    {
        if (auth()->check()) {
            $id = Auth::id();
            $data = DB::select('SELECT
		products.price as price, 
	products.image as image, 
	products.discount_price as discount_price , 
	products.name as name, 
	products.isVariable as isvariable, 
	products.sku as sku ,
	carts.quantity, 
	carts.product_id as pid, 
	carts.variant_id as pvid, 
	product_variants.name as pvname, 
	product_variants.sku as pvsku, 
	product_variants.price as pvprice, 
	product_variants.discount_price as pvdprice,
	product_variants.image as pvimage
FROM
	carts
	INNER JOIN
	products
	ON 
		carts.product_id = products.id
	 LEFT JOIN
	product_variants
	ON 
		carts.variant_id = product_variants.id
WHERE
	carts.user_id = "' . $id . '"');




            $adres=Address::where('user_id',Auth::id())->get();
            $country=Country::all();
            $zone=Zone::where('country_id','=','81')->get();
            session()->put('cart', $data);





            return view('checkout',['data'=>$data,'adres'=>$adres,'country'=>$country,'zone'=>$zone]);


        }

        else {

            return view('login');

        }

    }
}
