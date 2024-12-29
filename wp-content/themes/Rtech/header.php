<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

 
    <?php get_template_part('template-parts/offcanvas/offcanvas-1');?>
    <?php do_action('multi_header_variation', 'vtech_header_style_multi');?>
    <?php do_action('breadcrumb_header_before');?>



    <?php 