<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function cart()
    {
        $user = \Auth::user();
        $cart = $user->cart();
        $products = json_decode($cart['details'], true);
        dd($products);
    }

    public function create(Request $request)
    {
        $user = \Auth::user();
        $product_id = $request->input('product_id');

        // There will one order with status as 'cart'
        // Once the user checkouts this cart the order status will change to
        // confirmed
        $cart = $user->cart();
        $products = json_decode($cart['details'], true);

        if (!in_array($product_id, $products)) {
          array_push($products, $product_id);
          $cart->details = json_encode($products);
          $cart->save();
        }

        return redirect('/cart');
    }

}

