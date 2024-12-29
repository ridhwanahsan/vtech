<?php
// Register and load the widget
function custom_category_widget() {
    register_widget( 'custom_category' );
}
add_action( 'widgets_init', 'custom_category_widget' );

// Creating the widget 
class custom_category extends WP_Widget {

    function __construct() {
        parent::__construct(
            'custom_category', 
            __('Custom Category Widget', 'custom_category_domain'), 
            array( 'description' => __( 'A custom widget to display categories with post count', 'custom_category_domain' ), ) 
        );
    }

    // Creating the widget front-end
    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        

        // Fetch categories
        $number_of_categories = ! empty( $instance['number_of_categories'] ) ? absint( $instance['number_of_categories'] ) : 5;
        $categories = get_categories(array(
            'orderby' => 'name',
            'order' => 'ASC',
            'number' => $number_of_categories
        ));

        if ( ! empty( $categories ) ) : ?>
            <div class="sidebar-border border-10 bdr-5 p-4 mb-4 content-sidebar">
                <!-- <h5 class="widget-title"> -->
            <?php  // Widget title
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        } ?>
                <!-- </h5> -->
                <!-- <div class="content-sidebar"> -->
                <ul>
                    <?php foreach ( $categories as $category ) : ?>
                        <li>
                            <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
                                <?php echo esc_html( $category->name ); ?>
                                <span>(<?php echo esc_html( $category->count ); ?>)</span>
                            </a>
                        </li>
                    <!-- </div> -->
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif;

        echo $args['after_widget'];
    }

    // Widget Backend 
    public function form( $instance ) {
        // Title
        if ( isset( $instance['title'] ) ) {
            $title = $instance['title'];
        } else {
            $title = __( 'Categories', 'custom_category_domain' );
        }

        // Number of categories to display
        if ( isset( $instance['number_of_categories'] ) ) {
            $number_of_categories = $instance['number_of_categories'];
        } else {
            $number_of_categories = 5;
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 

            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'number_of_categories' ); ?>"><?php _e( 'Number of categories to show:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'number_of_categories' ); ?>" name="<?php echo $this->get_field_name( 'number_of_categories' ); ?>" type="number" value="<?php echo esc_attr( $number_of_categories ); ?>" />
        </p>
        <?php 
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['number_of_categories'] = ( ! empty( $new_instance['number_of_categories'] ) ) ? absint( $new_instance['number_of_categories'] ) : 5;
        return $instance;
    }
} // Class custom_category ends here
?>
