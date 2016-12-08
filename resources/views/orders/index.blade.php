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
                    <div class="col-md-8">
                      <table class="table bottomborder">
                        <thead>
                                <tr>
                                    <td><strong>Order Id</strong></td>
                                    <td class="text-center"><strong>Date</strong></td>
                                    <td class="text-center"><strong>Order Status</strong></td>
                                    <td class="text-right"><strong>Delivery Status</strong></td>
                                </tr>
                            </thead>


                         @foreach ($a as $order)
                         @php
                         $c = (array) json_decode(json_encode($order));
                         @endphp
                         <tr>
                                <td><strong><a href="/orders/{{ $c['id'] }}" > {{ $c['uuid'] }}</a></strong></td>
                                    <td class="text-center"><strong>{{$c['created_at']}}</strong></td>
                                    <td class="text-center"><strong>Confirmed</strong></td>
                                    <td class="text-right"><strong>Shipped</strong></td>

                                <td>
                                        <form action="/orders/{{ $c['id'] }}" method="GET">
                                        <button type="submit" class="btn btn-danger">
                                          <span class="glyphicon glyphicon-show" aria-hidden="true"></span>
                                          Order Details
                                        </button>
                                        </form>
                                </td>
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

