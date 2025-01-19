<?php 
// Custom Post Type: Project
function custom_post_type_project()
{
    $labels = array(
        'name' => __('Projects'),
        'singular_name' => __('Project'),
        'menu_name' => __('Projects'),
        'name_admin_bar' => __('Project'),
        'add_new' => __('Add New'),
        'add_new_item' => __('Add New Project'),
        'new_item' => __('New Project'),
        'edit_item' => __('Edit Project'),
        'view_item' => __('View Project'),
        'all_items' => __('All Projects'),
        'search_items' => __('Search Projects'),
        'not_found' => __('No projects found.'),
        'not_found_in_trash' => __('No projects found in Trash.'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'project'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
    );

    register_post_type('project', $args);
}
add_action('init', 'custom_post_type_project');

// Custom Taxonomy: Project Category
function custom_taxonomy_project_category()
{
    $labels = array(
        'name' => __('Project Categories'),
        'singular_name' => __('Project Category'),
        'search_items' => __('Search Categories'),
        'all_items' => __('All Categories'),
        'parent_item' => __('Parent Category'),
        'parent_item_colon' => __('Parent Category:'),
        'edit_item' => __('Edit Category'),
        'update_item' => __('Update Category'),
        'add_new_item' => __('Add New Category'),
        'new_item_name' => __('New Category Name'),
        'menu_name' => __('Categories'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'project-category'),
    );

    register_taxonomy('project_category', 'project', $args);
}
add_action('init', 'custom_taxonomy_project_category');


?>