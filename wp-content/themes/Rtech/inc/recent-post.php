<?php
// Register and load the widget
function custom_recent_post_widget() {
    register_widget('custom_recent_post');
}
add_action('widgets_init', 'custom_recent_post_widget');

// Creating the widget 
class custom_recent_post extends WP_Widget {

    function __construct() {
        parent::__construct(
            'custom_recent_post',
            __('Custom Recent Posts Widget', 'custom_recent_post_domain'),
            array('description' => __('A custom widget to display recent posts', 'custom_recent_post_domain'),)
        );
    }

    // Creating widget front-end
    public function widget($args, $instance) {
        echo $args['before_widget'];

        $title = !empty($instance['title']) ? $instance['title'] : 'Recent post';
        $num_posts = !empty($instance['num_posts']) ? absint($instance['num_posts']) : 3;
        $title_length = !empty($instance['title_length']) ? absint($instance['title_length']) : 40;

        $recent_posts = get_posts(array(
            'numberposts' => $num_posts,
            'post_status' => 'publish'
        ));

        if (!empty($recent_posts)) : ?>
            <div class="sidebar-border border-10 bdr-5 p-4 mb-4">
                <h4 class="sub-heading-ag-xl mb-2"><?php echo esc_html($title); ?></h4>
                <ul class="recent-news-list-md">
                    <?php foreach ($recent_posts as $post) : 
                        setup_postdata($post); 
                        $trimmed_title = wp_trim_words(get_the_title(), $title_length, '...'); ?>
                        <li>
                            <div class="news-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) {
                                        the_post_thumbnail('thumbnail', array('alt' => get_the_title()));
                                    } else { ?>
                                        <img src="assets/imgs/pages/home6/blog.png" alt="<?php the_title(); ?>" />
                                    <?php } ?>
                                </a>
                            </div>
                            <div class="news-info">
                                <div class="news-postdate">
                                    <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.5625 2H6.9375V1.0625C6.9375 0.757812 7.17188 0.5 7.5 0.5C7.80469 0.5 8.0625 0.757812 8.0625 1.0625V2H9C9.82031 2 10.5 2.67969 10.5 3.5V11C10.5 11.8438 9.82031 12.5 9 12.5H1.5C0.65625 12.5 0 11.8438 0 11V3.5C0 2.67969 0.65625 2 1.5 2H2.4375V1.0625C2.4375 0.757812 2.67188 0.5 3 0.5C3.30469 0.5 3.5625 0.757812 3.5625 1.0625V2ZM1.125 6.3125H3V5H1.125V6.3125ZM1.125 7.4375V8.9375H3V7.4375H1.125ZM4.125 7.4375V8.9375H6.375V7.4375H4.125ZM7.5 7.4375V8.9375H9.375V7.4375H7.5ZM9.375 5H7.5V6.3125H9.375V5ZM9.375 10.0625H7.5V11.375H9C9.1875 11.375 9.375 11.2109 9.375 11V10.0625ZM6.375 10.0625H4.125V11.375H6.375V10.0625ZM3 10.0625H1.125V11C1.125 11.2109 1.28906 11.375 1.5 11.375H3V10.0625ZM6.375 5H4.125V6.3125H6.375V5Z" fill=""></path>
                                    </svg>
                                    <span class="paragraph-rubik-r-sm"><?php echo get_the_date(); ?></span>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="sub-heading-ag-lg news-link"><?php echo esc_html($trimmed_title); ?></a>
                            </div>
                        </li>
                    <?php endforeach;
                    wp_reset_postdata(); ?>
                </ul>
            </div>
        <?php endif;

        echo $args['after_widget'];
    }

    // Widget Backend 
    public function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : __('Recent post', 'custom_recent_post_domain');
        $num_posts = isset($instance['num_posts']) ? absint($instance['num_posts']) : 3;
        $title_length = isset($instance['title_length']) ? absint($instance['title_length']) : 40;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php _e('Number of posts to show:'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('num_posts'); ?>" name="<?php echo $this->get_field_name('num_posts'); ?>" type="number" step="1" min="1" value="<?php echo $num_posts; ?>" size="3" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title_length'); ?>"><?php _e('Number of words in title:'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('title_length'); ?>" name="<?php echo $this->get_field_name('title_length'); ?>" type="number" step="1" min="1" value="<?php echo $title_length; ?>" size="3" />
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['num_posts'] = (!empty($new_instance['num_posts'])) ? absint($new_instance['num_posts']) : 3;
        $instance['title_length'] = (!empty($new_instance['title_length'])) ? absint($new_instance['title_length']) : 40;
        return $instance;
    }
}