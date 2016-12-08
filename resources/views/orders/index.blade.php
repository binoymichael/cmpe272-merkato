<?php
 $a=json_decode($orders);
?>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Orders</div>

                <div class="panel-body">
                    <div class="col-md-12">
                      <table class="table bottomborder">
                        <thead>
                                <tr>
                                    <td class="col-md-2"><strong>Order Id</strong></td>
                                    <td class="col-md-2 text-center"><strong>Date</strong></td>
                                    <td class="col-md-2 text-center"><strong>Order Status</strong></td>
                                    <td class="col-md-2 text-center"><strong>Delivery Status</strong></td>
                                    <td class="col-md-2 text-right"></td>
                                </tr>
                            </thead>


                         @foreach ($a as $order)
                         @php
                         $c = (array) json_decode(json_encode($order));
                         @endphp
                         <tr>
                                <td><strong><a href="/orders/{{ $c['id'] }}" > {{ strtoupper($c['uuid']) }}</a></strong></td>
                                    <td class="text-center"><strong>{{$c['created_at']}}</strong></td>
                                    <td class="text-center"><strong>Confirmed</strong></td>
                                    <td class="text-center"><strong>Shipped</strong></td>
                                <td> <a href="/orders/{{ $c['id'] }}" class="btn btn-danger">Order Details</a> </td>
                            </tr>
                               @endforeach
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

