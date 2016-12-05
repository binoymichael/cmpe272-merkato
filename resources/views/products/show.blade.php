@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                  <div class="row">
                      <div class="col-md-4 col-md-offset-2">
                          <img src="{{ urldecode($product_api_response['image_url']) }}" alt="Avatar" style="width:300px; height: 360; margin:20px;">
                      </div>
                      <div class="col-md-4">
                          <h2>{{$product_api_response['name']}}</h2>
                          @php
                             $price = (float)str_replace(["$"], [""], $product_api_response['price']);
                             $price = '$' . number_format($price, 2);
                             $quantity = (int)$product_api_response['quantity'];
                             $filled_stars = $review_details['avg_review'];
                             $blank_stars = 5 - $filled_stars;
                             $r = $review_details['reviews_count'];
                             $reviews = $review_details['reviews'];
                          @endphp
                          <div class="rating">
                            @while ($filled_stars--)
                              <span style="color: gold"> &#x2605</span>
                            @endwhile
                            @while ($blank_stars--)
                              <span style="color: #DCDCDC"> &#x2606</span>
                            @endwhile
                            @if ($r == 0)
                              (No reviews yet)
                            @elseif ($r == 1)
                              (1 review)
                            @else
                              ({{$r . " reviews" }})
                            @endif
                          </div>
                          <br/>
                          <p>From <a href="/sellers/{{$seller->id}}">{{ $seller->name }}</a></p>
                          <p>{{ $price }}</p>
                          <p class="{{ $quantity > 0 ? '' : 'nostock' }}">{{ $quantity }} left in stock</p>
                          <p>{{ $product_api_response['description'] }}</p>
                          <br/>
                          @if ($quantity > 0)
                          <form class="form-inline" action="/cart" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="product_id" value={{$product_detail->product_id}} />
                                <div class="form-group">
                                  <label>Quantity</label>
                                  <select name="quantity" class="form-control">
                                    @for ($i = 1; $i <= $quantity; $i++)
                                      <option>{{$i}}</option>
                                    @endfor
                                  </select>
                                </div>
                                <button type="submit" class="btn btn-success" style="margin-left: 10px">
                                  <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                                  Add to Cart
                                </button>
                          </form>
                          @endif
                      </div>
                  </div> <!-- row -->
                    <div class="row">
                        <div class="col-md-4 col-md-offset-2">
                          <div style="margin-left: 20px;">
                          <br/>
                          <p>User reviews</p>
                          @foreach ($reviews as $k => $v)
                            @php
                              $filled_stars = $v->review_stars;
                              $blank_stars = 5 - $filled_stars;
                            @endphp
                            @if ($k == (int)Auth::id())
                              @continue
                            @endif
                            <div class="rating">
                              @while ($filled_stars--)
                                <span style="color: gold"> &#x2605</span>
                              @endwhile
                              @while ($blank_stars--)
                                <span style="color: #DCDCDC"> &#x2606</span>
                              @endwhile
                              By {{ $v->user_name }}
                            </div>
                            @unless (empty($v->review_details))
                              {{ $v->review_details }}
                            @endunless
                          @endforeach
                          </div>
                        </div>
                        @if (Auth::check())


                          <script type="text/javascript">
                               function asd(a)
                              {
                                         if(a==1)
                                         {
                                 document.getElementById("form").style.display="none";
                                 document.getElementById("2").style.display="block";
                                 document.getElementById("1").style.display="none";
                               }
                                      else
                                      {
                                    document.getElementById("form").style.display="block";
                                    document.getElementById("1").style.display="block";
                                    document.getElementById("2").style.display="none";
                                  }
                                }
                            </script>

                        <button id = "1" style="display:none" class="btn btn-default" onclick="asd(1)">Hide Review</button>
                      <button id = "2" class="btn btn-default" onclick="asd(2)">Add Review</button>

                        <div id = "form" style="display:none" class="col-md-4">
                            <br/>
                            <form action="/sellers/{{$seller->id}}/products/{{$product_api_response['id']}}/reviews" method="post">
                                  {{ csrf_field() }}
                                  <div  class="form-group">
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
                      @endif
                    </div> <!-- .row -->
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
