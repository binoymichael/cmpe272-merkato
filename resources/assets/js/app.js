
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

function urldecode(url) {
  return decodeURIComponent(url.replace(/\+/g, ' '));
}

function addProduct(product) {
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
	var $sellerContainer = $('<p>').html('From ');
	var $sellerLink = $('<a>')
					  .attr('href', '/sellers/' + product.seller_id)
					  .html(product.seller_name);

	$sellerContainer.append($sellerLink);
	$card_container.append($productLink);
	$card_container.append($sellerContainer);
	$card.append($imageLink);
	$card.append($card_container);
	$('#home-panel').append($card);
}

function getProducts(seller_ids) {
	$.get('/products?seller_ids=' + seller_ids, function(response) {
		_.each(response.products, addProduct);
		if (response.seller_ids.length !== 0) {
			getProducts(_.join(response.seller_ids, ","));
		}
	});

}

if ($("#home-panel").length) {
	var seller_ids = $('#home-panel').data('seller-ids');
	getProducts(seller_ids);
}
