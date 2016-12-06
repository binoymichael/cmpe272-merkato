
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));

// const app = new Vue({
//     el: '#app'
// });

var products = [];

function urldecode(url) {
  return decodeURIComponent(url.replace(/\+/g, ' '));
}

function formattedPrice(value) {
	return ("$" + (value/100).toFixed(2));
}

function addProduct(product) {
  var $column = $('<div>', {'class': 'col-md-3'});
  var $card = $('<div>', {'class': 'card'});
  var $floater = $('<span>', {'class': 'floater label label-default label-as-badge'})
                 .html(product.visited_count);
	var $image = $('<img>', {'class': 'img-responsive'})
				 .attr('src', urldecode(product.image_url))
				 .attr('alt', 'product image')
				 .attr('style', 'width:200px; height: 270px;')
	var $imageLink = $('<a>')
					.attr('href', '/sellers/' + product.seller_id + '/products/' + product.id)
					.html($image);
	var $card_container = $('<div>', {'class': 'card-container'});
	var $product_name = product.name.length <= 18 ? product.name : product.name.substring(0, 18) + ' ...';

  var $ratings = $('<div>', {'class': 'rating'});
  var filled_stars = parseInt(product.avg_rating / 1000);
  var blank_stars = 5 - filled_stars;
  while(filled_stars--) {
    $ratings.append('<span style="color: gold">\u2605</span>');
  }
  while(blank_stars--) {
    $ratings.append('<span style="color: #DCDCDC">\u2606</span>');
  }

	var $productLink = $('<a>')
					.attr('href', '/sellers/' + product.seller_id + '/products/' + product.id)
					.html('<h4><b>' + $product_name + '</b></h4>');
	var $bottomRow = $('<div>')
	var $priceContainer = $('<p class="pull-left">').html('<b>' + formattedPrice(product.price) + '</b>');
	var $sellerContainer = $('<p class="pull-right">').html('From ');
	var $sellerLink = $('<a>')
					  .attr('href', '/sellers/' + product.seller_id)
					  .html(product.seller_name);

	$sellerContainer.append($sellerLink);
	$card_container.append($productLink);
  $card_container.append($ratings);
	$bottomRow.append($priceContainer);
	$bottomRow.append($sellerContainer);
	$card_container.append($bottomRow);
	$card.append($imageLink);
  $card.prepend($floater);
	$card.append($card_container);
	var $homePanel = $('#home-panel');
	if ($('#home-spinner').length) {
		$homePanel.html('');
	}


  $column.append($card);
	$homePanel.append($column);
}

function getProductsFor(seller_id) {
	$.get('/products?seller_id=' + seller_id, function(response) {
		products = products.concat(response.products);
		_.each(response.products, addProduct);
	});
}

function getProducts(seller_ids) {
  _.each(seller_ids, function(seller_id) {
    getProductsFor(seller_id);
  });
}

function filterProducts() {
	var searchString = $searchBox.val();
	var filtered_products;
	if (searchString === "") {
		filtered_products = products;
	} else {
		filtered_products = _.filter(products, function(product) {
			return (product.name + product.seller_name).match(new RegExp(searchString, "i"));
		});
	}

	var sortOption = $sortBox.val();
	if (sortOption !== "") {
		if (sortOption === "priceAsc") {
			filtered_products = _.sortBy(filtered_products, "price");
		} else if (sortOption == "priceDesc") {
			filtered_products = _.reverse(_.sortBy(filtered_products, "price"));
    } else if (sortOption == "rating") {
			filtered_products = _.reverse(_.sortBy(filtered_products, "avg_rating"));
    } else if (sortOption == "popularity") {
			filtered_products = _.reverse(_.sortBy(filtered_products, "visited_count"));
    }
	}

	$('#home-panel').html('');
	_.each(filtered_products, addProduct);
}

if ($("#home-panel").length) {
  var seller_ids = _.split($('#home-panel').data('seller-ids'), ',');
	getProducts(seller_ids);
	var $searchBox = $('#home-search');
	$searchBox.keypress(function(event){
	    if (event.keyCode === 10 || event.keyCode === 13) 
	        event.preventDefault();
	});

	var t = null;
	$searchBox.keyup(function(){ 
        if (t) { 
            clearTimeout(t); 
        } 
        t = setTimeout(filterProducts, 500); 
    }); 

	var $sortBox = $('#home-sort');
	$sortBox.on('change', filterProducts);
}
