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
        $client = new \GuzzleHttp\Client();
        $sellers = Seller::all();
        $products = [];
        foreach ($sellers as $seller) {
            $api = $seller->all_products_api;
            if (!empty($api)) {
                $res = $client->request('GET', $api);
                if ($res->getStatusCode() == 200) {
                    $seller_products = json_decode($res->getBody(), true);
                    foreach($seller_products as $key => $value) {
                        $merged = collect($value)->merge(['seller_id' => $seller->id, 'seller_name' => $seller->name]);
                        array_push($products, $merged);
                    }
                }
            }
        }
        shuffle($products);
        return view('home', ['products' => $products]);
    }
}
