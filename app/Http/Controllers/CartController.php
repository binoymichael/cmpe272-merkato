<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class CartController extends Controller
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

    public function index()
    {
        $user = \Auth::user();
        $cart = $user->cart();
        $product_ids = json_decode($cart['details'], true);
        $products = Product::whereIn('id', $product_ids)->get()->keyBy('id');

        //dd($products);

        return view('cart.index', ['products' => $products, 
                                    'product_ids' => $product_ids
                                   ]);
    }

    public function store(Request $request)
    {
        $user = \Auth::user();
        $product_id = $request->input('product_id');

        // There will one order with status as 'cart'
        // Once the user checkouts this cart the order status will change to
        // confirmed
        $cart = $user->cart();
        $product_ids = json_decode($cart['details'], true);

        if (!in_array($product_id, $product_ids)) {
          array_push($product_ids, $product_id);
          $cart->details = json_encode($product_ids);
          $cart->save();
        }

        return redirect('/cart');
    }

    public function update(Request $request)
    {
        $user = \Auth::user();
        $product_id = $request->input('product_id');

        // There will one order with status as 'cart'
        // Once the user checkouts this cart the order status will change to
        // confirmed
        $cart = $user->cart();
        $product_ids = json_decode($cart['details'], true);

        $index = array_search($product_id, $product_ids);
        if ( $index !== false ) {
          unset( $product_ids[$index] );
        }

        $cart->details = json_encode($product_ids);
        $cart->save();

        return redirect('/cart');
    }

}

