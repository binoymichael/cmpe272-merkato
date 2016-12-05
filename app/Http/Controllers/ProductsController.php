<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seller;
use App\Product;
use App\ProductDetail;
use Carbon\Carbon;
use Auth;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function recent()
    {
      $products = Auth::user()->recent_products();
      return view('products.recent', ['products' => $products->pluck('product')]);
    }

	public function show(Seller $seller, $seller_product_id) 
	{
        $client = new \GuzzleHttp\Client();
        $api = str_replace(['%product_id%'], [$seller_product_id], $seller->show_product_api);
        $product = [];
        if (!empty($api)) {
            $res = $client->request('GET', $api);
            if ($res->getStatusCode() == 200) {
                $user_id = (int)\Auth::id();
                $api_response = $res->getBody();

                $product = Product::firstOrCreate([
                        'seller_id' => $seller->id,
                        'seller_product_id' => $seller_product_id
                    ]);
                $product->cached_api_response = $api_response;
                $product->save();

                $product_detail = ProductDetail::firstOrCreate([
                        'user_id' => $user_id,
                        'product_id' => $product->id
                    ]);
                $product_detail->visited_count = $product_detail->visited_count + 1;
                $product_detail->last_visited_at = Carbon::now();
                $product_detail->save();

                $review_details = [];
                $reviews = $product->reviews();
                $review_details['reviews'] = $reviews;
                $review_details['avg_review'] = floor($reviews->pluck('review_stars')->avg());
                $review_details['reviews_count'] = count($reviews);

                $product_api_response = json_decode($api_response, true);
            }
        }

        return view('products.show', ['seller' => $seller, 
                                      'product_api_response' => $product_api_response, 
                                      'product_detail' => $product_detail, 
                                      'review_details' => $review_details]);
	}
}

