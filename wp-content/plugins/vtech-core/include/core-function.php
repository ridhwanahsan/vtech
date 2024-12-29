<?php

    // get all category 
    function post_cat($category = 'category'){
        $categories = get_categories( array(
            'taxonomy' => $category,
            'orderby' => 'name',
            'order'   => 'ASC',
        ) );
        $cat_list = [];
        foreach($categories as $cat){
            $cat_list[$cat->slug] = $cat->name;
        }
        return $cat_list;
    }
    
    // get all post 
    function get_all_post($post_type_name = 'post'){
        $posts = get_posts( array(
            'post_type' => $post_type_name,
            'orderby' => 'name',
            'order'   => 'ASC'
        ) );
        $posts_list = [];
        foreach($posts as $post){
            $posts_list[$post->ID] = $post->post_title;
        }
        return $posts_list;
    }

    // get cat slug and name
function techub_get_cat_data($categories = [], $delimeter = ' ', $term = 'slug')
{
    $slugs = [];
    foreach ($categories as $cat) {
        if ($term == 'slug') {
            array_push($slugs, $cat->slug);
        }
        if ($term == 'name') {
            $slugs[] = $cat->name;
        }
    }
    return implode($delimeter, $slugs);
}
