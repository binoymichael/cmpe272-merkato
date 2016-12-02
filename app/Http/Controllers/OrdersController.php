<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

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

    public function create()
    {
        $user = \Auth::user();
        $cart = $user->cart();
        $product_ids = json_decode($cart['details'], true);

        $products = Product::whereIn('id', $product_ids)->get();
        $total_price = $products->reduce(function($total, $product) {
              $product_details = json_decode($product->cached_api_response, true);
              $price = (float)str_replace(["$"], [""], $product_details['price']);
              return $total + $price;
        });

      return view('orders.create', ['user' => $user, 'total_price' => $total_price * 100]);
    }

    public function store(Request $request)
    {
      return "Order Confirmed!";
    }
}

