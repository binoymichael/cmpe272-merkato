@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Recently Visited</div>

                <div class="panel-body">
                {{ json_encode($products) }}
            </div>
        </div>
    </div>
</div>
@endsection
