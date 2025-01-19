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




// harry_comment 
if (!function_exists('harry_comment')) {
    function harry_comment($comment, $args, $depth)
    {
        $GLOBAL['comment'] = $comment;
        extract($args, EXTR_SKIP);
        $args['reply_text'] = 'Reply';
        $replayClass = 'comment-depth-' . esc_attr($depth);
?>
        <li id="comment-<?php comment_ID(); ?>">

            <div class="box-feedbacks">
                <ul class="list-feedbacks">
                    <li>

                        <div class="item-feedback">
                            <!-- user img -->
                            <div class=" image-feedback">
                                <?php print get_avatar($comment, 102, null, null, ['class' => []]); ?>
                            </div>
                            <div class="info-feedback ">
                                <!-- user name -->
                                <div class="name-user">
                                    <?php print get_comment_author_link(); ?>
                                    <span></span><?php comment_time(get_option('date_format')); ?></span>
                                </div>
                                <!-- comment text -->
                                <div class="paragraph-rubik-r-sm neutral-2300 comment-text"><?php comment_text(); ?></div>
                                <!-- arro > -->
                                <div class=" reply">
                                    <span><?php echo esc_url(comment_reply_link(array_merge($args, ['depth' => $depth, 'max_depth' => $args['max_depth'], 'echo' => false]))); ?>

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                            <path d="M6.111 11.89A5.5 5.5 0 1 1 15.501 8 .75.75 0 0 0 17 8a7 7 0 1 0-11.95 4.95.75.75 0 0 0 1.06-1.06Z" />
                                            <path d="M8.232 6.232a2.5 2.5 0 0 0 0 3.536.75.75 0 1 1-1.06 1.06A4 4 0 1 1 14 8a.75.75 0 0 1-1.5 0 2.5 2.5 0 0 0-4.268-1.768Z" />
                                            <path d="M10.766 7.51a.75.75 0 0 0-1.37.365l-.492 6.861a.75.75 0 0 0 1.204.65l1.043-.799.985 3.678a.75.75 0 0 0 1.45-.388l-.978-3.646 1.292.204a.75.75 0 0 0 .74-1.16l-3.874-5.764Z" />
                                        </svg>

                                    </span>


                                </div>
                            </div>

                    </li>
                </ul>
            </div>
    <?php
    }
}



include_once 'inc/common/scripts.php';
// include_once 'inc/common/post-project.php';
include_once 'inc/template-function.php';
include_once 'inc/add_plugin.php';
include_once 'inc/class-tgm-plugin-activation.php';

if (class_exists('Kirki')) {
    include_once 'inc/vtech-kirki.php';
} else {
    // Handle the case where Kirki is not available
    // For example, you can log an error or provide a fallback
}

include_once 'inc/nav-walker.php';
include_once 'inc/category-list.php';
include_once 'inc/post-tag.php';
include_once 'inc/recent-post.php';
include_once 'inc/footer-menu.php';
include_once 'inc/template-helper.php';
include_once 'inc/breadcrumb.php';
