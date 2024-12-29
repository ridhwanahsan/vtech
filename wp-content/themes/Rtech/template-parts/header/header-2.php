<?php 
 $header02_top_switch = get_theme_mod( 'header02_top_switch', true );
 $header02_location_address = get_theme_mod( 'header02_location_address', esc_html__('62, Business Str Hobert, AU', 'rtech') );
 $header02_top_mail_adress = get_theme_mod( 'header02_top_mail_adress', esc_html__('info@vatech.com', 'rtech') );
 $header02_top_phone_number = get_theme_mod( 'header02_top_phone_number', esc_html__('+98 90980798', 'rtech') );
 $header02_menu_btn_txt = get_theme_mod( 'header02_menu_btn_txt', esc_html__('Get Started', 'rtech') );
 $header02_menu_btn_link = get_theme_mod( 'header02_menu_btn_link', '#' );
 //header02 top social links
 $header02_top_facebook_link = get_theme_mod( 'facebook_link', '#' );
 $header02_top_instagram_link = get_theme_mod( 'instagram_link', '#' );
 $header02_top_twitter_link = get_theme_mod( 'twitter_link', '#' );
 $pinterest_link = get_theme_mod( 'facebook_link', '#' );
 //header02 logo
 $header02_menu_logo = get_theme_mod( 'header02_menu_logo', get_template_directory_uri() . '/assets/img/logo.png' );
 
?>

