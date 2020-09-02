<?php
function the_launcher_sanitize_checkbox($input){
    if($input == 1)
    {
        return 1;
    }
    else
    {
        return '';
    }
}

function the_launcher_sanitize_textarea($input){
        return wp_kses_post( force_balance_tags( $input ) );
}

function the_launcher_sanitize_year($input){
    $year_list = the_launcher_year_list();
    if(array_key_exists($input,$year_list))
        {
            return $input;
        }
        else
        {
            return '';
        }
}

function the_launcher_sanitize_month($input){
    $month_list = the_launcher_month();
    if(array_key_exists($input,$month_list))
        {
            return $input;
        }
        else
        {
            return '';
        }
}

function the_launcher_sanitize_day($input){
    $day_list = the_launcher_day();
    if(array_key_exists($input,$day_list))
        {
            return $input;
        }
        else
        {
            return '';
        }
}

function the_launcher_sanitize_attachment($input){
    $bg_attachment = array(
        'fixed'      => __('Fixed', 'the-launcher'),
        'scroll'     => __('Scroll', 'the-launcher'),
    );
    if(array_key_exists($input,$bg_attachment))
        {
            return $input;
        }
        else
        {
            return '';
        }
}

function the_launcher_sanitize_position($input){   
    $bg_position = array(
        'left'       => __('Left', 'the-launcher'),
        'center'     => __('Center', 'the-launcher'),
        'right'      => __('Right', 'the-launcher'),
    );
    if(array_key_exists($input,$bg_position))
        {
            return $input;
        }
        else
        {
            return '';
        }
}

function the_launcher_sanitize_repeat($input){
    $bg_repeat = array(
        'no-repeat'  => __('No Repeat', 'the-launcher'),
        'repeat'     => __('Tile', 'the-launcher'),
        'repeat-x'   => __('Tile Horizontally', 'the-launcher'),
        'repeat-y'   => __('Tile Vertically', 'the-launcher'),
    );
     if(array_key_exists($input,$bg_repeat))
        {
            return $input;
        }
        else
        {
            return '';
        }   

}