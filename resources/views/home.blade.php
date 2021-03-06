@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form class="form-inline">
                        <div class="input-group">
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

                <div class="panel-body">
                  <div id="home-panel" class="col-md-12" data-seller-ids={{$seller_ids}}>
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
</div>
@endsection

