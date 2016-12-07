<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\Mailer;

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


      Mailer::send_order_confirmation($cart);
      $this->postchild($cart);

     return redirect()->action(
         'OrdersController@show', ['id' => $cart->id]
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

   private function postchild(&$cart)
   {
      $items = json_decode($cart['details'], true);

          $seller_order = array();
      foreach ($items as $key => $value) {

        $seller_details = \DB::table('products')
        ->join('sellers', 'products.seller_id', '=', 'sellers.id')
        ->where('products.id', '=', $key)
        ->select("products.seller_product_id as seller_product_id", "sellers.post_product_api as post_product_api")
        ->get();

          $seller_array = json_decode(json_encode($seller_details),true);

          $temp = $seller_array[0];


        $product_quantity = [];
        $product = $temp['seller_product_id'];
        $product_quantity[$product] = $value;


        $seller_api = $temp['post_product_api'];

              if(isset($seller_order["$seller_api"]))
        {

          $seller_order[$seller_api] = $seller_order[$seller_api] + $product_quantity;
        }
                else
                {
          $seller_order[$seller_api] = $product_quantity;
        }

         // $seller_order[$seller_api][] = $product_quantity;



      }

      $this->callsellerpostapi($seller_order);

   }


    private function callsellerpostapi(&$seller_order)

          {

              foreach ($seller_order as $key => $value)
                  {
                    $value = json_encode($value);
                      //dd($value);
                $client = new \GuzzleHttp\Client(['headers' =>['Content-Type' => 'application/json']]);

                     try
                     {
                      $res = $client->request('POST', $key, ['body' => $value]);
                        }
                        catch(PDOException $e) {
                          continue;
                            }

                      $status = $res->getStatusCode();
                        //print_r($status);
                        $body = $res->getBody()->getContents();


                          }


                  }

}

