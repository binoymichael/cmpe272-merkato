<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['uuid', 'status', 'details'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
