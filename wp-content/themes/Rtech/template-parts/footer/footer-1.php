 <?php 
 $offCanvas_menu_logo = get_theme_mod('offCanvas_menu_logo', get_template_directory_uri() . '/assets/images/logo.png');
 $offCanvas_menu_select = get_theme_mod('offCanvas_menu_select', 'primary-menu');
 $offCanvas_gallery_title = get_theme_mod('offCanvas_gallery_title', 'Our Gallery');
 $offCanvas_gallery = get_theme_mod('offCanvas_gallery', '');
 $contact_section_title = get_theme_mod('contact_section_title', 'Contact Info');
 $offCanvas_adress = get_theme_mod('offCanvas_adress', '123 Main Street, New York, NY 10001');
 $offCanvas_work_hours = get_theme_mod('offCanvas_work_hours', 'Mon - Fri: 9:00 AM - 6:00 PM');
 $offCanvas_phone = get_theme_mod('offCanvas_phone', '+1 (555) 123-4567');
 $footer_newsletter_title = get_theme_mod('footer_newsletter_title', 'Newsletter');
 $footer_newsletter_text = get_theme_mod('footer_newsletter_text', 'Subscribe to our newsletter to receive updates and news.');
 $footer_newsletter_placeholder = get_theme_mod('footer_newsletter_placeholder', 'Enter your email');
 $footer_social_title = get_theme_mod('footer_social_title', 'Follow Us');
 ?>
 
 
 <footer>
     <div class="container-fluid ft-bgr section-footer">
         <div class="container">
             <div class="row">
                 <div class="col-lg-3 col-md-6">
                     <a class="navbar-brand pe-4" href="<?php echo home_url(); ?>">
                         <?php if(get_theme_mod('footer_logo')): ?>
                         <img src="<?php echo esc_url(get_theme_mod('footer_logo')); ?>"
                             alt="<?php bloginfo('name'); ?>" />
                         <?php endif; ?>
                     </a>
                     <p class="paragraph-base color-white pt-4 pb-2"><?php echo get_theme_mod('footer_description'); ?>
                     </p>
                     <p class="text-inline">
                         <svg class="me-2" width="22" height="22" viewBox="0 0 22 22" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                             <g clip-path="url(#clip0_4249_3089)">
                                 <path
                                     d="M16.6714 13.4105C16.2391 12.9806 15.7177 12.7508 15.1652 12.7508C14.617 12.7508 14.0912 12.9764 13.6411 13.4062L12.2329 14.747C12.1171 14.6874 12.0012 14.6321 11.8898 14.5767C11.7294 14.5001 11.5779 14.4278 11.4486 14.3511C10.1296 13.551 8.93086 12.5082 7.78114 11.1589C7.22411 10.4864 6.84978 9.92032 6.57795 9.34572C6.94336 9.0265 7.28204 8.6945 7.6118 8.37528C7.73658 8.2561 7.86135 8.13267 7.98613 8.01349C8.92194 7.11967 8.92194 5.96195 7.98613 5.06812L6.76957 3.90615C6.63143 3.7742 6.48883 3.638 6.35514 3.5018C6.08776 3.23791 5.80702 2.9655 5.51736 2.71012C5.0851 2.30152 4.56818 2.08445 4.02451 2.08445C3.48085 2.08445 2.95501 2.30152 2.50939 2.71012C2.50493 2.71438 2.50493 2.71438 2.50047 2.71864L0.985345 4.17855C0.414944 4.72336 0.089637 5.38735 0.0183368 6.15774C-0.0886134 7.40058 0.294625 8.5583 0.588738 9.31593C1.31065 11.1759 2.38907 12.8997 3.99778 14.747C5.94962 16.973 8.29807 18.7309 10.9807 19.9695C12.0057 20.4334 13.3737 20.9825 14.9022 21.0761C14.9958 21.0804 15.0939 21.0846 15.183 21.0846C16.2124 21.0846 17.0769 20.7314 17.7542 20.0291C17.7587 20.0206 17.7676 20.0163 17.7721 20.0078C18.0038 19.7396 18.2712 19.497 18.5519 19.2374C18.7435 19.0629 18.9396 18.8799 19.1312 18.6883C19.5724 18.2499 19.8041 17.7392 19.8041 17.2156C19.8041 16.6879 19.5679 16.1814 19.1179 15.7557L16.6714 13.4105Z"
                                     fill="#EEEEEE" />
                             </g>
                             <defs>
                                 <clipPath id="clip0_4249_3089">
                                     <rect width="22" height="22" fill="white" />
                                 </clipPath>
                             </defs>
                         </svg>
                         <span class="color-white"><?php echo get_theme_mod('footer_phone'); ?></span>
                     </p>
                     <p class="text-inline">
                         <svg class="me-2" width="22" height="22" viewBox="0 0 22 22" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                             <!-- Clock SVG path -->
                             <path
                                 d="M11 0C8.82441 0 6.69767 0.645139 4.88873 1.85383C3.07979 3.06253 1.66989 4.78049 0.83733 6.79048C0.00476609 8.80047 -0.213071 11.0122 0.211367 13.146C0.635804 15.2798 1.68345 17.2398 3.22183 18.7782C4.76021 20.3165 6.72022 21.3642 8.85401 21.7886C10.9878 22.2131 13.1995 21.9952 15.2095 21.1627C17.2195 20.3301 18.9375 18.9202 20.1462 17.1113C21.3549 15.3023 22 13.1756 22 11C21.9972 8.08347 20.8374 5.28719 18.7751 3.22489C16.7128 1.16259 13.9165 0.00277369 11 0Z"
                                 fill="#EEEEEE" />
                         </svg>
                         <span class="color-white"><?php echo get_theme_mod('footer_hours'); ?></span>
                     </p>
                 </div>
             
                     <!-- for widget -->
                
                 
                     <?php dynamic_sidebar('footer-menu-widget'); ?>
                
                 <div class="col-lg-3 col-md-6">
                     <h3 class="text-footer pb-1"><?php echo get_theme_mod('footer_newsletter_title'); ?></h3>
                     <div class="pt-4">
                         <p class="paragraph-base color-white"><?php echo get_theme_mod('footer_newsletter_text'); ?>
                         </p>
                     </div>
                     <div class="pt-3">
                         <div class="form-newsletter">
                             <form action="#">
                                 <input type="text" class="form-control"
                                     placeholder="<?php echo get_theme_mod('footer_newsletter_placeholder'); ?>" />
                                 <input type="submit" class="btn btn-newsletter" value="" />
                             </form>
                         </div>
                     </div>
                     <div class="box-social-profile pt-4">
                         <p class="paragraph-bold color-white"><?php echo get_theme_mod('footer_social_title'); ?></p>
                         <div class="list-socials">
                             <?php if(get_theme_mod('footer_facebook')): ?>
                             <a href="<?php echo esc_url(get_theme_mod('footer_facebook')); ?>" class="share fb"></a>
                             <?php endif; ?>
                             <?php if(get_theme_mod('footer_twitter')): ?>
                             <a href="<?php echo esc_url(get_theme_mod('footer_twitter')); ?>" class="share tw"></a>
                             <?php endif; ?>
                             <?php if(get_theme_mod('footer_instagram')): ?>
                             <a href="<?php echo esc_url(get_theme_mod('footer_instagram')); ?>"
                                 class="share instagram"></a>
                             <?php endif; ?>
                             <?php if(get_theme_mod('footer_pinterest')): ?>
                             <a href="<?php echo esc_url(get_theme_mod('footer_pinterest')); ?>"
                                 class="share printest"></a>
                             <?php endif; ?>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="container-fluid footer-1 px-0">
         <div class="footer">
             <div class="container py-4">
                 <div class="footer-bottom">
                     <div class="row paragraph-base">
                         <div class="col">
                             <div class="small color-white"><?php echo get_theme_mod('footer_copyright'); ?></div>
                         </div>
                         <div class="col d-flex justify-content-end">
                             <p class="color-white"><?php echo get_theme_mod('footer_credits'); ?></p>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </footer>
 </div>
 </div>
 </div>
 </div>
 </footer>
 </div>
 </footer>