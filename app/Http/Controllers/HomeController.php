<?php

namespace App\Http\Controllers;

use App\Mail\sendUserMail;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductOptions;
use App\Models\ProductVariants;
use App\Models\Settings;
use App\Models\Slider;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public static function getsettings()
    {
        return Settings::first();
    }
    public static function CatList()
    {
        return $catList = Category::where('parent_id', '=', 0)->with('children')->get();
    }

    public function categoryproducts($id)
    {
        $data = Product::where('categoryID', $id)->get();


        $cat = Category::find($id);
        return view('category', ['data' => $data, 'cat' => $cat]);
    }

    public static function lastmodal()
    {
        return $lastmodal = Product::limit(4)->orderBy('id')->get();
    }


    public static function getCart()
    {
        if (auth()->check()) {
            return $cart = Cart::where('user_id', auth()->id())->get();
        } else {
            return $cart = Cart::where('session_id', session()->getId())->get();
        }


    }

    public function productdetail($slug,$id)
    {
        $isvariable = DB::table('products')->where('id', $id)->value('isVariable');
        $data = Product::find($id);
        $last = Product::limit(6)->orderByDesc('id')->get();
        $imagelist = ProductGallery::where('pid', $id)->get();
        if ($isvariable)
        {
            $options=ProductOptions::where("productID",$id)->with('optionsValues')->get();

            $variant=DB::table('product_variants')->where('productID', $id)->select('name','price','discount_price')->first();
            $variants=DB::table('product_variants')->where('productID', $id)->get();



            return view('productdetail', ['data' => $data,'options'=>$options ,'imagelist' => $imagelist, 'last' => $last,'isvariable'=>$isvariable,'variant'=>$variant,'variants'=>$variants]);

        }
        else
        {


            return view('productdetail', ['data' => $data, 'imagelist' => $imagelist, 'last' => $last,'isvariable'=>$isvariable]);
        }







        return view('productdetail', ['data' => $data, 'imagelist' => $imagelist, 'last' => $last]);
    }

    public function login()
    {
        return view('login');
    }
    public function checkLogin(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);


        $sessionid=session()->getId();
        $credentials = $request->only('email', 'password');


        if (Auth::attempt($credentials)) {
            // return redirect()->route('index')->with('success', 'Giriş Yaptınız');


            $cart=Cart::where('session_id',$sessionid)->update(array('user_id' => Auth::id()));



            return Redirect::back()->with('success', 'Giriş Yaptınız');
        }

        return redirect()->route('Userlogin')->with('error', 'Kullanıcı Adı veya Şifre Yanlış');

    }

    public function register(Request $request)
    {

        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);

        if ($user->save())
        {
            $maildata = [
                'title' => 'Üyelik Kaydınız Oluşturulmuştur.',
                'url' => env('app_url').'/login'
            ];

            Mail::to($request->email)->send(new sendUserMail($maildata));

            return redirect()->route('index');


        }

    }
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }

    public function profile()
    {
        $country = Country::all();
        $zone = Zone::where('country_id', '=', '81')->get();

        $adres = Address::get();

        $order = Order::where('user_id', Auth::id())->get();


        return view('account', ['country' => $country, 'zone' => $zone, 'adres' => $adres, 'order' => $order]);
    }

    public function profileupdate(Request $request)
    {

        $id = Auth::user()->id;
        $user = User::find($id);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->phone = $request->phone;
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
    }

    public function createadres(Request $request)
    {
        $adress = new Address();
        $adress->user_id = Auth::id();
        $adress->name = $request->name;
        $adress->adress = $request->address;
        $adress->city = $request->city;
        $adress->postcode = $request->postcode;
        $adress->country_id = $request->country;
        $adress->zone_id = $request->zone;
        $adress->save();


        return redirect()->route('profile');

    }

    public function editadress(Request $request)
    {
        $adres = Address::where('id', '=', $request->id)->get();
        $success = true;
        return response()->json([
            'success' => $success,
            'name' => $adres[0]['name'],
            'adress' => $adres[0]['adress'],
            'city' => $adres[0]['city'],
            'postcode' => $adres[0]['postcode'],
            'country_id' => $adres[0]['country_id'],
            'zone_id' => $adres[0]['zone_id'],
        ]);
    }

    public function destroyadress(Request $request, $id)
    {

        $del = Address::find($id);
        $del->delete();

        if ($del) {


            return redirect()->route('profile');


        }

    }

    public function orderdetail(Request $request)
    {

        $order=OrderProduct::where('order_id',$request->id)->get();
        $success = true;
        return response()->json([
            'success' => $success,
            'data'=>$order
        ]);

    }

    public function zaunplanner(Request $request)
    {
        $data = Product::where('customize','=','1')->get();
        $baba=Product::where('categoryID','=','12')->get();
        $kapi=ProductVariants::where('categoryID','=','11')->get();

        return view('zaunplanner',['data'=>$data,'baba'=>$baba,'kapi'=>$kapi]);
    }

    public function variantsfetch(Request $request)
    {

        $data=ProductVariants::where('productID',$request->id)->get();
        $success = true;
        return response()->json([
            'success' => $success,
            'data'=>$data
        ]);

    }


    public function plannertocart(Request $request)
    {




       $cart = new Cart();
        $cart->user_id = auth()->check() ? auth()->id() : 0;
        $cart->session_id = session()->getId();
        $cart->product_id = $request->citid;
        $cart->variant_id = $request->citvid;
        $cart->quantity = $request->citsayisi;
        $cart->save();

        for ($i=0;$i<$request->kapisayisi;$i++)
        {
            $kvid=explode(",",$request->kapi);


            $cart = new Cart();
            $cart->user_id = auth()->check() ? auth()->id() : 0;
            $cart->session_id = session()->getId();
            $cart->product_id = $request->kapiid;
            $cart->variant_id =  $kvid[$i];
            $cart->quantity = 1;
            $cart->save();
        }



        $cart = new Cart();
        $cart->user_id = auth()->check() ? auth()->id() : 0;
        $cart->session_id = session()->getId();
        $cart->product_id = $request->baba;
        $cart->quantity = $request->babaadet;
        $cart->save();



        return redirect()->route('cart.show', [auth()->check() ? auth()->id() : session()->getId()]);




    }

    public function pageview($slug)
    {

        $data=Page::where('slug',$slug)->get();


        if (count($data)<1)
            abort('404');


        return view('page',['data'=>$data]);




    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $slide = Slider::get();
        $last = Product::limit(6)->orderByDesc('id')->get();

        return view('index', ['slide' => $slide, 'last' => $last]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
