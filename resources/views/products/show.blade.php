@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{$seller->name}} Products</div>

                <div class="panel-body">
                {{ json_encode($product) }}
            </div>
        </div>
    </div>
</div>
@endsection
