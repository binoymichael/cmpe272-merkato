@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form class="form-inline">
                        <label>{{ $seller->name }} products</label>
                        <div class="input-group" style="margin-left: 20px;">
                            <input type="text" class="form-control" id="home-search" placeholder="Search">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="pull-right">
                            <label>Sort By  </label>
                            <select id="home-sort" class="form-control">
                              <option value="">-</option>
                              <option value="priceAsc">Price (Low to High)</option>
                              <option value="priceDesc">Price (High to Low)</option>
                              <option value="rating">Avg Ratings</option>
                              <option value="popularity">Popularity (on Merkato)</option>
                              <option value="popularitySeller">Popularity (on Seller Website)</option>
                            </select>
                        </div>
                    </form>
                </div>

                <div id="home-panel" class="panel-body" data-seller-ids={{$seller_ids}}>
                    <div id="home-spinner" class="spinner pull-left">
                      <div class="bounce1"></div>
                      <div class="bounce2"></div>
                      <div class="bounce3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
