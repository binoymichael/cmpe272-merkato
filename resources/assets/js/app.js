
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
	console.log('hello');
	var $card = $('<div>', {'class': 'card'});
	var $image = $('<img>')
				 .attr('src', urldecode(product.image_url))
				 .attr('alt', 'product image')
				 .attr('style', 'width:200px; height: 270px; margin-left:10px;')
	var $imageLink = $('<a>')
					.attr('href', '/sellers/' + product.seller_id + '/products/' + product.id)
					.html($image);
	var $card_container = $('<div>', {'class': 'card-container'});
	var $product_name = product.name.length <= 18 ? product.name : product.name.substring(0, 18) + ' ...';
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
	$bottomRow.append($priceContainer);
	$bottomRow.append($sellerContainer);
	$card_container.append($bottomRow);
	$card.append($imageLink);
	$card.append($card_container);

	// Random placement of product tiles
	// var $list = $("#home-panel .card");
	// var pos = Math.floor(Math.random() * ($list.length + 1)) - 1;
	// if(pos != -1){
	//   $list.eq(pos).after($card);
	// } else{
	//   $('#home-panel').append($card);
	// }

	var $homePanel = $('#home-panel');
	if ($('#home-spinner').length) {
		$homePanel.html('');
	}

	$homePanel.append($card);
}

function getProducts(seller_ids) {
	$.get('/products?seller_ids=' + seller_ids, function(response) {
		products = products.concat(response.products);
		_.each(response.products, addProduct);
		if (response.seller_ids.length !== 0) {
			getProducts(_.join(response.seller_ids, ","));
		}
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
		}
	}

	$('#home-panel').html('');
	console.log(filtered_products);
	_.each(filtered_products, addProduct);
}

if ($("#home-panel").length) {
	var seller_ids = $('#home-panel').data('seller-ids');
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
