<?php
// Register Footer Menu Widget
class Footer_Menu_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'footer_menu_widget',
            __('Footer Menu Widget', 'vtech'),
            array('description' => __('Displays a menu in the footer', 'vtech'))
        );
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $nav_menu = !empty($instance['nav_menu']) ? wp_get_nav_menu_object($instance['nav_menu']) : false;

        echo $args['before_widget'];
        
        if (!empty($title)) {
            echo '<h3 class="text-footer pb-1">' . esc_html($title) . '</h3>';
        }

        if ($nav_menu) {
            echo '<div class="d-flex flex-column align-items-start">';
            wp_nav_menu(array(
                'fallback_cb' => false,
                'menu' => $nav_menu,
                'container' => false,
                'items_wrap' => '%3$s',
                'link_before' => '<span class="hover-effect paragraph-base grey-100 pt-2">',
                'link_after' => '</span>',
                'menu_class' => 'footer-menu',
                'walker' => new Footer_Menu_Walker()
            ));
            echo '</div>';
        }

        echo $args['after_widget'];
    }

    // Move form method into main widget class
    public function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : '';
        $nav_menu = isset($instance['nav_menu']) ? $instance['nav_menu'] : '';

        // Get menus
        $menus = wp_get_nav_menus();
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'vtech'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:', 'vtech'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
                <option value="0"><?php _e('— Select —', 'vtech'); ?></option>
                <?php foreach ($menus as $menu): ?>
                    <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected($nav_menu, $menu->term_id); ?>>
                        <?php echo esc_html($menu->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['nav_menu'] = (!empty($new_instance['nav_menu'])) ? (int) $new_instance['nav_menu'] : 0;
        return $instance;
    }
}

// Custom Walker class for footer menu
class Footer_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $output .= '<ul class="sub-menu">';
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        if($args->walker->has_children) {
            $classes[] = 'menu-item-has-children';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names . '>';

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

// Register the widget
function register_footer_menu_widget() {
    register_widget('Footer_Menu_Widget');
}
add_action('widgets_init', 'register_footer_menu_widget');