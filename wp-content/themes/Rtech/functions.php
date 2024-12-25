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



function event_widgets_init()
{

    register_sidebar(array(
        'name' => __('Blog Sidebar', 'event'),
        'id' => 'blog-sidebar',
        'description' => __('Widgets in this area will be shown on blog sidebar', 'event'),
        'before_widget' => '<div id="%1$s" class="sidebar__widget mb-30 %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="sidebar__widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer Widget 01', 'event'),
        'id' => 'footer-widget-1',
        'description' => __('Widgets in this area will be shown on footer widget 01 column.', 'event'),
        'before_widget' => '<div id="%1$s" class="tp-footer-widget footer-cols-1 pr-75 tp-footer-widget-cutm-pdg-4 %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="tp-footer-title tp-footer-4-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Footer Widget 02', 'event'),
        'id' => 'footer-widget-2',
        'description' => __('Widgets in this area will be shown on footer widget 01 column.', 'event'),
        'before_widget' => '<div id="%1$s" class="tp-footer-widget tp-footer-4-widget footer-cols-2 %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="tp-footer-title tp-footer-4-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Footer Widget 03', 'event'),
        'id' => 'footer-widget-3',
        'description' => __('Widgets in this area will be shown on footer widget 01 column.', 'event'),
        'before_widget' => '<div id="%1$s" class="tp-footer-widget tp-footer-4-widget footer-cols-3 pl-50 tp-footer-widget-cutm-pdg-3 %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="tp-footer-title tp-footer-4-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Footer Widget 04', 'event'),
        'id' => 'footer-widget-4',
        'description' => __('Widgets in this area will be shown on footer widget 01 column.', 'event'),
        'before_widget' => '<div id="%1$s" class="tp-footer-widget footer-cols-4 %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="tp-footer-title tp-footer-4-title">',
        'after_title' => '</h4>',
    ));

}
add_action('widgets_init', 'event_widgets_init');










include_once 'inc/common/scripts.php';
include_once 'inc/template-function.php';
include_once 'inc/vtech-kirki.php';
include_once 'inc/nav-walker.php';