<?php search_header_menu();?>
 <header class="header-style-2">
        <div class="box-header">
            <div class="container">
                <div class="d-flex align-items-center">
                    <div class="box-header-left">
                        <a class="navbar-brand pe-4" href="<?php echo esc_url(home_url('/'))?>"><img src="<?php echo esc_url($header02_menu_logo)?>" alt /></a>
                    </div>
                    <div class="box-header-right">
                        <!--top-bar-->
                        <?php if ( !empty( $header02_top_switch ) ): ?>
                        <section class="top-bar position-relative z-4 d-none d-xl-block">
                            <div class="container-fluid">
                                <div class="container py-2">
                                    <div class="d-flex mb-lg-0 mb-3 flex-wrap align-items-center justify-content-center justify-content-lg-between gap-4">
                                        <div class="box-infos-contact d-flex align-items-center">
                                            <div class="address">
                                                <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8 0C6.01169 0.00263755 4.10556 0.793661 2.69961 2.19961C1.29366 3.60556 0.502638 5.51169 0.5 7.5C0.5 12.8844 7.4875 19.6281 7.78437 19.9125C7.84212 19.9686 7.91947 20 8 20C8.08053 20 8.15788 19.9686 8.21562 19.9125C8.5125 19.6281 15.5 12.8844 15.5 7.5C15.4974 5.51169 14.7063 3.60556 13.3004 2.19961C11.8944 0.793661 9.98831 0.00263755 8 0ZM8 10.9375C7.32013 10.9375 6.65552 10.7359 6.09023 10.3582C5.52493 9.98046 5.08434 9.4436 4.82416 8.81547C4.56399 8.18735 4.49591 7.49619 4.62855 6.82938C4.76119 6.16257 5.08858 5.55006 5.56932 5.06932C6.05006 4.58858 6.66257 4.26119 7.32938 4.12855C7.99619 3.99591 8.68735 4.06399 9.31547 4.32416C9.9436 4.58434 10.4805 5.02493 10.8582 5.59023C11.2359 6.15552 11.4375 6.82013 11.4375 7.5C11.437 8.41151 11.0746 9.28554 10.4301 9.93008C9.78554 10.5746 8.91151 10.937 8 10.9375Z" fill="white" />
                                                </svg>
                                               <?php echo esc_html( $header02_location_address ); ?>
                                            </div>
                                            <div class="email">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12.9582 10.832L11.2832 12.5127C10.6039 13.1944 9.40875 13.2091 8.7148 12.5127L7.03969 10.832L1.02344 16.8678C1.24738 16.9714 1.4943 17.0332 1.7568 17.0332H18.2412C18.5037 17.0332 18.7505 16.9714 18.9744 16.8679L12.9582 10.832Z" fill="white" />
                                                    <path d="M18.2411 2.96875H1.75672C1.49422 2.96875 1.2473 3.03055 1.02344 3.1341L7.45223 9.58422C7.45266 9.58465 7.45316 9.58473 7.45359 9.58516C7.45402 9.58559 7.4541 9.58617 7.4541 9.58617L9.54445 11.6834C9.76648 11.9055 10.2314 11.9055 10.4534 11.6834L12.5434 9.58652C12.5434 9.58652 12.5439 9.58559 12.5443 9.58516C12.5443 9.58516 12.5452 9.58465 12.5457 9.58422L18.9743 3.13406C18.7504 3.03047 18.5036 2.96875 18.2411 2.96875Z" fill="white" />
                                                    <path d="M0.186953 3.95312C0.0710937 4.18742 0 4.4475 0 4.72609V15.273C0 15.5516 0.0710156 15.8116 0.186914 16.0459L6.21359 9.99973L0.186953 3.95312Z" fill="white" />
                                                    <path d="M19.8118 3.95312L13.7852 9.99981L19.8118 16.0461C19.9276 15.8118 19.9987 15.5517 19.9987 15.273V4.72617C19.9987 4.4475 19.9276 4.18742 19.8118 3.95312Z" fill="white" />
                                                </svg>
                                              <?php echo esc_html( $header02_top_mail_adress ); ?>
                                            </div>
                                            <div class="phone">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.2051 13.2321C14.5517 12.587 13.736 12.587 13.0867 13.2321C12.5915 13.7232 12.0962 14.2143 11.6093 14.7137C11.4761 14.8511 11.3638 14.8802 11.2014 14.7886C10.881 14.6138 10.5397 14.4723 10.2317 14.2809C8.79592 13.3778 7.59315 12.2166 6.52773 10.9098C5.99918 10.2606 5.52889 9.56556 5.20011 8.78314C5.13352 8.62499 5.14601 8.52095 5.27502 8.39193C5.77028 7.91332 6.25305 7.42223 6.73998 6.93114C7.41836 6.2486 7.41836 5.44953 6.73582 4.76283C6.34877 4.37162 5.96172 3.98874 5.57467 3.59753C5.17514 3.19799 4.77977 2.7943 4.37607 2.39892C3.72267 1.76217 2.90695 1.76217 2.25771 2.40309C1.75829 2.89418 1.27968 3.39776 0.771944 3.88053C0.301659 4.32584 0.0644358 4.87104 0.014494 5.5078C-0.0645804 6.54409 0.18929 7.52211 0.547206 8.47517C1.27968 10.4479 2.39505 12.2 3.74764 13.8064C5.57467 15.9789 7.75546 17.6977 10.3067 18.938C11.4553 19.4956 12.6456 19.9243 13.9399 19.9951C14.8305 20.045 15.6046 19.8203 16.2247 19.1252C16.6493 18.6508 17.1279 18.218 17.5773 17.7643C18.2432 17.0901 18.2474 16.2744 17.5857 15.6085C16.7949 14.8136 16 14.0229 15.2051 13.2321Z" fill="white" />
                                                    <path d="M14.4098 9.91419L15.9455 9.652C15.7042 8.24114 15.0383 6.96346 14.027 5.94798C12.9574 4.8784 11.6048 4.20418 10.1149 3.99609L9.89844 5.54013C11.0513 5.70244 12.1 6.22266 12.9282 7.05086C13.7107 7.83328 14.2226 8.82379 14.4098 9.91419Z" fill="white" />
                                                    <path d="M16.8104 3.23789C15.0375 1.46496 12.7943 0.34543 10.318 0L10.1016 1.54403C12.2407 1.84368 14.1801 2.81338 15.7117 4.34077C17.1642 5.79324 18.1172 7.6286 18.4626 9.64708L19.9983 9.38488C19.5947 7.04595 18.4918 4.92342 16.8104 3.23789Z" fill="white" />
                                                </svg>
                                       <?php echo esc_html( $header02_top_phone_number ); ?>
                                            </div>
                                        </div>
                                        <div class="box-socials">
                                            <a href="<?php echo esc_url( $header02_menu_btn_link )?>" class="btn btn-linear text-white">
                                             <?php echo esc_html( $header02_menu_btn_txt ); ?>
                                                <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.3333 12C11.3333 11.364 11.8525 10.4143 12.3781 9.61714C13.0539 8.58857 13.8614 7.69114 14.7872 7.00629C15.4813 6.49286 16.3228 6 17 6M17 6C16.3228 6 15.4806 5.50714 14.7872 4.99371C13.8614 4.308 13.0539 3.41057 12.3781 2.38371C11.8525 1.58571 11.3333 0.634285 11.3333 -3.66907e-07M17 6L7.39105e-07 6" stroke="" stroke-width="1.5" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                            <?php endif; ?>
                        <nav class="navbar navbar-expand-lg navbar-light w-100 navbar-stick">
                            <?php vtech_menu();?>

                            <div class="d-flex align-items-center box-header-right-buttons">
                                <a href="javascript:void(0)" class="btn-open-search">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_4249_3239)">
                                            <path d="M9.96863 0.916016C4.98038 0.916016 0.916992 4.97801 0.916992 9.96458C0.916992 14.9511 4.98038 19.021 9.96863 19.021C12.0993 19.021 14.0588 18.2746 15.6075 17.0353L19.3778 20.8024C19.5681 20.9847 19.8222 21.0853 20.0858 21.0826C20.3494 21.0799 20.6014 20.9742 20.7879 20.788C20.9744 20.6018 21.0805 20.3501 21.0836 20.0866C21.0867 19.8232 20.9864 19.569 20.8043 19.3785L17.0339 15.6094C18.2747 14.0589 19.0222 12.0969 19.0222 9.96458C19.0222 4.97801 14.9569 0.916016 9.96863 0.916016ZM9.96863 2.92727C13.8696 2.92727 17.0083 6.06498 17.0083 9.96458C17.0083 13.8642 13.8696 17.0098 9.96863 17.0098C6.06769 17.0098 2.9289 13.8642 2.9289 9.96458C2.9289 6.06498 6.06769 2.92727 9.96863 2.92727Z" fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_4249_3239">
                                                <rect width="22" height="22" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                                
                                <a href="javascript:void(0)" class="menu-tigger btn-navbar rounded-circle px-2 ms-4 d-flex align-items-center justify-content-center btn-menu">
                                    <svg width="30" height="24" viewBox="0 0 30 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <line y1="12" x2="30" y2="12" stroke="white" stroke-width="3" />
                                        <path d="M5 22H30" stroke="white" stroke-width="3" />
                                        <path d="M10 2H30" stroke="white" stroke-width="3" />
                                    </svg>
                                </a>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>