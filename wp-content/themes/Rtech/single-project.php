<?php get_header(); ?>
<?php 
$sub_title = get_field('sub_title');
$value_under_title = get_field('value_under_title');
$category_title = get_field('category-title','');
$amount_title = get_field('amount_title');
$amount_value = get_field('amount_value');
$date_title = get_field('date_title');
$date_value = get_field('date_value');

?>


 <section class="box-section box-project-detail">
            <div class="container" data-aos="fade-up">
                <?php
    if (have_posts()):
    while (have_posts()): the_post(); ?>
                <div class="row">
                    
                    <div class="col-lg-7 mb-4">
                        <div class="left-project-detail">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="project" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-5 mb-4 position-relative">
                        <div class="right-project-detail">
                            <h2><?php the_title()?></h2>
                            <p class="paragraph-rubik-r neutral-2400"><?php the_excerpt(  )?></p>
                            <div class="box-info-project mt-4">
                                <div class="row">
                                    <div class="col-sm-6">

                                        <p class="paragraph-rubik-r">
                                            <?php echo $sub_title?>
                                        </p>


                                        <p class="sub-heading-ag-md mb-5">
                                            <?php echo $value_under_title?>
                                        </p>

                                        <p class="paragraph-rubik-r">
                                            <?php echo $amount_title?>
                                        </p>
                                        <p class="sub-heading-ag-md">
                                            <?php echo $amount_value?>
                                        </p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="paragraph-rubik-r">
                                            <?php echo $category_title?>
                                        </p>
                                        <p class="sub-heading-ag-md mb-5">
                                            
                                        <?php 
                                        $terms = get_the_terms(get_the_ID(), 'project_category');
                                        if ($terms && !is_wp_error($terms)) {
                                            $term_names = array_map(function($term) {
                                                return $term->name;
                                            }, $terms);
                                            echo implode(', ', $term_names);
                                        }
                                        ?>
                                        </p>
                                        <p class="paragraph-rubik-r">
                                        
                                            <?php echo $date_title?>
                                        </p>
                                        <p class="sub-heading-ag-md">
                                            <?php echo $date_value?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="blog-detail">
                    <p>Sliquam eros justo, posuere loborti viverra laoreet matti ullamcorper posuere viverra .Aliquam eros justo, posuere lobortis, aoreet augue mattis ferment ullamcorper viverra laoreet Aliquam eros justo, posuere loborti viverra laoreet matti ullamcorper posuere viverra .Aliquam eros justo, posuere lobortis non,</p>
                    <p>Aliquam eros justo, posuere loborti viverra laoreet matti ullamcorper posuere viverra .Aliquam erosto, posuere lobortis non, viverra laoreet augue mis fermentum ullamcorper viverra laoreet Aliquam eros justo, posuere loborti viverra laoreet matti ullamcorper posuere viverra .Aliquam eros justo, posuere lobortis non, viverra laoreet augue mattis. Aliquam eros justo, posuere loborti viverra laoreet matti ullamcorper posuere viverra .Aliquam eros justo, posuere lobortis non, viverra laoreet augue mattis.</p>
                    <h4>Our Project Structure Fully Responsive</h4>
                    <p>Aliquam eros justo, posuere loborti vive rra laoreet matti ullamc orper posu ere viverra .Aliquam eros justo, posuere lobor, vive rra laoreet augue mattis fermentum ullamcorper viverra laoreet Aliquam eros justo, posuere loborti viverra laoreet mat ullamcorper posue viverra .Aliquam eros justo,</p>
                </div>
                <?php endwhile;
endif;
?>
            </div>
        </section>

<?php get_footer(); ?>
