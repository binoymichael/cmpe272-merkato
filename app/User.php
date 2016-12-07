<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function recent_products() 
    {
      return $this->product_details()
                  ->with('product.seller')
                  ->orderBy('product_details.last_visited_at', 'DESC')
                  ->get();
    }

    public function product_details()
    {
        return $this->hasMany('App\ProductDetail');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
  
    public function cart()
    {
        $cart = $this->orders()->where('status', 'cart')->first();
        if ($cart == null) {
          $products = [];
          $reference_number = str_random(10);
          $details = json_encode($products);
          $cart = $this->orders()->create([
            'uuid' => $reference_number,
            'status' => 'cart',
            'details' => $details
          ]);
        }
        return $cart;
    }
}
