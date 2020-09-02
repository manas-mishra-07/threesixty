<?php
if (!defined('ABSPATH')) {
    exit;
}
$buyx_getx_adjustment = null;
?>
<!-- Buy x Get X Start-->
<div class="add_buyx_getx_range" style="display:none;">
    <?php
    $buyx_getx_index = "{i}";
    include 'buy-x-get-x-range.php';
    ?>
</div>
<div class="wdr_buy_x_get_x_discount" style="display: none;">
    <div class="buyx_getx_range_group awdr_bogo_main">
        <?php
        $buyx_getx_index = 1;
        if (isset($get_buyx_getx_adjustments) && !empty($get_buyx_getx_adjustments)) {

            foreach ($get_buyx_getx_adjustments as $buyx_getx_adjustment) {
                include 'buy-x-get-x-range.php';
                $buyx_getx_index++;
            }
        } else {
            include 'buy-x-get-x-range.php';
        }
        ?>
    </div>
    <div class="add-condition-and-filters awdr-discount-add-row hide_getx_recursive" style="<?php echo (isset($buyx_getx_adjustment->recursive) && !empty($buyx_getx_adjustment->recursive)) ? 'display:none' : ''; ?>">
        <button type="button" class="button add_discount_elements"
                data-discount-method="add_buyx_getx_range"
                data-append="buyx_getx_range_setter"
                data-next-starting-value=".buyx_getx_individual_range"
        ><?php _e('Add Range', WDR_PRO_TEXT_DOMAIN) ?></button>
    </div>
</div>
<!-- Buy x Get X End-->