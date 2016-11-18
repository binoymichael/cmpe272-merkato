<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seller;

class SellersController extends Controller
{
	public function show(Seller $seller) 
	{
        $client = new \GuzzleHttp\Client();
        $products = [];
        $api = $seller->all_products_api;
        if (!empty($api)) {
            $res = $client->request('GET', $api);
            if ($res->getStatusCode() == 200) {
                $products = json_decode($res->getBody(), true);
            }
        }
		return view('sellers.show', ['seller' => $seller, 'products' => $products]);

	}
}

