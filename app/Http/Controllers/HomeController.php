<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = Seller::all();
        $seller_ids = array_pluck($sellers, 'id');
        shuffle($seller_ids);
        $seller_ids = implode(",", $seller_ids);
        return view('home', ['seller_ids' => $seller_ids]);
    }

    public function products(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $products = [];

        $seller_ids = explode(",", $request->seller_ids);
        $current_seller_id = array_shift($seller_ids);
        $seller = Seller::find($current_seller_id);

        $api = $seller->all_products_api;
        if (!empty($api)) {
            $res = $client->request('GET', $api);
            if ($res->getStatusCode() == 200) {
                $seller_products = json_decode($res->getBody(), true);
                foreach($seller_products as $key => $value) {
                    $price = (int)str_replace(["$"], [""], $value['price']) * 100;
                    $merged = collect($value)->merge(['seller_id' => $seller->id, 'seller_name' => $seller->name, 'price' => $price]);
                    array_push($products, $merged);
                }
            }
        }

        return response()->json(['seller_ids' => $seller_ids, 'products' => $products]);
    }
}
