@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Shipping Details</div>
                <div class="panel-body">
                    <form id="payment-form" action="/orders/confirm" method="POST">
                      {{ csrf_field() }}
                      <div class="col-md-3">
                        <h4>Shipping Address</h4>
                        <div class="form-group">
                            <label>Address 1</label>
                            <input type="text" class="form-control" name="shipping[address1]" required="true">
                        </div>
                        <div class="form-group">
                            <label>Address 2</label>
                            <input type="text" class="form-control" name="shipping[address2]">
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" name="shipping[city]" >
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" class="form-control" name="shipping[state]" >
                        </div>
                        <div class="form-group">
                            <label>Zipcode</label>
                            <input type="number" class="form-control" name="shipping[zipcode]" >
                        </div>
                      </div>
                      <div class="col-md-3 col-md-offset-1">
                        <h4>Billing Address</h4>
                        <div class="form-group">
                            <label>Address 1</label>
                            <input type="text" class="form-control" name="billing[address1]" required="true">
                        </div>
                        <div class="form-group">
                            <label>Address 2</label>
                            <input type="text" class="form-control" name="billing[address2]">
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" name="billing[city]" >
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" class="form-control" name="billing[state]" >
                        </div>
                        <div class="form-group">
                            <label>Zipcode</label>
                            <input type="number" class="form-control" name="billing[zipcode]" >
                        </div>
                      </div>
                      <div class="col-md-2 col-md-offset-1">
                        <button class="btn btn-success" type="submit">Continue</button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


