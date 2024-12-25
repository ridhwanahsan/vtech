<?php 
function vtech_menu(){
    wp_nav_menu( 
        array( 
            'theme_location'  => 'main-menu',
            'menu_class'      => 'navbar-nav gap-1 align-items-lg-center me-auto navbar-nav-mobile',
            'menu_id'         => '',
            'container'      => '',
            'fallback_cb'     => 'vtech_Walker_Nav_Menu::fallback',
            'walker'     => new vtech_Walker_Nav_Menu,
        ) 
    ); 
}