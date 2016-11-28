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

    public static function visited_counts()
    {
        $data = \DB::table('products')
        ->join('product_details', 'products.id', '=', 'product_details.product_id')
        ->select(\DB::raw('CONCAT(products.seller_id, ":", products.seller_product_id) as seller_full_product_id,
                           SUM(product_details.visited_count) as visited_count,
                           AVG(product_details.review_stars) as avg_review_stars
                         '))
        ->groupBy('products.seller_id', 'products.seller_product_id')
        ->get();

        $keyed = $data->keyBy('seller_full_product_id');
        return $keyed;
    }

    public function product_details()
    {
        return $this->hasMany('App\ProductDetail');
    }
}
