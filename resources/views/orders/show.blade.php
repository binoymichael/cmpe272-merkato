<?php
$name = Auth::user()->name;
$address = json_decode($order['address_details'], true);
$shipping = $address['shipping'];
$billing = $address['billing'];
$orderdetails = json_decode($order['details'], true);
$count = 0;
?>




@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">


                       <div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="text-center">
              <h2>Your order has been confirmed and is being processed! </h2>
               <h3> Order Id -<?php print_r(strtoupper($order['uuid'])); ?> </h3>
            </div>
            <hr>
            <div class="row">
                <div class="text-center">
                    <div class="col-xs-12 col-md-6 col-lg-6 pull-left">
                        <div class="panel panel-default height">
                            <div class="panel-heading">Billing Details</div>
                                <div class="panel-body">

                            <strong><?php print_r($name); ?>:</strong><br>
                            <?php print_r($billing['address1']); ?><br>
                            <?php print_r($billing['address2']); ?><br>
                            <?php print_r($billing['city']); ?><br>
                            <?php print_r($billing['state']); ?><br>
                            <strong><?php print_r($billing['zipcode']); ?></strong><br>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-md-6 col-lg-6 pull-right">
                    <div class="panel panel-default height">
                        <div class="panel-heading">Shipping Address</div>
                        <div class="panel-body">
                            <strong><?php print_r($name); ?>:</strong><br>
                            <?php print_r($shipping['address1']); ?><br>
                            <?php print_r($shipping['address2']); ?><br>
                            <?php print_r($shipping['city']); ?><br>
                            <?php print_r($shipping['state']); ?><br>
                            <strong><?php print_r($shipping['zipcode']); ?></strong><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="text-center"><strong>Order summary</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <td><strong>Item Name</strong></td>
                                    <td class="text-center"><strong>Item Price</strong></td>
                                    <td class="text-center"><strong>Item Quantity</strong></td>
                                    <td class="text-right"><strong>Total</strong></td>
                                </tr>
                            </thead>
                            <tbody>

 @foreach ($orderdetails as $key => $value)

                    @php
                      $product_details = \DB::table('products')->select("cached_api_response")
                                              ->where('products.id', '=', $key)->get();
                      $product_details = json_decode($product_details);
                      $product_details = (array) json_encode($product_details[0]);
                      $product_details =(array) json_decode($product_details[0]);
                      $product_details = (array) json_decode($product_details['cached_api_response']);
                      $price = (float)str_replace(["$"], [""], $product_details['price']);
                      $totalprice = $price * $value;
                      $count = $count+$totalprice;
                    @endphp


                          <tr>
                                  <td> {{ $product_details['name']}} </td>
                                   <td class="text-center">${{ number_format($price, 2) }}</td>
                                   <td class="text-center">{{$value}}</td>
                                <td class="text-right">${{ number_format($totalprice, 2) }}</td>
                                </tr>

                            @endforeach
                                <tr>
                                    <td class="highrow"><i class="fa fa-barcode iconbig"></i></td>
                                    <td class="highrow"></td>
                                    <td class="highrow text-center"><strong>Total</strong></td>
                                    <td class="highrow text-right">${{ number_format($count, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.height {
    min-height: 200px;
}

.icon {
    font-size: 47px;
    color: #5CB85C;
}

.iconbig {
    font-size: 77px;
    color: #5CB85C;
}

.table > tbody > tr > .emptyrow {
    border-top: none;
}

.table > thead > tr > .emptyrow {
    border-bottom: none;
}

.table > tbody > tr > .highrow {
    border-top: 3px solid;
}
</style>



        </div>
    </div>
</div>
@endsection




