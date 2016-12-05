<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seller;
use App\Product;
use App\ProductDetail;


class ReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function store(Request $request, Seller $seller, $seller_product_id) 
	{

        $user_id = \Auth::id();

        $product = Product::where([
                'seller_id' => $seller->id,
                'seller_product_id' => $seller_product_id
            ])->first();

        $product_detail = ProductDetail::where(['user_id' => $user_id, 'product_id' => $product->id])->first();
        $product_detail->review_stars = $request->input('stars');
        $product_detail->review_details = trim($request->input('details'));
        $product_detail->save();

        $request->session()->flash('alert_message', 'Review added!');
        $request->session()->flash('alert_class', 'success');

        $product_api_response = json_decode($product->cached_api_response, true);

        $review_details = [];
        $reviews = $product->reviews();
        $review_details['reviews'] = $reviews;
        $review_details['avg_review'] = floor($reviews->pluck('review_stars')->avg());
        $review_details['reviews_count'] = count($reviews);

        return view('products.show', ['seller' => $seller,
          'product_api_response' => $product_api_response,
          'product_detail' => $product_detail,
          'review_details' => $review_details
        ]);
	}
}

