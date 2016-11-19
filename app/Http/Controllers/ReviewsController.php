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

        $product = Product::where([
                'user_id' => $user_id,
                'seller_id' => $seller->id,
                'seller_product_id' => $product_id
            ])->first();

        $product->review_stars = $request->input('stars');
        $product->review_details = trim($request->input('details'));
        $product->save();
        $product_details = json_decode($product->cached_api_response, true);

		$request->session()->flash('alert_message', 'Review added!');
		$request->session()->flash('alert_class', 'success');

		return view('products.show', ['seller' => $seller, 'product' => $product, 'product_details' => $product_details]);
	}
}

