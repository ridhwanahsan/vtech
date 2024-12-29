<?php 
// offCanvas menu
 $offCanvas_menu_logo = get_theme_mod( 'offCanvas_menu_logo', get_template_directory_uri() . '/assets/img/logo.png' );
 $offCanvas_menu_select = get_theme_mod( 'offCanvas_menu_select', '' );
 $offCanvas_menu_title = get_theme_mod( 'offCanvas_menu_title', esc_html__('Menu', 'rtech') );
 $offCanvas_gallery_title = get_theme_mod( 'offCanvas_gallery_title', esc_html__('Gallery', 'rtech') );
 $offCanvas_gallery = get_theme_mod( 'offCanvas_gallery', get_template_directory_uri() . '/assets/img/gallery-1.jpg' );
 $contact_section_title = get_theme_mod( 'contact_section_title', esc_html__('Contact Us', 'rtech') );
 $offCanvas_adress = get_theme_mod( 'offCanvas_adress', esc_html__('62, Business Str Hobert, AU', 'rtech') );
 $offCanvas_work_hours = get_theme_mod( 'offCanvas_work_hours', esc_html__('Mon - Fri: 9:00 - 18:00', 'rtech') );
 $offCanvas_phone = get_theme_mod( 'offCanvas_phone', esc_html__('+98 90980798', 'rtech') );



?>


<!-- offCanvas-menu -->
    <div class="offCanvas__info">
        <div class="offCanvas__close-icon menu-close">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 24 24">
                    <path
                        d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z">
                    </path>
                </svg>
            </button>
        </div>
        <div class="offCanvas__logo mb-20">
            <a href="index.html"><img src="<?php echo esc_url($offCanvas_menu_logo)?>" alt="Logo" /></a>
        </div>
        <div class="offCanvas__side-info mb-30">
        <?php wp_nav_menu( array( 'menu' => get_theme_mod('offCanvas_menu_select') ) ); ?>
        </div>
        <div class="side-gallery mb-4">
            <div class="pt-1"></div>
            <h4 class="mt-3 mb-3"><?php echo esc_html( $offCanvas_gallery_title ); ?></h4>
            <div class="grid-items">
                <?php 
                // Get the gallery images from theme mod
                $gallery_images = get_theme_mod('offCanvas_gallery', array());
                
                // Check if we have gallery images
                if (!empty($gallery_images)) {
                    // Loop through each gallery image
                    foreach ($gallery_images as $image) {
                        if (!empty($image['image'])) {
                            ?>
                            <div class="zoom-img rounded-3 d-inline-flex overflow-hidden">
                                <img class="g-col-4" src="<?php echo esc_url($image['image']); ?>" alt="vatech" />
                            </div>
                            <?php
                        }
                    }
                } else {
                    // Fallback if no images are set
                    ?>
                    <div class="zoom-img rounded-3 d-inline-flex overflow-hidden">
                        <img class="g-col-4" src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/gallery-1.jpg'); ?>" alt="vatech" />
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="box-contactus mb-30">
            <h5 class="title-contactus neutral-1000 mb-3"><?php echo esc_html( $contact_section_title ); ?></h5>
            <div class="contact-info">
                <p class="address-2 text-md-medium neutral-1000"><strong>Address:
                    </strong><?php echo get_theme_mod('offCanvas_adress'); ?></p>
                <p class="hour-work-2 text-md-medium neutral-1000"><strong>Hours: </strong>
                    <?php echo get_theme_mod('offCanvas_work_hours'); ?></p>
                <p class="hour-work-2 text-md-medium neutral-1000"><strong>Phone: </strong>
                    <?php echo get_theme_mod('offCanvas_phone'); ?></p>
            </div>
        </div>
    </div>
    <div class="offCanvas__overly"></div>
