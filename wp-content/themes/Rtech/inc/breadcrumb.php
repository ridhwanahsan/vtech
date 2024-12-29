<?php

function vtech_breadcrumb(){
    global $post;  

    if ( is_front_page() && is_home() ) {
        $title = esc_html__( 'Home', 'vtech' );
    }
    elseif ( is_front_page() ) {
        $title = esc_html__( 'Front Page', 'vtech' );
    }
    elseif ( is_home() ) {
        if ( get_option( 'page_for_posts' ) ) {
            $title = get_the_title( get_option( 'page_for_posts') );
        }
    }
    elseif ( is_single() && 'post' == get_post_type() ) {
      $title = get_the_title();
    } 
    elseif ( is_single() && 'service' == get_post_type() ) {
      $title = get_the_title();
    } 
    elseif ( is_single() && 'product' == get_post_type() ) {
        $title = get_theme_mod( 'breadcrumb_product_details', __( 'Shop', 'vtech' ) );
    } 
    elseif ( is_search() ) {
        $title = esc_html__( 'Search Results for : ', 'vtech' ) . get_search_query();
    } 
    elseif ( is_404() ) {
        $title = esc_html__( 'Page not Found', 'vtech' );
    } 
    elseif ( is_archive() ) {
        $title = get_the_archive_title();
    } 
    else {
        $title = get_the_title();
    }

    $_id = get_the_ID();

    if ( is_single() && 'product' == get_post_type() ) { 
        $_id = $post->ID;
    } 
    elseif ( function_exists("is_shop") && is_shop()  ) { 
        $_id = wc_get_page_id('shop');
        
    } 
    elseif ( is_home() && get_option( 'page_for_posts' ) ) {
        $_id = get_option( 'page_for_posts' );
    }

    $breadcrumb_bg_img = get_theme_mod('breadcrumb_bg_img');
    $breadcrumb_shape_img = get_theme_mod('breadcrumb_shape_img');
    $breadcrumb_bg_color = get_theme_mod('breadcrumb_bg_color', '#f5f5f5');
    $breadcrumb_title_color = get_theme_mod('breadcrumb_title_color', '#ffffff');
    $breadcrumb_text_color = get_theme_mod('breadcrumb_text_color', '#ffffff');
    $breadcrumb_font_size = get_theme_mod('breadcrumb_font_size', '16px');
    
    // Check both Kirki switch and ACF breadcrumb switch
    // First check Kirki switch
    $kirki_breadcrumb_switch = get_theme_mod('kirki_breadcrumb_switch', true);
    
    // Only check manual switch if Kirki switch is enabled
    if($kirki_breadcrumb_switch == true) {
        $breadcrumb_switch = true;
        if(function_exists('get_field')) {
            $breadcrumb_switch = get_field('breadcrumb_switch', $_id);
            if($breadcrumb_switch === true) {
                $breadcrumb_switch = true;
            }
        }
        // Show breadcrumb if manual switch is also enabled
        if($breadcrumb_switch) :
        
        // Background style
        $bg_style = '';
        if($breadcrumb_shape_img) {
            $bg_style .= "background-image: url(" . esc_url($breadcrumb_shape_img) . ");";
        }
        $bg_style .= "background-color: " . esc_attr($breadcrumb_bg_color) . ";";
        $bg_style .= "background-repeat: no-repeat; background-position: top left; background-size: cover;";

        // Inner background style
        $inner_bg_style = '';
        if($breadcrumb_bg_img) {
            $inner_bg_style .= "background-image: url(" . esc_url($breadcrumb_bg_img) . ");";
        }
        $inner_bg_style .= "background-color: " . esc_attr($breadcrumb_bg_color) . ";";
        $inner_bg_style .= "background-repeat: no-repeat; background-position: top left; background-size: cover;";
    ?>

    <section class="box-faq-single-banner" style="<?php echo $bg_style; ?>">
       
        <div class="box-faq-single-banner-inner" style="<?php echo $inner_bg_style; ?>">
            <div class="container">
                <h1 class="display-ag-2xl" style="color: <?php echo esc_attr($breadcrumb_title_color); ?>; font-size: <?php echo esc_attr($breadcrumb_font_size); ?>;"><?php echo wp_kses_post($title); ?></h1>
                <div class="box-breadcrumb">
                    <ul class="breadcrumb" style="color: <?php echo esc_attr($breadcrumb_text_color); ?>;">
                        <li class="breadcrumb-item">
                            <a href="<?php echo esc_url(home_url('/')); ?>" style="color: <?php echo esc_attr($breadcrumb_text_color); ?>;"><?php esc_html_e('Home', 'vtech'); ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <span><?php echo wp_kses_post($title); ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <?php endif;
}
}

add_action( 'breadcrumb_header_before' , 'vtech_breadcrumb' );