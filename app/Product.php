<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'seller_id', 'seller_product_id'];

    public static function visited_counts($seller_id)
    {
        $visit_data = \DB::table('products')
        ->join('product_details', 'products.id', '=', 'product_details.product_id')
        ->where('products.seller_id', '=', $seller_id)
        ->select(\DB::raw("CONCAT(products.seller_id,':', products.seller_product_id) as seller_full_product_id,
                           SUM(product_details.visited_count) as visited_count,
                           SUM(product_details.external_visits) as external_visits
                         "))
        ->groupBy('products.seller_id', 'products.seller_product_id')
        ->get();

        $rating_data = \DB::table('products')
        ->join('product_details', 'products.id', '=', 'product_details.product_id')
        ->where('product_details.review_stars', '!=', 0)
        ->select(\DB::raw("CONCAT(products.seller_id,':', products.seller_product_id) as seller_full_product_id,
                           AVG(product_details.review_stars) as avg_review_stars
                         "))
        ->groupBy('products.seller_id', 'products.seller_product_id')
        ->get();

        $visit_keyed = $visit_data->keyBy('seller_full_product_id');
        $rating_keyed = $rating_data->keyBy('seller_full_product_id');


        $merged = array_merge_recursive($visit_keyed->toArray(), $rating_keyed->toArray());
        return $merged;
    }

    public function reviews() 
    {
        $rating_data = \DB::table('products')
        ->join('product_details', 'products.id', '=', 'product_details.product_id')
        ->join('users', 'users.id', '=', 'product_details.user_id')
        ->where('products.id', '=', $this->id)
        ->where('product_details.review_stars', '!=', 0)
        ->where('product_details.user_id', '!=', 0)
        ->select("users.id as user_id", "users.name as user_name", "users.email as user_email", "product_details.review_stars", "product_details.review_details")
        ->get()->keyBy("user_id");
        return $rating_data;
    }

    public function product_details()
    {
        return $this->hasMany('App\ProductDetail');
    }

    public function seller()
    {
        return $this->belongsTo('App\Seller');
    }
}
