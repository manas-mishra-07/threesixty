/* global jQuery, ajaxurl, wdr_data */
(function ($) {
    $(document).ready(function () {

        $( ".awdr-product-discount-type" ).on( "advanced_woo_discount_rules_on_change_adjustment_type", function ( e, value ) {
            var data_placement = $(this).data('placement');
            if(value == 'wdr_buy_x_get_x_discount'){
                $('.' + data_placement).find('.buyx_getx_range_group').addClass('buyx_getx_range_setter').attr('id', 'bulk_adjustment_sortable');
                $('.awdr-filter-content').html(wdr_data.localization_data.bogo_buyx_getx_filter_description);
                $('.awdr-discount-heading').html(wdr_data.localization_data.bogo_buyx_getx_discount_heading);
                $('.awdr-discount-content').html(wdr_data.localization_data.bogo_buyx_getx_discount_content);
                $('.awdr-rules-content').html(wdr_data.localization_data.bogo_buyx_getx_rules_description);
            }
            if(value == "wdr_buy_x_get_y_discount"){
                $('.' + data_placement).find('.awdr_buyx_gety_range_group').addClass('awdr_buyx_gety_range_setter').attr('id', 'bulk_adjustment_sortable');
                $('.awdr-filter-heading').html(wdr_data.localization_data.bogo_buyx_gety_filter_heading);
                $('.awdr-filter-content').html(wdr_data.localization_data.bogo_buyx_gety_filter_description);
                $('.awdr-discount-heading').html(wdr_data.localization_data.bogo_buyx_gety_discount_heading);
                $('.awdr-discount-content').html(wdr_data.localization_data.bogo_buyx_gety_discount_content);
                $('.awdr-rules-content').html(wdr_data.localization_data.bogo_buyx_gety_rules_description);
                let wdr_buy_x_get_y_type = $('.select_bxgy_type option:selected').val();
                if(wdr_buy_x_get_y_type == 0){
                    $('.bxgy_type_selected').hide();
                    $('.bxgy_category').hide();
                    $('.bxgy_product').hide();
                }
                $(".select_bxgy_type").trigger('change');
            }
            $('#bulk_adjustment_sortable').sortable();
            $("#bulk_adjustment_sortable").disableSelection();
            if(value == 'wdr_free_shipping'){
                $('.awdr-hidden-new-rule').fadeIn(500);
                $('.awdr-general-settings-section').fadeIn(500);
                $("button.wdr_save_stay, button.wdr_save_close").attr("disabled", false).css("cursor", "pointer");
                $('.' + data_placement).html('');
                $('.awdr-discount-container').hide();
            }
        });
        $(".awdr-product-discount-type").trigger('change');
        $(".buyx_gety_discount_select").trigger('change');
        $(document).on('change', '.select_bxgy_type', function () {
            $('.awdr-discount-content').html(wdr_data.localization_data.bogo_buyx_gety_discount_content);
            var adjustment_mode = $('input[name="buyx_gety_adjustments[mode]"]:checked').val();
            if($(this).val() == 'bxgy_product'){
                if(adjustment_mode === undefined){
                    $("input[value='auto_add']").prop("checked", true);
                }
                $('.bxgy-icon').removeClass('awdr-bygy-all');
                $('.bxgy-icon').removeClass('awdr-bygy-cat-products');
                $('.bxgy-icon').addClass('awdr-bygy-cat-products');
                $('.auto_add').show();
                $('.bxgy_product').show();
                $('.bxgy_category').hide();
                $('.bxgy_type_selected').show();
                $('.awdr-example').show();
            }else if($(this).val() == 'bxgy_category'){
                $('.awdr-discount-content').html(wdr_data.localization_data.bogo_buyx_gety_discount_content_for_cat_and_all);
                $('.auto_add').hide();
                if(adjustment_mode === undefined || adjustment_mode == 'auto_add'){
                    $("input[value='cheapest']").prop("checked", true);
                }
                $('.bxgy-icon').removeClass('awdr-bygy-all');
                $('.bxgy-icon').removeClass('awdr-bygy-cat-products');
                $('.bxgy-icon').addClass('awdr-bygy-cat-products');
                $('.bxgy_product').hide();
                $('.bxgy_category').show();
                $('.bxgy_type_selected').show();
                $('.awdr-example').show();
            }else if($(this).val() == 'bxgy_all'){
                $('.awdr-discount-content').html(wdr_data.localization_data.bogo_buyx_gety_discount_content_for_cat_and_all);
                $('.auto_add').hide();
                if(adjustment_mode === undefined || adjustment_mode == 'auto_add'){
                    $("input[value='cheapest']").prop("checked", true);
                }
                $('.bxgy-icon').removeClass('awdr-bygy-cat-products');
                $('.bxgy-icon').removeClass('awdr-bygy-all');
                $('.bxgy-icon').addClass('awdr-bygy-all');
                $('.bxgy_type_selected').show();
                $('.bxgy_product').hide();
                $('.bxgy_category').hide();
                $('.awdr-example').show();
            }else{
                $('.awdr-example').hide();
                $('.bxgy_type_selected').hide();
                $('.bxgy_category').hide();
                $('.bxgy_product').hide();
            }
        });

        $(document).on("click", "#validate_licence_key", function() {
            var licence_key = $("#awdr_licence_key").val();
            var data = {
                action: 'awdr_validate_licence_key',
                licence_key: licence_key,
            };
            $("#validate_licence_key").val(woo_discount_pro_localization.validating_please_wait);
            $.ajax({
                url: ajaxurl,
                data: data,
                type: 'POST',
                success: function (response) {
                    if(response.success == true){
                        if(response.data.message !== undefined){
                            $('.validate_licence_key_status').html(response.data.message);
                        }
                    }
                    $("#validate_licence_key").val(woo_discount_pro_localization.validate);
                },
                error: function (response) {
                    $("#validate_licence_key").val(woo_discount_pro_localization.validate);
                },
                complete: function (response) {
                    $("#validate_licence_key").val(woo_discount_pro_localization.validate);
                },
            });
        });
        /**
         * condition
         * show otr hide product combination 'to' filed
         */
        $(document).on('change', '.combination_operator', function () {
            if ($(this).val() == 'in_range') {
                $('.product_combination_to').show();
                $('.product_combination_from_placeholder').attr("placeholder", "From");
            } else {
                $('.product_combination_to').hide();
                $('.product_combination_from_placeholder').attr("placeholder", "Quantity");
            }
        });
        /**
         * condition
         * show otr hide Category combination 'to' filed
         */
        $(document).on('change', '.cat_combination_operator', function () {
            if ($(this).val() == 'in_range') {
                $('.cat_combination_to').show();
                $('.cat_combination_from_placeholder').attr("placeholder", "From");
            } else {
                $('.cat_combination_to').hide();
                $('.cat_combination_from_placeholder').attr("placeholder", "Value");
            }
        });
    });
})(jQuery);