<?php

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaypalPaymentController;
use Illuminate\Support\Facades\Route;

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


Route::get('/',[HomeController::class,'index'])->name('index');
Route::get('/category/{slug}/{id}',[HomeController::class,'categoryproducts'])->name('categoryproducts');
Route::get('/details/{name}/{id}',[HomeController::class,'productdetail'])->name('product-detail');
Route::get('/login',[HomeController::class,'login'])->name('Userlogin');
Route::post('/checkLogin',[HomeController::class,'checkLogin'])->name('userCheckLogin');
Route::post('/register',[HomeController::class,'register'])->name('userRegister');
//Route::get('/category/{id}/{slug}',[HomeController::class,'categoryproducts'])->name('categoryproducts');
Route::get('payment', [PaypalPaymentController::class,'index'])->name("paypal.index");
Route::post('charge', [PaypalPaymentController::class,'charge'])->name("paypal.charge");
Route::get('success', [PaypalPaymentController::class,'success'])->name("paypal.success");
Route::get('error', [PaypalPaymentController::class,'error'])->name("paypal.error");

Route::get('page/{slug}',[HomeController::class,'pageview'])->name('Page.view');


Route::get('zaunplanner', [HomeController::class,'zaunplanner'])->name("zaunplanner");
Route::post('variantsfetch', [HomeController::class,'variantsfetch'])->name("Product.variantsfetch");
Route::post('plannertocart',[HomeController::class,'plannertocart'])->name('plannertocart');

Route::get('/zaunplanner/step-1/{id}', [HomeController::class,'step1'])->name("step1");
Route::post('/zaunplanner/step-2', [HomeController::class,'step2'])->name("step2");
Route::get('/zaunplanner/step-3', [HomeController::class,'step3'])->name("step3");
Route::post('/zaunplanner/charge', [PaypalPaymentController::class,'plannercharge'])->name("planner.charge");

Route::group(['prefix' => 'user',  'middleware' => 'auth'], function()
{
    Route::get('/logout',[HomeController::class,'logout'])->name('logout');
    Route::get('/profile',[HomeController::class,'profile'])->name('profile');
    Route::post('/profile-update',[HomeController::class,'profileupdate'])->name('profile-update');
    Route::post('/createadres',[HomeController::class,'createadres'])->name('createadres');
    Route::post('/editadress',[HomeController::class,'editadress'])->name('editadress');
    Route::get('/destroyadress/{id}',[HomeController::class,'destroyadress'])->name('destroyadress');
    Route::post('/orderdetail',[HomeController::class,'orderdetail'])->name('orderdetail');

});

Route::prefix('cart')->group(function (){

    Route::get('/',[CartController::class,'index'])->name('cart');
    Route::get('create',[CartController::class,'create'])->name('cart.add');
    Route::post('store',[CartController::class,'store'])->name('cart.store');
    Route::post('delete/{id}',[CartController::class,'destroy'])->name('cart.delete');
    Route::post('update/{id}',[CartController::class,'update'])->name('cart.update');
    Route::get('edit/{id}',[CartController::class,'edit'])->name('cart.edit');
    Route::get('show/{id}',[CartController::class,'show'])->name('cart.show');
    Route::get('/checkout',[CartController::class,'checkout'])->name('checkout');

});


