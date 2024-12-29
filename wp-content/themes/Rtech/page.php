<?php get_header(); ?>
<section class="box-section box-contact-section-2">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-12">
                <div class="box-list-blogs">
                    <?php if (have_posts()): while (have_posts()): the_post();?>
                        <?php the_content();?>
                    <?php endwhile;else: ?>
                        <p><?php _e('No Page Posts To Display.');?></p>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>