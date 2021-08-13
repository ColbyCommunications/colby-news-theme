<?php

//Register Custom Post Types

function nc_register_external_posts()
{
    $labels = [
        'name' => _x('External Post', 'colby-news-theme'),
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'book' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies'         => array( 'media_source', 'category', 'post_tag' )
    ];

    register_post_type('external_post', $args);
}
add_action('init', 'nc_register_external_posts');

function nc_register_external_sources()
{
    $labels = [
        'name' => _x('Media Source', 'colby-news'),
        'singular_name' => _x('Media Source', 'colby-news'),
        'search_items'      => _x('Search Media Sources', 'colby-news'),
        'all_items'         => _x('All Media Sources', 'colby-news'),
        'edit_item'         => _x('Edit Media Source', 'colby-news'),
        'update_item'       => _x('Update Media Source', 'colby-news'),
        'add_new_item'      => _x('Add New Source', 'colby-news'),
        'new_item_name'     => _x('New Media Source Name', 'colby-news'),
        'menu_name'         => _x('Media Source', 'colby-news'),
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