<?php 

function vtech_theme_support()
{
    /**  thumbnail */
    add_theme_support('post-thumbnails');

    /** automatic feed link*/
    add_theme_support('automatic-feed-links');

    /** tag-title **/
    add_theme_support('title-tag');

    /** HTML5 support **/
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));

    /** refresh widgest **/
    add_theme_support('customize-selective-refresh-widgets');

    add_theme_support('post-formats', array(
        'image',
        'video',
        'audio',
        'gallery',
        'quote',
    ));

    register_nav_menus(array(
        'main-menu' => __('Main Menu', 'vtech'),
    ));

    remove_theme_support('widgets-block-editor');

    // add_theme_support('woocommerce');

    // add_theme_support( 'wc-product-gallery-lightbox' );
    // add_theme_support( 'wc-product-gallery-slider' );

    // Remove woocommerce defauly styles
    // add_filter( 'woocommerce_enqueue_styles', '__return_false' );

    // add_theme_support( 'woocommerce', array(
    //     'thumbnail_image_width' => 200,
    //     'gallery_thumbnail_image_width' => 200,
    // ) );
}

add_action('after_setup_theme', 'vtech_theme_support');













include_once 'inc/common/scripts.php';
include_once 'inc/template-function.php';
include_once 'inc/vtech-kirki.php';