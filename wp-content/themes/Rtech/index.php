<?php get_header(); ?>

        <!-- prettier-ignore -->

        <!-- Blog Section 2 -->
        <section class="box-section box-contact-section-2">
            <div class="container" data-aos="fade-up">
                <div class="blog-main-content">
                    <div class="blog-content-left">
                        <div class="box-list-blogs">
                            <div class="row">

                                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part('template-parts/blog/content'); ?>
                    <?php endwhile; else : ?>
                    <p><?php _e( 'No Posts To Display.' ); ?></p>
                    <?php endif; ?>

                               

                            </div>
                           <?php vtech_navigation(); ?>
                        </div>
                    </div>

                    <div class="blog-content-right">
                   <?php get_sidebar();?>
                </div>
            </div>
            
        </section>



<?php get_footer(); ?>