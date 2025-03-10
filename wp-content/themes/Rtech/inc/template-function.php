<?php 

function search_header_menu(){
    ?>
    <div id="myOverlay" class="overlay search-popup">
        <div class="overlay-content">
            <span class="search-close closebtn" onclick="closeSearch()">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 24 24">
                    <path
                        d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z">
                    </path>
                </svg>
            </span>
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="text" placeholder="Search.." name="s" value="<?php echo get_search_query(); ?>" />
                <button type="submit" class="btn btn-primary-500">Search</button>
            </form>
        </div>
    </div>
    <?php
}
function vtech_menu(){
    wp_nav_menu( 
        array( 
            'theme_location'  => 'main-menu',
            'menu_class'      => 'navbar-nav gap-1 align-items-lg-center me-auto',
            'menu_id'         => '',
            'container'      => '',
            'fallback_cb'     => 'vtech_Walker_Nav_Menu::fallback',
            'walker'     => new vtech_Walker_Nav_Menu,
        ) 
    ); 
}
/**
 * Generate custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML.
 */
function vtech_search_form($form)
{
    $form = ' <div class="debar-border border-10 bdr-5 p-4 mb-4"> 
                <div class="form-search-sidebar">
                        <form role="search" method="get" action="' . home_url('/') . '">
                           <input type="text" class="form-control" value="' . get_search_query() . '" name="s" placeholder="Enter your keywords...">
                           <button type="submit" class="btn btn-search"> 
                           <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.5781 16.8594C19.1055 17.4219 19.1055 18.3008 18.5781 18.8633C18.0156 19.3906 17.1367 19.3906 16.5742 18.8633L12.3906 14.6445C10.9492 15.5938 9.19141 16.0859 7.29297 15.8398C4.05859 15.3828 1.45703 12.7461 1.03516 9.54688C0.4375 4.76562 4.48047 0.722656 9.26172 1.32031C12.4609 1.74219 15.0977 4.34375 15.5547 7.57812C15.8008 9.47656 15.3086 11.2344 14.3594 12.6406L18.5781 16.8594ZM3.77734 8.5625C3.77734 11.0586 5.78125 13.0625 8.27734 13.0625C10.7383 13.0625 12.7773 11.0586 12.7773 8.5625C12.7773 6.10156 10.7383 4.0625 8.27734 4.0625C5.78125 4.0625 3.77734 6.10156 3.77734 8.5625Z" fill="" />
                                        </svg></button>
                        </form>
                    </div>
                </div>';

    return $form;
}
add_filter('get_search_form', 'vtech_search_form');


