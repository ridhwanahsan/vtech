<?php

/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 */
?>
<?php
// If the current post is protected by a password and the visitor has not yet 
// entered the password we will return early without loading the comments.
// ----------------------------------------------------------------------------------------
if (post_password_required()) {
    return;
}
?>

<?php if (have_comments() || comments_open()) : ?>
    <div id="comments" class=" box-feedbacks">

        <?php if (get_comments_number() >= 1): ?>
            <div class="p ">
                <div class="r">
                    <h4 class="paragraph-rubik-md-b mb-4">User Feedbacks <span class="gray-1500">(<?php echo get_comments_number(); ?>)</span></h4>
                </div>
                <div class="latest-comments mb-65">
                    <ul>
                        <?php
                        wp_list_comments([
                            'style'       => 'ul',
                            'callback'    => 'harry_comment',
                            'avatar_size' => 90,
                            'short_ping'  => true,
                        ]);
                        ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')): ?>
            <div class="comment-pagination mb-50 d-none">
                <nav id="comment-nav-below" class="comment-navigation" role="navigation">
                    <h1 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'harry'); ?></h1>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="nav-previous "><?php previous_comments_link(esc_html__('&larr; Older ', 'harry')); ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="nav-next "><?php next_comments_link(esc_html__('Newer &rarr;', 'harry')); ?></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </nav><!-- #comment-nav-below -->
            </div>
        <?php endif; // check for comment navigation 
        ?>


        <?php
       
        // my html code
        ?>
        <div class="box-form-feedback">
                    <div class="d-flex align-items-center justify-content-between">
                    <div class="title-form-left mb-4">
                        <h4 class="paragraph-rubik-md-b">Add Feedback & Reviews</h4>
                    </div>
                  
                    </div>
                    <div class="form-feedback">
                    <?php
                    $comments_args = array(
                        'fields' => array(
                        'author' => '<div class="row mb-3"><div class="col-md-4"><div class="form-group"><input type="text" class="form-control" name="author" placeholder="Your name" /></div></div>',

                        'email' => '<div class="col-md-4"><div class="form-group"><input type="email" class="form-control" name="email" placeholder="Your email" /></div></div>',

                        
                        'url' => '<div class="col-md-4"><div class="form-group"><input type="url" class="form-control" name="url" placeholder="Website" /></div></div></div>',
                        ),
                        'comment_field' => '<div class="row"><div class="col-md-12"><div class="form-group"><textarea style="width: 100%; min-height: 150px; white-space: pre-wrap; resize: vertical;" class="form-control" name="comment" placeholder="Your comment" rows="5"></textarea></div></div></div>',
                        'submit_button' => '<div class="row mt-3"><div class="col-md-12"><div class="form-group"><button class="btn btn-black-rounded" type="submit">Submit Comment</button></div></div></div>',
                        'comment_notes_before' => '',
                        'comment_notes_after' => '',
                        'title_reply' => '',
                        'class_form' => '',
                    );
                    comment_form($comments_args);
                    ?>
        </div>
    </div>
       

    </div><!-- #comments -->
<?php endif;
