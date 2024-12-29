<?php
// Register and load the widget
function custom_tag_widget() {
    register_widget( 'custom_tag' );
}
add_action( 'widgets_init', 'custom_tag_widget' );

// Creating the widget 
class custom_tag extends WP_Widget {

    function __construct() {
        parent::__construct(
            'custom_tag', 
            __('Custom Tag Widget', 'custom_tag_domain'), 
            array( 'description' => __( 'A custom widget to display post tags', 'custom_tag_domain' ), ) 
        );
    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        
        $number_of_tags = ! empty( $instance['number_of_tags'] ) ? absint( $instance['number_of_tags'] ) : 10;
        $show_count = isset( $instance['show_count'] ) ? $instance['show_count'] : false;
        
        $tags = get_tags(array(
            'number' => $number_of_tags
        ));
        
        if($tags) : ?>
            <div class="sidebar-border border-10 bdr-5 p-4 mb-4">
                <?php if ( ! empty( $instance['title'] ) ) {
                    echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
                } ?>
                <div class="content-sidebar">
                    <?php foreach($tags as $tag) : ?>
                        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="btn btn-tag me-2 mb-2">
                            <?php 
                            echo $tag->name;
                            if($show_count) {
                                echo ' (' . $tag->count . ')';
                            }
                            ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif;

        echo $args['after_widget'];
    }
        
    // Widget Backend 
    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : __( 'Tags', 'custom_tag_domain' );
        $number_of_tags = isset( $instance['number_of_tags'] ) ? absint( $instance['number_of_tags'] ) : 10;
        $show_count = isset( $instance['show_count'] ) ? (bool) $instance['show_count'] : false;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'number_of_tags' ); ?>"><?php _e( 'Number of tags to show:' ); ?></label> 
            <input class="tiny-text" id="<?php echo $this->get_field_id( 'number_of_tags' ); ?>" name="<?php echo $this->get_field_name( 'number_of_tags' ); ?>" type="number" step="1" min="1" value="<?php echo $number_of_tags; ?>" size="3" />
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_count ); ?> id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php _e( 'Display post counts?' ); ?></label>
        </p>
        <?php 
    }
     
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['number_of_tags'] = (int) $new_instance['number_of_tags'];
        $instance['show_count'] = isset( $new_instance['show_count'] ) ? (bool) $new_instance['show_count'] : false;
        return $instance;
    }
}
?>