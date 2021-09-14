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

// Register custom taxonomies

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

// Change title of category archives

add_filter('get_the_archive_title', function ($title) {
    if (is_post_type_archive('external_post') && $story_type = get_query_var('story_type')) {
        $story_type_object = get_term_by('slug', $story_type, 'story_type');
        $title = $story_type_object->name;
    } elseif (is_category()) {
        $title = single_cat_title('', false);
    }

    return $title;
});

function colby_story_type_title($title)
{
    if (is_post_type_archive('external_post')) {
        if ($story_type = get_query_var('story_type')) {
            global $page, $paged;

            $title_array = [];

            $story_type_object = get_term_by('slug', $story_type, 'story_type');
            $title_array['title'] = $story_type_object->name;

            // Add a page number if necessary.
            if (( $paged >= 2 || $page >= 2 ) && ! is_404()) {
                /* translators: %s: Page number. */
                $title_array['page'] = sprintf(__('Page %s'), max($paged, $page));
            }

            $title_array['site'] = get_bloginfo('name', 'display');

            /**
             * Filters the separator for the document title.
             *
             * @since 4.4.0
             *
             * @param string $sep Document title separator. Default '-'.
             */
            if (class_exists('WPSEO_Options')) {
                $yoast_options = new Yoast\WP\SEO\Helpers\Options_Helper();
                $sep = $yoast_options->get_title_separator();
            } else {
                $sep = apply_filters('document_title_separator', '-');
            }

            /**
             * Filters the parts of the document title.
             *
             * @since 4.4.0
             *
             * @param array $title {
             *     The document title parts.
             *
             *     @type string $title   Title of the viewed page.
             *     @type string $page    Optional. Page number if paginated.
             *     @type string $tagline Optional. Site description when on home page.
             *     @type string $site    Optional. Site title when not on home page.
             * }
             */
            $title_array = apply_filters('document_title_parts', $title_array);

            $title = implode(" $sep ", array_filter($title_array));

            /**
             * Filters the document title.
             *
             * @since 5.8.0
             *
             * @param string $title Document title.
             */
            $title = apply_filters('document_title', $title);
        }
    }
    return $title;
}

add_filter('pre_get_document_title', 'colby_story_type_title', 10, 1);
add_filter('wpseo_title', 'colby_story_type_title', 10, 1);
