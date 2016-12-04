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
        $cart_items = json_decode($cart['details'], true);
        $product_ids = array_keys($cart_items);
        $products = Product::whereIn('id', $product_ids)->get()->keyBy('id');

        //dd($products);

        return view('cart.index', ['products' => $products, 
                                    'product_ids' => $product_ids,
                                    'cart_items' => $cart_items
                                   ]);
    }

    public function store(Request $request)
    {
        $user = \Auth::user();
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        // There will one order with status as 'cart'
        // Once the user checkouts this cart the order status will change to
        // confirmed
        $cart = $user->cart();
        $items = json_decode($cart['details'], true);

        $items[$product_id] = $quantity;
        $cart->details = json_encode($items);
        $cart->save();

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
        $cart_items = json_decode($cart['details'], true);
        unset($cart_items[$product_id]);

        $cart->details = json_encode($cart_items);
        $cart->save();

        return redirect('/cart');
    }

}

