@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{$seller->name}} Products</div>

                <div class="panel-body">
                    @foreach ($products as $product)
                        <div class="card">
	                        <a href="/sellers/{{$seller->id}}/products/{{$product['id']}}">
		                        <img src="{{ urldecode($product['image_url']) }}" alt="Avatar" style="width:200px; height: 270px; margin-left:10px;">
	                        </a>
                            <div class="card-container">
		                        <a href="/sellers/{{$seller->id}}/products/{{$product['id']}}">
		                            <h4><b>{{ $product['name'] }}</b></h4> 
		                        </a>
	                        </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
