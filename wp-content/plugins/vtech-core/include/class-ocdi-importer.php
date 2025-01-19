<?php
/**
 * 
 * Demo Imports
 */

function tp_ocdi_import_files() {
    
    return array(
      array(
        'import_file_name'           => 'Home Main',
        'categories'                 => array( 'Business' ),
        'local_import_file'             => trailingslashit( get_template_directory() ) .'sample-data/contents-demo.xml',
        'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'sample-data/widget-settings.json',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'sample-data/customizer-data.dat',
        'import_preview_image_url' => plugins_url( 'assets/img/demo/demo-1.jpg', dirname(__FILE__) ),
        'preview_url'                => 'https://wp.hixstudio.net/harry/',
      ),
      array(
        'import_file_name'           => 'Home Lawyer',
        'categories'                 => array( 'Lawyer' ),
        'local_import_file'             => trailingslashit( get_template_directory() ) .'sample-data/contents-demo.xml',
        'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'sample-data/widget-settings.json',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'sample-data/customizer-data.dat',
        'import_preview_image_url' => plugins_url( 'assets/img/demo/demo-2.jpg', dirname(__FILE__) ),
        'preview_url'                => 'https://wp.hixstudio.net/harry/home-lawyer/',
      ),
      array(
        'import_file_name'           => 'Home Freelancer',
        'categories'                 => array( 'Portfolio' ),
        'local_import_file'             => trailingslashit( get_template_directory() ) .'sample-data/contents-demo.xml',
        'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'sample-data/widget-settings.json',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'sample-data/customizer-data.dat',
        'import_preview_image_url' => plugins_url( 'assets/img/demo/demo-3.jpg', dirname(__FILE__) ),
        'preview_url'                => 'https://wp.hixstudio.net/harry/home-freelancer/',
      ),
      array(
        'import_file_name'           => 'Home Agency',
        'categories'                 => array( 'Agency' ),
        'local_import_file'             => trailingslashit( get_template_directory() ) .'sample-data/contents-demo.xml',
        'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'sample-data/widget-settings.json',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'sample-data/customizer-data.dat',
        'import_preview_image_url' => plugins_url( 'assets/img/demo/demo-4.jpg', dirname(__FILE__) ),
        'preview_url'                => 'https://wp.hixstudio.net/harry/home-agency/',
      ),
      array(
        'import_file_name'           => 'Home Photographer',
        'categories'                 => array( 'Portfolio' ),
        'local_import_file'             => trailingslashit( get_template_directory() ) .'sample-data/contents-demo.xml',
        'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'sample-data/widget-settings.json',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'sample-data/customizer-data.dat',
        'import_preview_image_url' => plugins_url( 'assets/img/demo/demo-5.jpg', dirname(__FILE__) ),
        'preview_url'                => 'https://wp.hixstudio.net/harry/home-photographer/',
      ),
      array(
        'import_file_name'           => 'Home Startup',
        'categories'                 => array( 'Agency' ),
        'local_import_file'             => trailingslashit( get_template_directory() ) .'sample-data/contents-demo.xml',
        'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'sample-data/widget-settings.json',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'sample-data/customizer-data.dat',
        'import_preview_image_url' => plugins_url( 'assets/img/demo/demo-6.jpg', dirname(__FILE__) ),
        'preview_url'                => 'https://wp.hixstudio.net/harry/home-startup/',
      ),
      array(
        'import_file_name'           => 'Home Creative',
        'categories'                 => array( 'Agency' ),
        'local_import_file'             => trailingslashit( get_template_directory() ) .'sample-data/contents-demo.xml',
        'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'sample-data/widget-settings.json',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'sample-data/customizer-data.dat',
        'import_preview_image_url' => plugins_url( 'assets/img/demo/demo-7.jpg', dirname(__FILE__) ),
        'preview_url'                => 'https://wp.hixstudio.net/harry/home-creative/',
      ),
      array(
        'import_file_name'           => 'Home Portfolio',
        'categories'                 => array( 'Portfolio' ),
        'local_import_file'             => trailingslashit( get_template_directory() ) .'sample-data/contents-demo.xml',
        'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'sample-data/widget-settings.json',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'sample-data/customizer-data.dat',
        'import_preview_image_url' => plugins_url( 'assets/img/demo/demo-8.jpg', dirname(__FILE__) ),
        'preview_url'                => 'https://wp.hixstudio.net/harry/home-portfolio/',
      ),
      array(
        'import_file_name'           => 'Home Architechture',
        'categories'                 => array( 'Business' ),
        'local_import_file'             => trailingslashit( get_template_directory() ) .'sample-data/contents-demo.xml',
        'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'sample-data/widget-settings.json',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'sample-data/customizer-data.dat',
        'import_preview_image_url' => plugins_url( 'assets/img/demo/demo-9.jpg', dirname(__FILE__) ),
        'preview_url'                => 'https://wp.hixstudio.net/harry/home-architechture/',
      ),
      array(
        'import_file_name'           => 'Home Vertical',
        'categories'                 => array( 'Shop' ),
        'local_import_file'             => trailingslashit( get_template_directory() ) .'sample-data/contents-demo.xml',
        'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'sample-data/widget-settings.json',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'sample-data/customizer-data.dat',
        'import_preview_image_url' => plugins_url( 'assets/img/demo/demo-10.jpg', dirname(__FILE__) ),
        'preview_url'                => 'https://wp.hixstudio.net/harry/home-vertical/',
      ),
      array(
        'import_file_name'           => 'Home Politician',
        'categories'                 => array( 'Politician' ),
        'local_import_file'             => trailingslashit( get_template_directory() ) .'sample-data/contents-demo.xml',
        'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'sample-data/widget-settings.json',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'sample-data/customizer-data.dat',
        'import_preview_image_url' => plugins_url( 'assets/img/demo/demo-11.png', dirname(__FILE__) ),
        'preview_url'                => 'https://wp.hixstudio.net/harry/home-politician/',
      ),
      array(
        'import_file_name'           => 'Home Shop',
        'categories'                 => array( 'Shop' ),
        'local_import_file'             => trailingslashit( get_template_directory() ) .'sample-data/contents-demo.xml',
        'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'sample-data/widget-settings.json',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'sample-data/customizer-data.dat',
        'import_preview_image_url' => plugins_url( 'assets/img/demo/demo-12.jpg', dirname(__FILE__) ),
        'preview_url'                => 'https://wp.hixstudio.net/harry/minimal-shop/',
      ),
      array(
        'import_file_name'           => 'Home Swiper Slider',
        'categories'                 => array( 'Agency' ),
        'local_import_file'             => trailingslashit( get_template_directory() ) .'sample-data/contents-demo.xml',
        'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'sample-data/widget-settings.json',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'sample-data/customizer-data.dat',
        'import_preview_image_url' => plugins_url( 'assets/img/demo/demo-13.jpg', dirname(__FILE__) ),
        'preview_url'                => 'https://wp.hixstudio.net/harry/swiper-slider/',
      ),
    );
}
add_filter( 'ocdi/import_files', 'tp_ocdi_import_files' );


