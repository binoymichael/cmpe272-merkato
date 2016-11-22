@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div id="home-panel" class="panel-body" data-seller-ids={{$seller_ids}}>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

