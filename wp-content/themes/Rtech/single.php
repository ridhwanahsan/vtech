<?php get_header(); ?>
<section class="box-section box-contact-section-2">
    <div class="container" data-aos="fade-up">
        <div class="blog-main-content">
            <div class="blog-content-left">
                <div class="blog-detail">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" />
                            <h1><?php the_title(); ?></h1>
                            <div><?php the_content(); ?></div>
                    <?php endwhile;
                    endif; ?>
                </div>
                <div class="box-pagination d-flex align-items-center justify-content-between">
                    <div class="page-left">
                        <?php previous_post_link('%link', 'Prev Post'); ?>
                    </div>
                    <div class="page-right">
                        <?php next_post_link('%link', 'Next Post'); ?>
                    </div>
                </div>
    
              
                <?php
		
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ):
		comments_template();
		endif;

		?>
            </div>
            <div class="blog-content-right">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>