// after demo imports
function tp_ocdi_after_import_setup( $demo ) {
    $front_page_id = "";
    $blog_page_id = "";
    if( "Home Main" == $demo['import_file_name'] ){
        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title( 'Home' );
        $blog_page_id  = get_page_by_title( 'Blog' );
    }else if( "Home Lawyer" == $demo['import_file_name'] ){
        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title( 'Home Lawyer' );
        $blog_page_id  = get_page_by_title( 'Blog' );
    }
    else if( "Home Freelancer" == $demo['import_file_name'] ){
        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title( 'Home Freelancer' );
        $blog_page_id  = get_page_by_title( 'Blog' );
    }
    else if( "Home Agency" == $demo['import_file_name'] ){
        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title( 'Home Agency' );
        $blog_page_id  = get_page_by_title( 'Blog' );
    }
    else if( "Home Photographer" == $demo['import_file_name'] ){
        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title( 'Home Photographer' );
        $blog_page_id  = get_page_by_title( 'Blog' );
    }
    else if( "Home Startup" == $demo['import_file_name'] ){
        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title( 'Home Startup' );
        $blog_page_id  = get_page_by_title( 'Blog' );
    }
    else if( "Home Creative" == $demo['import_file_name'] ){
        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title( 'Home Creative' );
        $blog_page_id  = get_page_by_title( 'Blog' );
    }
    else if( "Home Portfolio" == $demo['import_file_name'] ){
        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title( 'Home Portfolio' );
        $blog_page_id  = get_page_by_title( 'Blog' );
    }
    else if( "Home Architechture" == $demo['import_file_name'] ){
        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title( 'Home Architechture' );
        $blog_page_id  = get_page_by_title( 'Blog' );
    }
    else if( "Home Vertical" == $demo['import_file_name'] ){
        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title( 'Home Vertical' );
        $blog_page_id  = get_page_by_title( 'Blog' );
    }
    else if( "Home Politician" == $demo['import_file_name'] ){
        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title( 'Home Politician' );
        $blog_page_id  = get_page_by_title( 'Blog' );
    }
    else if( "Home Swiper Slider" == $demo['import_file_name'] ){
        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title( 'Swiper Slider' );
        $blog_page_id  = get_page_by_title( 'Blog' );
    }

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );


    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
 
    set_theme_mod( 'nav_menu_locations', [
            'main-menu' => $main_menu->term_id, // replace 'main-menu' here with the menu location identifier from register_nav_menu() function in your theme.
        ]
    );

    // woocommerce default settings reset
    if ( class_exists( 'woocommerce' ) ) {
        update_option( 'woocommerce_shop_page_id', '13' );
        update_option( 'woocommerce_cart_page_id', '14' );
        update_option( 'woocommerce_checkout_page_id', '15' );
        update_option( 'woocommerce_myaccount_page_id', '16' );
    }
 
}
add_action( 'ocdi/after_import', 'tp_ocdi_after_import_setup' );



function tp_ocdi_plugin_page_setup( $default_settings ) {
    $default_settings['parent_slug'] = 'themes.php';
    $default_settings['page_title']  = esc_html__( 'One Click Demo Import' , 'one-click-demo-import' );
    $default_settings['menu_title']  = esc_html__( 'Import Theme Demos' , 'one-click-demo-import' );
    $default_settings['capability']  = 'import';
    $default_settings['menu_slug']   = 'one-click-demo-import';
 
    return $default_settings;
}
add_filter( 'ocdi/plugin_page_setup', 'tp_ocdi_plugin_page_setup' );