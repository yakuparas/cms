<?php

namespace App\Http\Controllers\Backend;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BackendController extends Controller
{

    public function login()
    {
        return view('Backend.login');
    }
    public function checklogin(Request $request)
    {

        $validate=$request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);



        $credentials = $request->only('email', 'password');


        if (Auth::attempt($credentials)) {

            return redirect()->route('Backend.dashboard');
        }

        return redirect()->route('login');
    }
    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('/admin');
    }


    public function index()
    {
        $orderSum=Order::sum('amount');

        $orderCount=Order::count();
        $productCount=Product::count();
        $userCount=User::where('type',UserType::Custumer)->count();

        $data=[
            'orderSum'=>$orderSum,
            'orderCount'=>$orderCount,
            'productCount'=>$productCount,
            'userCount'=>$userCount,
        ];


        return view('Backend.dashboard',$data);
    }



}