Route::prefix('admin')->group(function () {
    Route::get('/',[BackendController::class,'login'])->name('login');
    Route::post('/checklogin',[BackendController::class,'checklogin'])->name('Backend.checklogin');
});

Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function()
{
    Route::get('/logout',[BackendController::class,'logout'])->name('Backend.logout');
    Route::get('/dashboard',[BackendController::class,'index'])->name('Backend.dashboard');
    Route::get('/category',[CategoryController::class,'index'])->name('Category.index');
    Route::post('/addcategory',[CategoryController::class,'store'])->name('Category.store');
    Route::post('/updatecategory',[CategoryController::class,'update'])->name('Category.update');
    Route::get('/category/{id}',[CategoryController::class,'edit'])->name('Category.edit');

    Route::get('/product',[ProductController::class,'index'])->name('Product.index');
    Route::get('/addproduct',[ProductController::class,'create'])->name('Product.create');
    Route::post('/storeproduct',[ProductController::class,'store'])->name('Product.store');
    Route::get('/product/edit/{id}',[ProductController::class,'edit'])->name('Product.edit');
    Route::post('/product/update/{id}',[ProductController::class,'update'])->name('Product.update');
    Route::post('/addoptions',[ProductController::class,'addoptions'])->name('ProductOptions.add');
    Route::post('/getoptions',[ProductController::class,'getoptions'])->name('ProductOptions.get');
    Route::post('/updateoptions',[ProductController::class,'updateoptions'])->name('ProductOptions.updateoptions');
    Route::post('/optionvaluedelete/{id}',[ProductController::class,'optionvaluedelete'])->name('ProductOptions.optionvaluedelete');
    Route::post('/optiondelete',[ProductController::class,'optiondelete'])->name('ProductOptions.optiondelete');
    Route::post('/productvariants',[ProductController::class,'combination'])->name('ProductVariants.combinaton');
    Route::post('/product/delete/',[ProductController::class,'destroy'])->name('Product.delete');
    Route::get('/product/gallery/{id}',[ProductController::class,'gallery'])->name('admin.product.gallery');
    Route::get('/product/variants/{id}',[ProductController::class,'variants'])->name('admin.product.variants');
    Route::get('/product/productvarianlist',[ProductController::class,'productvarianlist'])->name('Product.Datatable');
    Route::get('/exportproduct/{id}',[ProductController::class,'exportproduct'])->name('Product.Export');
    Route::post('/importproduct',[ProductController::class,'importproduct'])->name('Product.import');
    Route::post('/variantpivot',[ProductController::class,'variantpivot'])->name('Product.variantpivot');
    Route::post('/variantimageupload',[ProductController::class,'variantimageupload'])->name('Product.variantimageupload');
    Route::post('/bulkpriceupdate',[ProductController::class,'bulkpriceupdate'])->name('Product.bulkpriceupdate');

    Route::post('/dropzone/upload',[ProductController::class,'upload'])->name('dropzone.upload');
    Route::get('/dropzone/fetch/{id}', [ProductController::class,'fetch'])->name('dropzone.fetch');
    Route::get('/dropzone/delete', [ProductController::class,'delete'])->name('dropzone.delete');

    #Ayarlar
    Route::get('/settings',[SettingsController::class,'index'])->name('Setting.index');
    Route::post('/settings/update/{id}',[SettingsController::class,'update'])->name('Setting.update');

    Route::get('/slider',[SliderController::class,'index'])->name('Slider.list');
    Route::get('/slider/create',[SliderController::class,'create'])->name('Slider.create');
    Route::post('/slider/store',[SliderController::class,'store'])->name('Slider.store');
    Route::post('/slider/delete/{id}',[SliderController::class,'destroy'])->name('Slider.delete');
    Route::post('/slider/update/{id}',[SliderController::class,'update'])->name('Slider.update');
    Route::get('/slider/edit/{id}',[SliderController::class,'edit'])->name('Slider.edit');


    Route::get('/page',[PageController::class,'index'])->name('Page.list');
    Route::get('/page/create',[PageController::class,'create'])->name('Page.create');
    Route::post('/page/store',[PageController::class,'store'])->name('Page.store');
    Route::post('/page/delete/{id}',[PageController::class,'destroy'])->name('Page.delete');
    Route::post('/page/update/{id}',[PageController::class,'update'])->name('Page.update');
    Route::get('/page/edit/{id}',[PageController::class,'edit'])->name('Page.edit');




    Route::get('/order',[OrderController::class,'index'])->name('admin.order');
    Route::get('/orderdetail/{id}',[OrderController::class,'show'])->name('admin.orderdetail');
    Route::post('/historyadd',[OrderController::class,'historyadd'])->name('admin.history.add');






});
