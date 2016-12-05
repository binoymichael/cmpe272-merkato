<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Order;

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
      return view('orders.create');
    }

    public function confirm(Request $request)
    {
      $address_details = [];
      $address_details['shipping'] = $request->shipping;
      $address_details['billing'] = $request->billing;

      $user = \Auth::user();
      $cart = $user->cart();
      $cart->address_details = json_encode($address_details);
      $cart->save();

      $cart_items = json_decode($cart['details'], true);
      $product_ids = array_keys($cart_items);

      $products = Product::whereIn('id', $product_ids)->get();
      $total_price = 0;
      foreach ($products as $product) {
            $product_details = json_decode($product->cached_api_response, true);
            $price = (float)str_replace(["$"], [""], $product_details['price']);
            $quantity = (int)$cart_items[$product->id];
            $total_price += $price * $quantity;
      }
      
      return view('orders.confirm', ['user' => $user,
                                      'shipping_details' => $address_details['shipping'],
                                      'billing_details' => $address_details['billing'],
                                      'total_price' => $total_price * 100]);
    }

    public function store(Request $request)
    {
      $user = \Auth::user();
      $cart = $user->cart();
      $cart->status = "confirmed";
      $cart->save();
      return redirect()->action(
          'OrdersController@show', ['id' => $card->id]
      );
    }

    public function show(Order $order) 
    {
      if ($order->user_id !== \Auth::id()) {
        return response('Unauthorised Access', 403);
      } else {
        return view('orders.show', ['order' => $order]);
      }
    }

    public function index() 
    {
        $orders = \Auth::user()->orders()->where('status', '!=', 'cart')->get();
        return view('orders.index', ['orders' => $orders]);
    }


}

