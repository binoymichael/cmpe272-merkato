@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @foreach ($products as $product)
                        <div class="card">
                        <a href="/sellers/{{$product['seller_id']}}/products/{{$product['id']}}">
                          <img src="{{ urldecode($product['image_url']) }}" alt="Avatar" style="width:200px; height: 270px; margin-left:10px;">
                          </a>
                          <div class="card-container">
                        <a href="/sellers/{{$product['seller_id']}}/products/{{$product['id']}}">
                            <h4>
                            <b>{{ (strlen($product['name']) <= 18 ? $product['name'] : substr($product['name'], 0, 18) . " ...") }}</b></h4> 
                        </a>
                            <p>From <a href="/sellers/{{ $product['seller_id']}}">{{ $product['seller_name'] }}</a></p> 
                          </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
