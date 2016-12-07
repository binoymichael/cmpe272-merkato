<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Seller;
use App\Product;
use App\ProductDetail;
use Carbon\Carbon;

class TrackingController extends Controller
{
    public function __construct()
    {

    }

    public function store(Request $request, Seller $seller, $seller_product_id)
    {
        Log::info('Recieved store request for tracking. for seller id: '.$seller->id.' pid: '.$seller_product_id);
        if($seller_product_id && is_numeric($seller_product_id)){
            $product = Product::firstOrCreate([
                'seller_id' => $seller->id,
                'seller_product_id' => $seller_product_id
            ]);
            $product->save();

            $product_detail = ProductDetail::firstOrCreate([
                'user_id' => 0,
                'product_id' => $product->id
            ]);
            $product_detail->external_visits = $product_detail->external_visits + 1;
            $product_detail->save();
        }
    }

}
