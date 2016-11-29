@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                  <div class="row">
                      <div class="col-md-4">
                          <img src="{{ urldecode($product_api_response['image_url']) }}" alt="Avatar" style="width:300px; height: 360; margin:20px;">
                      </div>
                      <div class="col-md-4">
                          <h2>{{$product_api_response['name']}}</h2>
                          @php
                             $price = (float)str_replace(["$"], [""], $product_api_response['price']);
                              setlocale(LC_MONETARY, 'en_US.UTF-8');
                             $price = money_format('%.2n', $price);
                          @endphp
                          <p>From <a href="/sellers/{{$seller->id}}">{{ $seller->name }}</a></p>
                          <p>{{ $price }}</p>
                          <p>{{ $product_api_response['quantity'] }} left in stock</p>
                          <p>{{ $product_api_response['description'] }}</p>
                          <br/>
                          <form action="/order" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="product_id" value={{$product_detail->product_id}} />
                                <button type="submit" class="btn btn-success">
                                  <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                                  Add to Cart
                                </button>
                          </form>
                      </div>
                  </div> <!-- row -->
                  @if (Auth::check())
                    <div class="row">
                        <div class="col-md-4" style="margin:20px;">
                            Add Review
                            <form action="/sellers/{{$seller->id}}/products/{{$product_api_response['id']}}/reviews" method="post">
                                  {{ csrf_field() }}
                                  <div class="form-group">
                                      <label>Rating</label>
                                      <select name="stars" id="review-stars" class="form-control">
                                        <option {{($product_detail->review_stars == 0 ? "selected" : "")}}>-</option>
                                        <option {{($product_detail->review_stars == 5 ? "selected" : "")}}>5</option>
                                        <option {{($product_detail->review_stars == 4 ? "selected" : "")}}>4</option>
                                        <option {{($product_detail->review_stars == 3 ? "selected" : "")}}>3</option>
                                        <option {{($product_detail->review_stars == 2 ? "selected" : "")}}>2</option>
                                        <option {{($product_detail->review_stars == 1 ? "selected" : "")}}>1</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <textarea name="details" class="form-control" id="review-details" placeholder="Write a review">{{$product_detail->review_details}}
                                      </textarea>
                                  </div>
                                  <button type="submit" class="btn btn-default">Save</button>
                          </form>
                      </div> <!-- col-md-4 -->
                    </div> <!-- .row -->
                  @endif
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
