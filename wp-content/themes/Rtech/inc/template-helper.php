<?php
function vtech_header_style_multi(){
  $header_style = function_exists('get_field') ? get_field('header_style') : NULL;

      if ($header_style == 'header-style-1') {
        get_template_part('template-parts/header/header-1');
    } else {
            get_template_part('template-parts/header/header-2');
        }
};
add_action('multi_header_variation','vtech_header_style_multi', 10);