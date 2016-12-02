<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seller;

class SellersController extends Controller
{
	public function show(Seller $seller) 
	{
      return view('sellers.show', ['seller' => $seller, 'seller_ids' => $seller->id]);
	}
}

