<?php

namespace App;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    collect(['get_header', 'wp_head'])->each(function ($tag) {
        ob_start();
        do_action($tag);
        $output = ob_get_clean();
        remove_all_actions($tag);
        add_action($tag, function () use ($output) {
            echo $output;
        });
    });
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Render comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );

    $data = collect(get_body_class())->reduce(function ($data, $class) use ($comments_template) {
        return apply_filters("sage/template/{$class}/data", $data, $comments_template);
    }, []);

    $theme_template = locate_template(["views/{$comments_template}", $comments_template]);

    if ($theme_template) {
        echo template($theme_template, $data);
        return get_stylesheet_directory().'/index.php';
    }

    return $comments_template;
}, 100);

// function processPosts($posts) {
//     $new_posts = [];
//     foreach($posts as $post){
//         array_push($new_posts, (object) array_merge( (array) $post, (array) ['meta' => get_post_meta($post->ID), 'image' => wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full")]));
//     }
//     return $new_posts;
// }

// add_action( 'rest_api_init', function() {
        
//     register_rest_route('news/v1', '/in-the-news', array(
//             'methods'  => 'GET',
//             'callback' => function() {
//                 $args_featured_story = [
//                     'post_type' => 'post',
//                     'posts_per_page'=> 1,
//                     'order' => 'DESC',
//                     'orderby' => 'ID',
//                     'category_name' => 'in-the-news',
//                     'meta_key'     => 'featured_story',
//                     'meta_value'   => 1,
//                     'meta_compare' => '=',
//                     ];
        
//                 $query_featured_story = new \WP_Query($args_featured_story);
//                 $args_spotlight_stories = [
//                     'post_type' => 'post',
//                     'posts_per_page'=> 2,
//                     'order' => 'DESC',
//                     'orderby' => 'ID',
//                     'category_name' => 'in-the-news',
//                     'meta_query' => array(
//                         'meta_key'     => 'spotlight_story',
//                         'meta_value'   => 1,
//                         'meta_compare' => '=',
//                     )
//                     ];

        
//                 $query_spotlight_stories = new \WP_Query($args_spotlight_stories);

//                 $args_masonry_stories = [
//                     'post_type' => 'post',
//                     'posts_per_page'=> -1,
//                     'order' => 'DESC',
//                     'orderby' => 'ID',
//                     'category_name' => 'in-the-news',
//                     'post__not_in' => [$query_featured_story->posts[0]->ID, $query_spotlight_stories->posts[0]->ID, $query_spotlight_stories->posts[1]->ID],
//                     ];

//                 $query_masonry_stories = new \WP_Query($args_masonry_stories);

//                 $featured_story_meta = get_post_meta($query_featured_story->posts[0]->ID);
                
//                 $results = ['data' => [
//                     'featured_story' => (object) array_merge( (array) $query_featured_story->posts[0], (array) ['meta' => $featured_story_meta, 'image' => wp_get_attachment_image_src(get_post_thumbnail_id($query_featured_story->posts[0]->ID), "full")]),
//                     'spotlight_stories' => processPosts($query_spotlight_stories->posts),
//                     'masonry_stories' => processPosts($query_masonry_stories->posts),
                    
//                 ]];

//                 return $results;
//             },
//     ));
// } );
