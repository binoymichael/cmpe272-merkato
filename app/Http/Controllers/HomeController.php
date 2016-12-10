<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Seller;
use App\Product;

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
        $sellers = Seller::where('id', '!=', 4)->get();
        $seller_ids = array_pluck($sellers, 'id');
        shuffle($seller_ids);
        array_push($seller_ids, 4);
        $seller_ids = implode(",", $seller_ids);
        return view('home', ['seller_ids' => $seller_ids]);
    }

    public function products(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $seller_id = $request->seller_id;
        $seller = Seller::find($seller_id);
        if ($seller == null) {
          return response()->json(['products' => []]);
        }

        $product_details_data = Product::visited_counts($seller_id);
        $products = [];

        $api = $seller->all_products_api;

        if (!empty($api)) {

            $res = $client->request('GET', $api, ['connect_timeout' => 5, 'timeout' => 5]);
            if ($res->getStatusCode() == 200) {
                $seller_products = json_decode($res->getBody(), true);
                foreach($seller_products as $key => $value) {
                    $price = (int)str_replace(["$"], [""], $value['price']) * 100;

                    $seller_full_product_id = $seller->id . ":" . $value['id'];
                    $product_details = collect($product_details_data)->get($seller_full_product_id, null);
                    $visited_count = 0;
                    $external_visits = 0;
                    $avg_review_stars = 0;
                    if ($product_details != null) {
                        $visited_count = (int)(collect($product_details)->get('visited_count', 0));
                        $external_visits = (int)(collect($product_details)->get('external_visits', 0));
                        $avg_review_stars = floor((int)(collect($product_details)->get('avg_review_stars', 0) * 1000));
                    }

                    $merged = collect($value)->merge(['seller_id' => $seller->id, 
                                                      'seller_name' => $seller->name,
                                                      'price' => $price, 
                                                      'visited_count' => $visited_count,
                                                      'external_visits' => $external_visits,
                                                      'avg_rating' => $avg_review_stars,
                                                    ]);

                    array_push($products, $merged);
                }
            }
        }

        return response()->json(['products' => $products]);
    }

    public function graph() 
    {
        return view('home.graph');
    }
}
