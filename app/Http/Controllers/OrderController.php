<?php

namespace App\Http\Controllers;

use App\Order;
use App\Cart;
use App\Customer;
use Session;
use DB;
use App\Http\Requests\StoreOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (!Session::has('cart') || empty(Session::get('cart')->getContents())) {
        return redirect('products')->with('message', 'No Product in Cart');
      }
      $cart = Session::get('cart');
      return view('products.checkout', compact('cart'));
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
    public function store(StoreOrder $request)
    {
          $cart = [];
          $order = '';
          $checkout = '';
        if (Session::has('cart')) {
          $cart = Session::get('cart');
        }
        if ($request->shipping_address) {
          $customer = [
            "billing_firstName" =>  $request->billing_firstName,
            "billing_lastName" =>  $request->billing_lastName,
            "billing_userame" =>  $request->billing_userame,
            "billing_email" =>  $request->billing_email,
            "billing_address" =>  $request->billing_address,
            "billing_address2" =>  $request->billing_address2,
            "billing_country" =>  $request->billing_country,
            "billing_state" =>  $request->billing_state,
            "billing_zip" =>  $request->billing_zip,

            "shipping_firstName" => $request->shipping_firstName,
            "shipping_lastName" => $request->shipping_lastName,
            "shipping_userame" => $request->shipping_userame,
            "shipping_address1" => $request->shipping_address1,
            "shipping_address2" => $request->shipping_address2,
            "shipping_country" => $request->shipping_country,
            "shipping_state" => $request->shipping_state,
            "shipping_zip" => $request->shipping_zip
          ];
        }else {
          $customer = [
            "billing_firstName" =>  $request->billing_firstName,
            "billing_lastName" =>  $request->billing_lastName,
            "billing_userame" =>  $request->billing_userame,
            "billing_email" =>  $request->billing_email,
            "billing_address" =>  $request->billing_address,
            "billing_address2" =>  $request->billing_address2,
            "billing_country" =>  $request->billing_country,
            "billing_state" =>  $request->billing_state,
            "billing_zip" =>  $request->billing_zip
          ];
        }
        DB::beginTransaction();
        $checkout = Customer::create($customer);
        foreach ($cart->getContents() as $slug => $product) {
          $products = [
            "user_id" => $checkout->id,
            "product_id" => $product['product']->id,
            "qty" => $product['qty'],
            "status" => 'Pending',
            "price" => $product['price'],
            "payment_id" => 0
          ];
          $order = Order::create($products);
        }
        if ($checkout && $order) {
          DB::commit();
          return view('layouts.products.payments');
        }else {
          DB::rollback();
          return redirect('checkout')->with('message', 'Invalid Activity');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
