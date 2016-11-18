<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seller;
use App\Product;


class ReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function store(Request $request, Seller $seller, $product_id) 
	{

        $user_id = \Auth::id();

        $product = Product::firstOrCreate([
                'user_id' => $user_id,
                'seller_id' => $seller->id,
                'seller_product_id' => $product_id
            ]);

        $product->review_stars = $request->input('stars');
        $product->review_details = $request->input('details');
        $product->save();

        echo 'Review saved!';
	}
}

