@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{$seller->name}} Products</div>
                <div class="panel-body">
                {{ json_encode($product) }}
                <br/>
                <br/>
                {{ json_encode($product_details) }}
                <br/>
                <br/>
                Add Review
                <form action="/sellers/{{$seller->id}}/products/{{$product_details['id']}}/reviews" method="post">
            	  {{ csrf_field() }}
				  <div class="form-group">
				  	  <label>Rating</label>
					  <select name="stars" id="review-stars" class="form-control">
						  <option {{($product->review_stars == 0 ? "selected" : "")}}>-</option>
						  <option {{($product->review_stars == 5 ? "selected" : "")}}>5</option>
						  <option {{($product->review_stars == 4 ? "selected" : "")}}>4</option>
						  <option {{($product->review_stars == 3 ? "selected" : "")}}>3</option>
						  <option {{($product->review_stars == 2 ? "selected" : "")}}>2</option>
						  <option {{($product->review_stars == 1 ? "selected" : "")}}>1</option>
					  </select>
				  </div>
				  <div class="form-group">
				    <textarea name="details" class="form-control" id="review-details" placeholder="Write a review">{{$product->review_details}}
				    </textarea>
				  </div>
				  <button type="submit" class="btn btn-default">Save</button>
				</form>
            </div>
        </div>
    </div>
</div>
@endsection
