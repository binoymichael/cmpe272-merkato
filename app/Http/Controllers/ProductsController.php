<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seller;

class ProductsController extends Controller
{
	public function show(Seller $seller, $product_id) 
	{
        $client = new \GuzzleHttp\Client();
        $api = str_replace(['%product_id%'], [$product_id], $seller->show_product_api);
        $product = [];
        if (!empty($api)) {
            $res = $client->request('GET', $api);
            if ($res->getStatusCode() == 200) {
                $product = json_decode($res->getBody(), true);
            }
        }

		return view('products.show', ['seller' => $seller, 'product' => $product]);
	}
}

