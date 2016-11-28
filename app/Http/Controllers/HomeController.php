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
        $sellers = Seller::all();
        $seller_ids = array_pluck($sellers, 'id');
        shuffle($seller_ids);
        $seller_ids = implode(",", $seller_ids);
        return view('home', ['seller_ids' => $seller_ids]);
    }

    public function products(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $product_details_data = Product::visited_counts();
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

                    $seller_full_product_id = $seller->id . ":" . $value['id'];
                    $product_details = collect($product_details_data)->get($seller_full_product_id, null);
                    $visited_count = 0;
                    $avg_review_stars = 0;
                    if ($product_details != null) {
                        $visited_count = (int)(collect($product_details)->get('visited_count', 0));
                        $avg_review_stars = floor((int)(collect($product_details)->get('avg_review_stars', 0) * 1000));
                    }

                    $merged = collect($value)->merge(['seller_id' => $seller->id, 
                                                      'seller_name' => $seller->name,
                                                      'price' => $price, 
                                                      'visited_count' => $visited_count,
                                                      'avg_rating' => $avg_review_stars,
                                                    ]);

                    array_push($products, $merged);
                }
            }
        }

        return response()->json(['seller_ids' => $seller_ids, 'products' => $products]);
    }
}
