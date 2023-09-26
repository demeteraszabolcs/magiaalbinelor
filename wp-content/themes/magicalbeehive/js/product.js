( function( $ ) {

	$('#pa_packaging').select2({
		width: '100px',
		minimumResultsForSearch: 10
	});


	if ($('form.variations_form').length !== 0) {
  
		var form = $('form.variations_form');
		var variable_product_price = '';
		var prev_price;
		setInterval(function() {
				if ($('.single_variation_wrap span.price span.amount').length !== 0) {
						$('.woocommerce-variation-price .price').hide();
						variable_product_price = $('.single_variation_wrap span.price .woocommerce-Price-amount');
						variable_product_price.find('.woocommerce-Price-currencySymbol').remove();
						// variable_product_price = jQuery('.single_variation_wrap span.price').not(jQuery('.single_variation_wrap span.price').children()).text();
						if (prev_price !== variable_product_price) {
								 $('.entry-summary .price').html('<span class="woocommerce-Price-currencySymbol">€</span>' + variable_product_price.text());
								//  jQuery('h2.price-excl').html('<small>' + (parseFloat(variable_product_price.replace('.', '').replace(',', '.').replace('€', '')) * 100.0 / 121.0).toFixed(2).format() + '€ HTVA</small>');
								 prev_price = variable_product_price.text();
						 }
				}
		}, 500);
	}

})( jQuery );