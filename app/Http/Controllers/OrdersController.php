<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class OrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function create()
    {
      return view('orders.create');
    }

    public function store(Request $request)
    {
      return "Order Confirmed!";
    }
}

