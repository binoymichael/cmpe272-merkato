@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Recently Visited</div>

                <div class="panel-body col-md-12">
                    @foreach ($products as $product)
                         @php
                            $product_details = json_decode($product->cached_api_response, true);
                         @endphp
                         <div class="col-md-3">
                            <div class="card">
                            <a href="/sellers/{{$product->seller_id}}/products/{{$product->seller_product_id}}">
                              <img src="{{ urldecode($product_details['image_url']) }}" alt="Avatar" style="width:200px; height: 270px;">
                              </a>
                              <div class="card-container">
                            <a href="/sellers/{{$product->seller_id}}/products/{{$product->seller_product_id}}">
                                <h4>
                                <b>{{ (strlen($product_details['name']) <= 18 ? $product_details['name'] : substr($product_details['name'], 0, 18) . " ...") }}</b></h4> 
                            </a>
                                <p>From <a href="/sellers/{{ $product->seller_id }}">{{ $product->seller->name }}</a></p> 
                              </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
