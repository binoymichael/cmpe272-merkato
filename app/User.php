<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
}
