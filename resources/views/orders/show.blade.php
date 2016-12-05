@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Order Summary</div>
                <div class="panel-body">
                    Your order has been confirmed!
                    {{ json_encode($order) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




