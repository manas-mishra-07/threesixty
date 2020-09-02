<?php

if (!defined('ABSPATH')) {
    exit;
}

class WF_CpnImpExpCsv_Exporter {

    public static function do_export($post_type = 'shop_coupon') {
        global $wpdb;

        $cpn_categories = !empty($_POST['cpn_categories']) ? $_POST['cpn_categories'] : array('fixed_cart', 'percent', 'fixed_product', 'percent_product');
        $export_limit = !empty($_POST['limit']) ? intval($_POST['limit']) : 999999999;
        $export_count = 0;
        $limit = 100;
        $current_offset = !empty($_POST['offset']) ? intval($_POST['offset']) : 0;
        $sortcolumn = !empty($_POST['sortcolumn']) ? $_POST['sortcolumn'] : 'ID';
        $delimiter = !empty($_POST['delimiter']) ? $_POST['delimiter'] : ',';

        $csv_columns = include( 'data/data-wf-post-columns-coupon.php' );
        $user_columns_name = !empty($_POST['columns_name']) ? $_POST['columns_name'] : $csv_columns;
        $export_columns = !empty($_POST['columns']) ? $_POST['columns'] : '';
        if ($limit > $export_limit)
            $limit = $export_limit;


        $wpdb->hide_errors();
        @set_time_limit(0);
        if (function_exists('apache_setenv'))
            @apache_setenv('no-gzip', 1);
        @ini_set('zlib.output_compression', 0);
        if(apply_filters('wt_order_export_ob_clean_enable_flag', TRUE)){
           @ob_clean();
        }


        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=woocommerce-coupon-export-' . date('Y_m_d_H_i_s', current_time('timestamp')) . '.csv');
        header('Pragma: no-cache');
        header('Expires: 0');

        $fp = fopen('php://output', 'w');


        $all_meta_pkeys = self::get_all_metakeys('shop_coupon');
        $all_meta_keys = $all_meta_pkeys;

        $found_coupon_meta = array();
        foreach ($all_meta_keys as $meta) {
            if (!$meta)
                continue;
            if (!in_array($meta, array_keys($csv_columns)) && substr((string) $meta, 0, 1) == '_')
                continue;

            if (in_array($meta, array_keys($csv_columns)))
                continue;
            $found_coupon_meta[] = $meta;
        }
        $found_coupon_meta = array_diff($found_coupon_meta, array_keys($csv_columns));
        $row = array();
        foreach ($csv_columns as $column => $value) {
            $temp_head = esc_attr($user_columns_name[$column]);
            if (!$export_columns || in_array($column, $export_columns))
                $row[] = $temp_head;
        }

        if (!$export_columns || in_array('meta', $export_columns)) {
            foreach ($found_coupon_meta as $coupon_meta) {
                $row[] = 'meta:' . self::format_data($coupon_meta);
            }
        }


        $row = array_map('WF_CpnImpExpCsv_Exporter::wrap_column', $row);
        fwrite($fp, implode($delimiter, $row) . "\n");
        unset($row);

        while ($export_count < $export_limit) {
            $coupon_args = apply_filters('coupon_csv_product_export_args', array(
                'numberposts' => $limit,
                'post_status' => array('publish', 'pending', 'private', 'draft'),
                'post_type' => 'shop_coupon',
                'orderby' => $sortcolumn,
                'suppress_filters' => false,
                'order' => 'ASC',
                'offset' => $current_offset
                    ));


            $coupons = get_posts($coupon_args);
            if (!$coupons || is_wp_error($coupons))
                break;
            foreach ($coupons as $product) {
                foreach ($csv_columns as $column => $value) {
                    
                    if(is_array($product->$column)){
                        $product->$column = implode(',', $product->$column);
                    }
                    
                    if (!$export_columns || in_array($column, $export_columns)) {
                        if (isset($product->meta->$column)) {
                            $row[] = self::format_data($product->meta->$column);
                        } elseif (isset($product->$column) && !is_array($product->$column)) {
                            if ($column === 'post_title') {
                                $row[] = sanitize_text_field($product->$column);
                            } else {
                                $row[] = self::format_data($product->$column);
                            }
                        } else {
                            $row[] = '';
                        }
                    }
                }

                if (!$export_columns || in_array('meta', $export_columns)) {
                    foreach ($found_coupon_meta as $product_meta) {
                        if (isset($product->meta->$product_meta)) {
                            $row[] = self::format_data($product->meta->$product_meta);
                        } else {
                            $row[] = '';
                        }
                    }
                }
                $row = array_map('WF_CpnImpExpCsv_Exporter::wrap_column', $row);
                fwrite($fp, implode($delimiter, $row) . "\n");
                unset($row);
            }

            $current_offset += $limit;
            $export_count += $limit;
            unset($coupons);
        }

        fclose($fp);
        exit;
    }

    public static function format_data($data) {
        if (!is_array($data))
            ;
        $data = (string) urldecode($data);
        $enc = mb_detect_encoding($data, 'UTF-8, ISO-8859-1', true);
        $data = ( $enc == 'UTF-8' ) ? $data : utf8_encode($data);
        return $data;
    }

    /**
     * Wrap a column in quotes for the CSV
     * @param  string data to wrap
     * @return string wrapped data
     */
    public static function wrap_column($data) {
        return '"' . str_replace('"', '""', $data) . '"';
    }

    /**
     * Get a list of all the meta keys for a post type. This includes all public, private,
     * used, no-longer used etc. They will be sorted once fetched.
     */
    public static function get_all_metakeys($post_type = 'shop_coupon') {
        global $wpdb;

        $meta = $wpdb->get_col($wpdb->prepare(
                        "SELECT DISTINCT pm.meta_key
            FROM {$wpdb->postmeta} AS pm
            LEFT JOIN {$wpdb->posts} AS p ON p.ID = pm.post_id
            WHERE p.post_type = %s
            AND p.post_status IN ( 'publish', 'pending', 'private', 'draft' )", $post_type
                ));

        sort($meta);

        return $meta;
    }

}