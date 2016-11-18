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
                Add Review
                <form action="/sellers/{{$seller->id}}/products/{{$product['id']}}/reviews/" method="post">
            	  {{ csrf_field() }}
				  <div class="form-group">
				  	  <label>Rating</label>
					  <select name="stars" id="review-stars" class="form-control">
						  <option>1</option>
						  <option>2</option>
						  <option>3</option>
						  <option>4</option>
						  <option>5</option>
					  </select>
				  </div>
				  <div class="form-group">
				    <textarea name="details" class="form-control" id="review-details" placeholder="Write a review">
				    </textarea>
				  </div>
				  <button type="submit" class="btn btn-default">Save</button>
				</form>
            </div>
        </div>
    </div>
</div>
@endsection
