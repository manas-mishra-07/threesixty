<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<style>
    .chart-options select {
        vertical-align: inherit;
    }

    .chart-options .chart-period-start,
    .chart-options .chart-period-end {
        padding: 4px 8px;
    }

    .chart-tooltip {
        position: absolute;
    }

    .chart-placeholder {
        margin-right: 50px;
        height: 400px;
    }

    .chart-placeholder.loading:after {
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, .6);
        content: '';
    }
</style>
<br>
<div id="wpbody-content" class="awdr-container">
    <form method="post" name="wdr-statistics" class="chart-options">
        <div class="wdr-rule-statistics">
            <div class="statistics_date_range">
                <select name="period" class="chart-period" style="height: 33px">
                    <option value="this_week"><?php _e('This Week', WDR_TEXT_DOMAIN); ?></option>
                    <option value="this_month"><?php _e('This Month', WDR_TEXT_DOMAIN); ?></option>
                    <option value="custom"><?php _e('Custom Range', WDR_TEXT_DOMAIN); ?></option>
                </select>
            </div>
            <div class="wdr-dateandtime-value">
                <input type="text"
                       name="from"
                       class="wdr-condition-date wdr-title chart-period-start" data-class="start_dateonly"
                       placeholder="<?php _e('From: yyyy/mm/dd', WDR_TEXT_DOMAIN); ?>" data-field="date"
                       autocomplete="off"
                       id="rule_datetime_from" value="<?php if (isset($date[0]) && !empty($date[0])) {
                    echo $date[0];
                } ?>" style="height: 34px;">
                <!--<span class="wdr_desc_text"><?php /*_e('Vaild from', WDR_TEXT_DOMAIN); */ ?></span>-->
            </div>
            <div class="wdr-dateandtime-value">
                <input type="text"
                       name="to"
                       class="wdr-condition-date wdr-title chart-period-end" data-class="end_dateonly"
                       placeholder="<?php _e('To: yyyy/mm/dd', WDR_TEXT_DOMAIN); ?>"
                       data-field="date" autocomplete="off"
                       id="rule_datetime_to" value="<?php if (isset($date[1]) && !empty($date[1])) {
                    echo $date[1];
                } ?>" style="height: 34px;">
                <!--<span class="wdr_desc_text"><?php /*_e('Vaild to', WDR_TEXT_DOMAIN); */ ?></span>-->
            </div>
            <div class="">
                <select name="type" class="chart-type" style="height: 33px">
                    <?php foreach ( $charts as $group => $charts_by_group ): ?>
                        <optgroup label="<?php echo $group ?>">
                            <?php foreach ( $charts_by_group as $key => $name ): ?>
                                <option value="<?php echo $key ?>"><?php echo $name ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="">
                <button type="submit" class="btn btn-success"><?php _e('Update Chart', WDR_TEXT_DOMAIN); ?></button>
            </div>
        </div>
    </form>
    <br/>
    <div id="chart-container"></div>
    <div class="clear"></div>
</div>