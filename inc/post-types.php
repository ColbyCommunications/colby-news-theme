<?php

//Register Custom Post Types

function nc_register_external_posts()
{
    $labels = [
        'name' => _x('External Posts', 'colby-news-theme'),
        'singular_name' => _x('External Post', 'colby-news-theme'),
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
        'rewrite'            => array( 'slug' => 'external', 'with_front' => false ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies'         => array( 'media_source', 'category', 'story_type', 'post_tag' )
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

function nc_register_story_types()
{
    $labels = [
        'name' => _x('Story Types', 'colby-news'),
        'singular_name' => _x('Story Type', 'colby-news'),
        'search_items'      => _x('Search Story Types', 'colby-news'),
        'all_items'         => _x('All Story Types', 'colby-news'),
        'edit_item'         => _x('Edit Story Type', 'colby-news'),
        'update_item'       => _x('Update Story Type', 'colby-news'),
        'add_new_item'      => _x('Add New Type', 'colby-news'),
        'new_item_name'     => _x('New Story Type Name', 'colby-news'),
    ];

    $args = array(
        'labels'            => $labels,
        'description'       => _x('Type of external post, used for category-based archives', 'colby-news'),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        // 'rewrite'           => array( 'slug' => 'story_type' ),
    );

    register_taxonomy('story_type', array( 'external_post' ), $args);
}
add_action('init', 'nc_register_story_types');

add_action('init', function () {
    add_rewrite_rule('external/([a-z0-9-]+)[/]?$', 'index.php?post_type=external_post&story_type=$matches[1]', 'top');
});
