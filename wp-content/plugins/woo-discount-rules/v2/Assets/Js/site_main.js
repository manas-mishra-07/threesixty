(function ($) {
    /**
     * refresh cart when payment method changed
     */
    $(document).on('change', 'input[name="payment_method"],input[name="billing_city"],input[name="billing_postcode"]', function () {
        refreshCart();
    });
    /**
     * refresh cart when Email changed
     */
    $(document).on('blur', 'input[name="billing_email"]', function () {
        refreshCart();
    });

    function refreshCart() {
        $('body').trigger('update_checkout');
    }

    $(document).ready(function ($) {
        function init_events() {
            if (awdr_params.enable_update_price_with_qty == 'show_dynamically') {
                jQuery('[name="quantity"]').on('change', function () {
                    var $qty = jQuery(this).val();
                    var $product_id = 0;
                    var $price_place = "";

                    if (jQuery('button[name="add-to-cart"]').length) {
                        $product_id = jQuery('button[name="add-to-cart"]').val();
                        var target = 'div.product p.price';
                        if(awdr_params.custom_target_simple_product != undefined){
                            if(awdr_params.custom_target_simple_product != ""){
                                target = awdr_params.custom_target_simple_product;
                            }
                        }
                        $price_place = jQuery(target).first();
                    } else if (jQuery('input[name="variation_id"]').length) {
                        $product_id = jQuery('input[name="variation_id"]').val();
                        var target = 'div.product .woocommerce-variation-price';
                        if(awdr_params.custom_target_variable_product != undefined){
                            if(awdr_params.custom_target_variable_product != ""){
                                target = awdr_params.custom_target_variable_product;
                            }
                        }
                        $price_place = jQuery(target);
                        if (!jQuery(target+' .price').length) {
                            $price_place.html("<div class='price'></div>");
                        }

                        $price_place = jQuery(target+' .price')
                    }
                    if (!$product_id || !$price_place || $product_id == 0) {
                        return;
                    }

                    var data = {
                        action: 'wdr_ajax',
                        method: 'get_price_html',
                        product_id: $product_id,
                        qty: $qty,
                    };
                    jQuery.ajax({
                        url: awdr_params.ajaxurl,
                        data: data,
                        type: 'POST',
                        success: function (response) {
                            if (response.price_html) {
                                $price_place.html(response.price_html)
                            }
                        },
                        error: function (response) {
                            $price_place.html("")
                        }
                    });

                });
                $( ".single_variation_wrap" ).on( "show_variation", function ( event, variation, purchasable ) {
                    $(this).closest('form').find('input[name="quantity"]').trigger('change');
                });
            }

        }

        if (awdr_params.js_init_trigger) {
            $(document).on(awdr_params.js_init_trigger, function () {
                init_events();
            });
        }
        init_events();
    });
})(jQuery);

