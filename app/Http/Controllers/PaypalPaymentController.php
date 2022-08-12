<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Omnipay\Omnipay;

class PaypalPaymentController extends Controller
{
    private  $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true); //set it to 'false' when go live
    }
    public function index()
    {
        return view('payment');
    }

    /**
     * Initiate a payment on PayPal.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function charge(Request $request)
    {
        $request->session()->put('adressid',$request->aname);

        if($request->input('submit'))
        {
            try {
                $response = $this->gateway->purchase(array(
                    'amount' => $request->input('amount'),
                    'currency' => env('PAYPAL_CURRENCY'),
                    'returnUrl' => url('success'),
                    'cancelUrl' => url('error'),
                ))->send();

                if ($response->isRedirect()) {
                    $response->redirect(); // this will automatically forward the customer
                } else {
                    // not successful
                    return $response->getMessage();
                }
            } catch(Exception $e) {
                return $e->getMessage();
            }
        }
    }


    /**
     * Charge a payment and store the transaction.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function success(Request $request)
    {

        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID'))
        {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id'             => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful())
            {
                // The customer has successfully paid.
                $arr_body = $response->getData();

                // Insert transaction data into the database
                $order = new Order();
                $order->payment_id = $arr_body['id'];
                $order->payer_id = $arr_body['payer']['payer_info']['payer_id'];
                $order->payer_email = $arr_body['payer']['payer_info']['email'];
                $order->amount = $arr_body['transactions'][0]['amount']['total'];
                $order->currency = env('PAYPAL_CURRENCY');
                $order->payment_status = $arr_body['state'];
                $order->user_id = Auth::id();
                $order->adress_id = $request->session()->get('adressid');
                if($order->save())
                {
                    $request->session()->forget('adressid');

                    $toplam=0;
                    foreach (session()->get('cart') as $rs)
                    {
                        $price=0;

                        if ($rs->isvariable==1)
                        {
                            $price=isset($rs->pvdprice)?$rs->pvdprice:$rs->pvprice;
                            $toplam=$toplam+($price*$rs->quantity);
                        }
                        else
                        {
                            $price=isset($rs->discount_price)?$rs->discount_price:$rs->price;
                            $toplam=$toplam+($price*$rs->quantity);
                        }


                        $orderProduct=new OrderProduct();
                        $orderProduct->order_id=$order->id;
                        $orderProduct->product_id=$rs->pid;
                        $orderProduct->product_variant_id=$rs->pvid;
                        $orderProduct->quantity=$rs->quantity;
                        $orderProduct->product_name=($rs->isvariable==1)?$rs->pvname:$rs->name;
                        $orderProduct->price=$price;
                        $orderProduct->total=$toplam;
                        $orderProduct->save();

                    }



                    session()->forget('cart');

                    Cart::where('user_id',Auth::id())->delete();

                }


                $id=$arr_body['id'];

                return view('order-success',['id'=>$id]);
            } else {
                $msj=$response->getMessage();
                return view('order-error',['msj'=>$msj]);
            }
        } else {
            $msj="Transaction is declined";
            return view('order-error',['msj'=>$msj]);

        }
    }


    /**
     * Error Handling.
     */
    public function error()
    {
        return 'User cancelled the payment.';
    }


    public function plannercharge(Request $request)
    {


        if($request->input('submit'))
        {
            try {
                session()->put('adressid',$request->adres);
                $response = $this->gateway->purchase(array(
                    'amount' => $request->input('amount'),
                    'currency' => env('PAYPAL_CURRENCY'),
                    'returnUrl' => url('plannersuccess'),
                    'cancelUrl' => url('error'),
                ))->send();

                if ($response->isRedirect()) {
                    $response->redirect(); // this will automatically forward the customer
                } else {
                    // not successful
                    return $response->getMessage();
                }
            } catch(Exception $e) {
                return $e->getMessage();
            }
        }
    }


    public function plannersuccess(Request $request)
    {

        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID'))
        {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id'             => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful())
            {

                // The customer has successfully paid.
                $arr_body = $response->getData();

                // Insert transaction data into the database
                $order = new Order();
                $order->payment_id = $arr_body['id'];
                $order->payer_id = $arr_body['payer']['payer_info']['payer_id'];
                $order->payer_email = $arr_body['payer']['payer_info']['email'];
                $order->amount = $arr_body['transactions'][0]['amount']['total'];
                $order->currency = env('PAYPAL_CURRENCY');
                $order->payment_status = $arr_body['state'];
                $order->user_id = Auth::id();
                $order->adress_id = $request->session()->get('adressid');
                $order->comment = $request->session()->get('comment');
                if($order->save())
                {
                    $request->session()->forget('adressid');


                    foreach (session()->get('cit') as $rs)
                    {

                        $orderProduct=new OrderProduct();
                        $orderProduct->order_id=$order->id;
                        $orderProduct->product_id=$rs->id;
                        $name=$rs->name;
                        $price=$rs->price;
                        if ( isset($rs->variant))
                        {
                            $price=0;
                            foreach($rs->variant as $v)
                            {
                                $name.="|".$v->voname;
                                $price+=$v->vprice;



                            }

                        }
                        $orderProduct->quantity=$rs->adet;
                        $orderProduct->product_name=$name;

                        $orderProduct->price=$price;
                        $orderProduct->save();

                    }


                    foreach (session()->get('kapi') as $rs)
                    {
                        $orderProduct=new OrderProduct();
                        $orderProduct->order_id=$order->id;
                        $orderProduct->product_id=$rs->id;
                        $name=$rs->name;
                        $price=$rs->price;
                        if ( isset($rs->variant))
                        {
                            $price=0;
                            foreach($rs->variant as $v)
                            {
                                $name.="|".$v->voname;
                                $price+=$v->vprice;

                            }
                        }

                        $orderProduct->quantity=$rs->adet;
                        $orderProduct->product_name=$name;


                        $orderProduct->price=$price;
                        $orderProduct->save();

                    }

                    foreach (session()->get('baba') as $rs)
                    {

                        $orderProduct=new OrderProduct();
                        $orderProduct->order_id=$order->id;
                        $orderProduct->product_id=$rs->id;
                        $name=$rs->name;
                        $price=$rs->price;
                        if ( isset($rs->variant))
                        {
                            $price=0;
                            foreach($rs->variant as $v)
                            {
                                $name.="|".$v->voname;
                                $price+=$v->vprice;

                            }
                        }
                        $orderProduct->quantity=$rs->adet;
                        $orderProduct->product_name=$name;
                        $orderProduct->price=$price;
                        $orderProduct->save();

                    }

                    session()->forget('cit');
                    session()->forget('kapi');
                    session()->forget('baba');
                    session()->forget('comment');
                    session()->forget('adressid');



                }


                $id=$arr_body['id'];

                return view('order-success',['id'=>$id]);
            } else {
                $msj=$response->getMessage();
                return view('order-error',['msj'=>$msj]);
            }
        } else {
            $msj="Transaction is declined";
            return view('order-error',['msj'=>$msj]);

        }
    }

}
