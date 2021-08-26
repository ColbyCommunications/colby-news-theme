<?php

//Register Custom Post Types

function nc_register_external_posts()
{
    $labels = [
        'name' => _x('Media Coverage', 'colby-news-theme'),
        'singular_name' => _x('Media Coverage', 'colby-news-theme'),
        'search_items'      => _x('Search External Media Posts', 'colby-news'),
        'all_items'         => _x('All External Media Posts', 'colby-news'),
        'edit_item'         => _x('Edit External Media Post', 'colby-news'),
        'update_item'       => _x('Update External Media Post', 'colby-news'),
        'add_new_item'      => _x('Add New External Media Post', 'colby-news'),
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'media' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies'         => array( 'media_source', 'category', 'post_tag' )
    ];

    register_post_type('external_post', $args);
}
add_action('init', 'nc_register_external_posts');

function nc_register_external_sources()
{
    $labels = [
        'name' => _x('Media Sources', 'colby-news'),
        'singular_name' => _x('Media Source', 'colby-news'),
        'search_items'      => _x('Search Media Sources', 'colby-news'),
        'all_items'         => _x('All Media Sources', 'colby-news'),
        'edit_item'         => _x('Edit Media Source', 'colby-news'),
        'update_item'       => _x('Update Media Source', 'colby-news'),
        'add_new_item'      => _x('Add New Source', 'colby-news'),
        'new_item_name'     => _x('New Media Source Name', 'colby-news'),
    ];

    $args = array(
        'labels'            => $labels,
        'description'       => _x('Publication or site that hosts an external post', 'colby-news'),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'source' ),
    );

    register_taxonomy('media_source', array( 'external_post' ), $args);
}
add_action('init', 'nc_register_external_sources');


function algolia_post_to_record(WP_Post $post)
{
    $tags = array_map(function (WP_Term $term) {
        return $term->name;
    }, wp_get_post_terms($post->ID, 'post_tag'));

    return [
        'objectID' => implode('#', [$post->post_type, $post->ID]),
        'title' => $post->post_title,
        'author' => [
            'id' => $post->post_author,
            'name' => get_user_by('ID', $post->post_author)->display_name,
        ],
        'excerpt' => $post->post_excerpt,
        'content' => strip_tags($post->post_content),
        'tags' => $tags,
        'url' => get_post_permalink($post->ID),
        // 'custom_field' => get_post_meta($post->id, 'custom_field_name'),
    ];
}

add_filter('post_to_record', 'algolia_post_to_record');

function algolia_term_to_record(WP_Post $term)
{
    return [
        'objectID' => implode('#', [$term->taxonomy, $term->term_id]),
        'name' => $term->name,
        'slug' => $term->slug,
        'url' => get_term_link($term),
        'description' => $term->description,
        // 'custom_field' => get_post_meta($post->id, 'custom_field_name'),
    ];
}
add_filter('term_to_record', 'algolia_term_to_record');


function algolia_get_post_settings($defaultSettings) {
    return [
        'hitsPerPage' => 18,
        'searchableAttributes' => ['title', 'content', 'author.name'],
        'replicas' => [
            'post_replica'
        ],
    ];
}
add_filter('get_post_settings', 'algolia_get_post_settings');

function algolia_get_post_synonyms($defaultSynonyms)
{
    if (file_exists(get_template_directory() . '/my-synonyms.json')) {
        return json_decode(
            file_get_contents(get_template_directory() . '/my-synonyms.json'),
            true
        );
    }

    return $defaultSynonyms;
}
add_filter('get_post_synonyms', 'algolia_get_post_synonyms');

function algolia_get_post_replica_settings($defaultSettings) {
    return [
        'hitsPerPage' => 100,
    ];
}
add_filter('get_post_replica_settings', 'algolia_get_post_replica_settings');
