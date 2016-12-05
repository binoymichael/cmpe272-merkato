@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Order Summary</div>
                <div class="panel-body">
                    <form id="payment-form" action="/orders" method="POST">
                      {{ csrf_field() }}
                      <div class="col-md-4">
                        <h4>Shipping Address</h4>
                        <p>
                          {{ $shipping_details['address1'] }}
                          {{ $shipping_details['address2'] }}
                          <br/>
                          {{ $shipping_details['city'] }}
                          <br/>
                          {{ $shipping_details['state'] }}
                          <br/>
                          {{ $shipping_details['zipcode'] }}
                        </p>
                      </div>
                      <div class="col-md-4">
                        <h4>Billing Address</h4>
                        <p>
                          {{ $billing_details['address1'] }}
                          {{ $billing_details['address2'] }}
                          <br/>
                          {{ $billing_details['city'] }}
                          <br/>
                          {{ $billing_details['state'] }}
                          <br/>
                          {{ $billing_details['zipcode'] }}
                        </p>
                      </div>
                      <div class="col-md-2">
                        <h4>Total Price</h4>
                        <h3> <b>{{ "$" . number_format($total_price/100, 2)}} </b></h3>
                        <br/>
                        <script
                          src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                          data-key="pk_test_6pRNASCoBOKtIshFeQd4XMUh"
                          data-amount={{ $total_price }}
                          data-name="Merkato"
                          data-email={{  $user->email }}
                          data-description="Payment"
                          data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                          data-locale="auto"
                        >
                        </script>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