// vtech_navigation
function vtech_navigation() {
    $pages = paginate_links(array(
        'type' => 'array',
        'prev_text' => '<svg width="13" height="16" viewBox="0 0 13 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.68269 15.811C7.6281 15.871 7.56286 15.9186 7.49083 15.951C7.4188 15.9835 7.34144 16.0001 7.26331 16C7.18518 15.9999 7.10787 15.983 7.03593 15.9503C6.96399 15.9176 6.89889 15.8698 6.84448 15.8097L0.182493 8.48072C0.065486 8.35201 9.53674e-07 8.17939 9.53674e-07 7.99965C9.53674e-07 7.81992 0.065486 7.6473 0.182493 7.51859L6.84448 0.189653C6.89898 0.129633 6.96415 0.0819283 7.03613 0.0493546C7.10811 0.0167809 7.18545 0 7.26358 0C7.34171 0 7.41905 0.0167809 7.49103 0.0493546C7.56302 0.0819283 7.62818 0.129633 7.68269 0.189653C7.79482 0.312741 7.8576 0.477977 7.8576 0.650039C7.8576 0.822101 7.79482 0.987335 7.68269 1.11042L1.41796 7.99965L7.68269 14.8916C7.79444 15.0147 7.85697 15.1796 7.85697 15.3513C7.85697 15.5231 7.79444 15.688 7.68269 15.811ZM12.8251 15.811C12.7705 15.871 12.7053 15.9186 12.6332 15.951C12.5612 15.9835 12.4838 16.0001 12.4057 16C12.3276 15.9999 12.2503 15.983 12.1783 15.9503C12.1064 15.9176 12.0413 15.8698 11.9869 15.8097L5.3249 8.48072C5.20789 8.35201 5.1424 8.17939 5.1424 7.99965C5.1424 7.81992 5.20789 7.6473 5.3249 7.51859L11.9869 0.189653C12.0414 0.129633 12.1066 0.0819283 12.1785 0.0493546C12.2505 0.0167809 12.3279 0 12.406 0C12.4841 0 12.5615 0.0167809 12.6334 0.0493546C12.7054 0.0819283 12.7706 0.129633 12.8251 0.189653C12.9372 0.312741 13 0.477977 13 0.650039C13 0.822101 12.9372 0.987335 12.8251 1.11042L6.56036 7.99965L12.8251 14.8916C12.9368 15.0147 12.9994 15.1796 12.9994 15.3513C12.9994 15.5231 12.9368 15.688 12.8251 15.811Z" fill="" />
                        </svg>',
        'next_text' => '<svg width="13" height="16" viewBox="0 0 13 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.31731 15.811C5.3719 15.871 5.43714 15.9186 5.50917 15.951C5.5812 15.9835 5.65856 16.0001 5.73669 16C5.81482 15.9999 5.89214 15.983 5.96407 15.9503C6.03601 15.9176 6.10111 15.8698 6.15552 15.8097L12.8175 8.48072C12.9345 8.35201 13 8.17939 13 7.99965C13 7.81992 12.9345 7.6473 12.8175 7.51859L6.15552 0.189653C6.10102 0.129633 6.03585 0.081928 5.96387 0.0493546C5.89189 0.0167811 5.81455 0 5.73642 0C5.65829 0 5.58095 0.0167811 5.50897 0.0493546C5.43698 0.081928 5.37182 0.129633 5.31731 0.189653C5.20518 0.312741 5.1424 0.477977 5.1424 0.650039C5.1424 0.8221 5.20518 0.987335 5.31731 1.11042L11.582 7.99965L5.31731 14.8916C5.20556 15.0147 5.14303 15.1796 5.14303 15.3513C5.14303 15.5231 5.20556 15.688 5.31731 15.811ZM0.174909 15.811C0.2295 15.871 0.294735 15.9186 0.366764 15.951C0.438792 15.9835 0.516156 16.0001 0.594286 16C0.672417 15.9999 0.749733 15.983 0.821668 15.9503C0.893604 15.9176 0.958702 15.8698 1.01312 15.8097L7.6751 8.48072C7.79211 8.35201 7.8576 8.17939 7.8576 7.99965C7.8576 7.81992 7.79211 7.6473 7.6751 7.51859L1.01312 0.189653C0.958617 0.129633 0.89345 0.081928 0.821468 0.0493546C0.749485 0.0167811 0.672146 0 0.594015 0C0.515884 0 0.438545 0.0167811 0.366563 0.0493546C0.29458 0.081928 0.229414 0.129633 0.174909 0.189653C0.0627762 0.312741 0 0.477977 0 0.650039C0 0.8221 0.0627762 0.987335 0.174909 1.11042L6.43964 7.99965L0.174909 14.8916C0.0631609 15.0147 0.000626815 15.1796 0.000626815 15.3513C0.000626815 15.5231 0.0631609 15.688 0.174909 15.811Z" fill="" />
                        </svg>'
    ));

    if ($pages) {
        echo '<div class="box-paginations">';
        echo '<nav>';
        echo '<ul class="pagination">';
        foreach ($pages as $page) {
            if (strpos($page, 'current') !== false) {
                echo '<li class="page-item active">' . str_replace('page-numbers', 'page-link', $page) . '</li>';
            } else {
                echo '<li class="page-item">' . str_replace('page-numbers', 'page-link', $page) . '</li>';
            }
        }
        echo '</ul>';
        echo '</nav>';
        echo '</div>';
    }
}

