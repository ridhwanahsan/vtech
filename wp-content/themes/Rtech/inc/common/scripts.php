<?php
function vtech_enqueue_styles()
{
// Enqueue vendor styles
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/vendors/bootstrap.min.css', array(),
        null);
    wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/css/vendors/swiper-bundle.min.css', array(),
        null);
    wp_enqueue_style('aos', get_template_directory_uri() . '/assets/css/vendors/aos.css', array(), null);
    wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/assets/css/vendors/magnific-popup.css', array(),
        null);
    wp_enqueue_style('bootstrap-icons', get_template_directory_uri() .
        '/assets/fonts/bootstrap-icons/bootstrap-icons.min.css', array(), null);
    wp_enqueue_style('boxicons', get_template_directory_uri() . '/assets/fonts/boxicons/boxicons.min.css', array(),
        null);

// Enqueue main style
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.css', array(), null);
}
add_action('wp_enqueue_scripts', 'vtech_enqueue_styles');function vtech_enqueue_scripts()
{
    // Enqueue vendor scripts
    wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/vendors/jquery-3.7.1.min.js', array(), null, true);
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/vendors/bootstrap.bundle.min.js', array('jquery'), null, true);
    wp_enqueue_script('masonry', get_template_directory_uri() . '/assets/js/vendors/masonry.pkgd.min.js', array(), null, true);
    wp_script_add_data('masonry', array('integrity', 'crossorigin'), array(
        'sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D',
        'anonymous',
    ));
    wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/js/vendors/swiper-bundle.min.js', array(), null, true);
    wp_enqueue_script('aos', get_template_directory_uri() . '/assets/js/vendors/aos.js', array(), null, true);
    wp_enqueue_script('wow', get_template_directory_uri() . '/assets/js/vendors/wow.min.js', array(), null, true);
    wp_enqueue_script('appear', get_template_directory_uri() . '/assets/js/vendors/jquery.appear.js', array('jquery'), null, true);
    wp_enqueue_script('odometer', get_template_directory_uri() . '/assets/js/vendors/jquery.odometer.min.js', array('jquery'), null, true);
    wp_enqueue_script('headhesive', get_template_directory_uri() . '/assets/js/vendors/headhesive.min.js', array(), null, true);
    wp_enqueue_script('smart-stick-nav', get_template_directory_uri() . '/assets/js/vendors/smart-stick-nav.js', array(), null, true);
    wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/assets/js/vendors/jquery.magnific-popup.min.js', array('jquery'), null, true);
    wp_enqueue_script('gsap', get_template_directory_uri() . '/assets/js/vendors/gsap.min.js', array(), null, true);
    wp_enqueue_script('scroll-to-plugin', get_template_directory_uri() . '/assets/js/vendors/ScrollToPlugin.min.js', array('gsap'), null, true);
    wp_enqueue_script('scroll-trigger', get_template_directory_uri() . '/assets/js/vendors/ScrollTrigger.min.js', array('gsap'), null, true);

    // Enqueue theme scripts
    wp_enqueue_script('gsap-custom', get_template_directory_uri() . '/assets/js/gsap-custom.js', array('gsap', 'scroll-trigger'), null, true);
    wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/main.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'vtech_enqueue_scripts');