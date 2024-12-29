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



function vtech_widgets_init()
{

    register_sidebar(array(
        'name' => __('Blog Sidebar', 'vtech'),
        'id' => 'blog-sidebar',
        'description' => __('Widgets in this area will be shown on blog sidebar', 'vtech'),
        'before_widget' => '<div id="%1$s" class="sidebar__widget mb-30 %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="sidebar__widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer Menu widget', 'vtech'),
        'id' => 'footer-menu-widget',
        'description' => __('Widgets in this area will be shown on footer menu widget column.', 'vtech'),
        'before_widget' => '<div id="%1$s" class="col-lg-3 col-md-6 footer01_menu %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="text-footer pb-1">',
        'after_title' => '</h4>',
    ));




  

}
add_action('widgets_init', 'vtech_widgets_init');










include_once 'inc/common/scripts.php';
include_once 'inc/template-function.php';
include_once 'inc/vtech-kirki.php';
include_once 'inc/nav-walker.php';
include_once 'inc/category-list.php';
include_once 'inc/post-tag.php';
include_once 'inc/recent-post.php';
include_once 'inc/footer-menu.php';
include_once 'inc/template-helper.php';
include_once 'inc/breadcrumb.php';


