<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seller;
use App\Product;
use Carbon\Carbon;
use Auth;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function recent()
    {
        $products = Auth::user()->products;
        return view('products.recent', ['products' => $products]);
    }

	public function show(Seller $seller, $product_id) 
	{
        $client = new \GuzzleHttp\Client();
        $api = str_replace(['%product_id%'], [$product_id], $seller->show_product_api);
        $product = [];
        if (!empty($api)) {
            $res = $client->request('GET', $api);
            if ($res->getStatusCode() == 200) {
                $user_id = \Auth::id();
                $api_response = $res->getBody();

                $product = Product::firstOrCreate([
                        'user_id' => $user_id,
                        'seller_id' => $seller->id,
                        'seller_product_id' => $product_id
                    ]);
                $product->visited_count = $product->visited_count + 1;
                $product->last_visited_at = Carbon::now();
                $product->cached_api_response = $api_response;
                $product->save();

                $product_details = json_decode($api_response, true);
            }
        }

		return view('products.show', ['seller' => $seller, 'product' => $product, 'product_details' => $product_details]);
	}
}

