@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Checkout</div>
                <div class="panel-body">
                    <form action="/orders" method="POST">
                      {{ csrf_field() }}
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


