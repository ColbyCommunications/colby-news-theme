<?php

/**
 * Register blocks and set a few block-related settings
 */

namespace NC_Blocks;

require_once(__DIR__ . '/acf-block-functions.php');

function register_colby_block_patterns()
{
    register_block_pattern_category('headers', [
        'label' => __('Headers', 'colby-news'),
    ]);
    register_block_pattern_category('colby-news', [
        'label' => __('Colby', 'colby-news'),
    ]);

    register_block_pattern(
        'colbycommunications/header-image',
        array(
            'title'       => __('Page Title with Image', 'colby-news-theme'),
            'description' => _x('Page title and optional description, set against a photo background.', 'Block pattern description', 'colby-news-theme'),
            'categories' => ['headers'],
            'content'     => "<!-- wp:cover {\"overlayColor\":\"black\",\"align\":\"full\"} --><div class=\"wp-block-cover alignfull has-black-background-color has-background-dim\"><div class=\"wp-block-cover__inner-container\"><!-- wp:post-title {\"textAlign\":\"center\",\"level\":1,\"textColor\":\"white\"} /--><!-- wp:paragraph {\"align\":\"center\",\"textColor\":\"white\",\"fontSize\":\"large\",\"placeholder\":\"" . _x('Add description here', 'colby-news') . "\"} --><p class=\"has-text-align-center has-white-color has-text-color has-large-font-size\"></p><!-- /wp:paragraph --></div></div><!-- /wp:cover -->",
            )
    );

}
add_action('init', 'NC_Blocks\register_colby_block_patterns');

add_action('wp_enqueue_scripts', 'NC_Blocks\nc_replace_block_library', 100);
add_action('admin_enqueue_scripts', 'NC_Blocks\nc_replace_block_library', 100);

function nc_replace_block_library()
{
    wp_dequeue_style('wp-block-library');
    wp_enqueue_style(
        'nc-block-library',
        get_template_directory_uri() . '/css/blocks.css',
        [],
        filemtime(get_template_directory() . '/css/blocks.css')
    );
}

/**
 * Display a notice if ACF Pro is not activated
 */
add_action('admin_notices', 'NC_Blocks\acf_activation_notice');
function acf_activation_notice()
{
    if (!function_exists('acf_register_block_type')) {
        ?>
        <div class="notice notice-error">
            <p>
                A plugin required by this theme, <strong>Advanced Custom Fields Pro</strong>,
                is not activated. <strong>Important:</strong> the free version of Advanced Custom Fields
                found in the WordPress plugins directory will not work.
            </p>
        </div>
        <?php
    }
}

add_action('admin_enqueue_scripts', 'NC_Blocks\nc_enqueue_admin_scripts');
function nc_enqueue_admin_scripts()
{
    if (file_exists(get_template_directory() . '/style-admin.css')) {
        wp_enqueue_style('nc-admin-styles', get_template_directory_uri() . '/style-admin.css');
    }
}

/**
 * Register custom ACF blocks
 */
add_action('acf/init', function () {
    if (function_exists('acf_register_block_type')) {
        $post_type = get_post_type_from_editor();

        $always_allow = !$post_type || $post_type === 'acf-field-group';
        // Blocks to register for all post types

        acf_register_block_type([
            'name' => 'nc-teaser-pair',
            'title' => __('Teaser Pair', 'colby-news-theme'),
            'description' => __(
                'Two teasers, side-by-side.',
                'colby-news-theme'
            ),
            'category' => 'colby-news',
            'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><path d="M1.95 16.82h9v1h-9Z" id="a"/><path d="M1.95 19.49h7.03v1H1.94Z" id="c"/><path d="M1.95 18.16h7.73v1H1.95Z" id="b"/></defs><path fill="none" d="M0 0h24v24H0Z" transform="rotate(90 12 12)"/><g><path d="M22.033 14.013h-9V4.98h9v9.024Z" transform="rotate(90 17.533 9.5)"/><path d="M10.945 13.99H1.96v-9h8.98v9Z" transform="rotate(90 6.455 9.489)"/></g><g transform="translate(-.001-1.5)"><g><use xlink:href="#a"/><use xlink:href="#b"/><use xlink:href="#c"/></g></g><g transform="translate(11.065-1.5)"><g><use xlink:href="#a"/><use xlink:href="#b"/><use xlink:href="#c"/></g></g></svg>',
            'render_callback' => 'NC_Blocks\teaser_pair_block',
            'supports' => ['align' => false, 'multiple' => true],
            'enqueue_assets' => function () {
                wp_enqueue_script(
                    'linkify',
                    get_template_directory_uri() . '/js/linkify.js',
                    [],
                    '',
                    true
                );
            },
        ]);

        acf_register_block_type([
            'name' => 'nc-breaker-feature',
            'title' => __('Breaker Feature', 'colby-news-theme'),
            'description' => __(
                'Image with text overlay that fills page width',
                'colby-news-theme'
            ),
            'category' => 'colby-news',
            'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0Z" transform="rotate(90 12 12)"/><path d="M.002 18.926V5.06H23.99v13.85Zm2.172-8.03h19.651V9.58H2.17Zm0 1.75h16.878V11.33H2.17Zm0 1.75h15.35V13.08H2.16Z"/></svg>',
            'render_callback' => 'NC_Blocks\breaker_feature',
            'supports' => ['align' => false, 'multiple' => true],
        ]);


        // Blocks to register except on `post` post type
        if ($always_allow || $post_type !== 'post') {
            acf_register_block_type([
                'name' => 'nc-featured-story',
                'title' => __('Featured Story', 'colby-news-theme'),
                'description' => __(
                    'Large image plus text, similar to a Story post header.',
                    'colby-news-theme'
                ),
                'category' => 'colby-news',
                'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0Z" transform="rotate(90 12 12)"/><path d="M11.05 16.5H2.07v-9h8.98v9Z" transform="rotate(90 6.564 11.999)"/><g transform="translate(10.978-6.594)"><g><path d="M1.95 16.82h9v1h-9Z"/><path d="M1.95 18.16h7.73v1H1.95Z"/><path d="M1.95 19.49h7.03v1H1.94Z"/></g></g></svg>',
                'render_callback' => 'NC_Blocks\featured_story_large',
                'supports' => ['align' => false, 'multiple' => true],
            ]);

            acf_register_block_type([
                'name' => 'nc-post-list-slider',
                'title' => __('Post List Slider', 'colby-news-theme'),
                'description' => __(
                    'List of posts displayed as a horizontal slider.',
                    'colby-news-theme'
                ),
                'category' => 'colby-news',
                'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><path d="M-123.77-227.089l-6.83-6.68c-.16-.16-.37-.24-.6-.24 -.23 0-.44.08-.6.23l-.51.49c-.33.32-.33.84 0 1.16l5.72 5.6 -5.74 5.61c-.16.15-.25.36-.25.58 0 .22.08.42.24.58l.5.49c.15.15.36.23.59.23 .22 0 .43-.09.59-.24l6.82-6.68c.15-.16.24-.37.24-.59 0-.23-.09-.43-.25-.59Z" id="a"/></defs><path fill="none" d="M0 0h24v24H0Z" transform="rotate(90 12 12)"/><g transform="translate(0 2.632)"><g><path d="M10 3.19h4v-4h-4v4Zm0 12h4v-4h-4v4Zm0-6h4v-4h-4v4Z" transform="rotate(90 12 7.198)"/><use transform="matrix(.187 0 0 .187 42.168 54.616)" xlink:href="#a"/><use transform="matrix(-.188 0 0 .187-18.169 54.616)" xlink:href="#a"/></g><g transform="translate(.495.034)"><g><path d="M8.25 11.57a.52.52 0 1 0 0 1.04 .52.52 0 1 0 0-1.05Z"/><path d="M9.87 11.57a.52.52 0 1 0 0 1.04 .52.52 0 1 0 0-1.05Z"/><path d="M11.5 11.57a.52.52 0 1 0 0 1.04 .52.52 0 1 0 0-1.05Z"/><path d="M13.13 11.57a.52.52 0 1 0 0 1.04 .52.52 0 1 0 0-1.05Z"/><path d="M14.75 11.57a.52.52 0 1 0 0 1.04 .52.52 0 1 0 0-1.05Z"/></g></g></g></svg>',
                'render_callback' => 'NC_Blocks\post_list_slider_block',
                'supports' => ['align' => false, 'multiple' => true, 'jsx' => true],
                'enqueue_assets' => function () {
                    wp_enqueue_script(
                        'sliding-teasers',
                        get_template_directory_uri() . '/js/sliding-teasers.js',
                        [],
                        '',
                        true
                    );
                    wp_enqueue_script(
                        'linkify',
                        get_template_directory_uri() . '/js/linkify.js',
                        [],
                        '',
                        true
                    );
                },
            ]);

            acf_register_block_type([
                'name' => 'nc-slider-with-teaser-pair',
                'title' => __('Teaser Pair with Slider', 'colby-news-theme'),
                'description' => __(
                    'List of posts, with first two displayed as a Teaser Pair and the rest displayed as a Post List slider.',
                    'colby-news-theme'
                ),
                'category' => 'colby-news',
                'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0Z" transform="rotate(90 12 12)"/><g transform="translate(0 2.189)"><g><path d="M19.991 10.333h-7V3.31h7v7.01Z" transform="rotate(90 16.491 6.824)"/><path d="M10 16.296h4v-4h-4v4Z" transform="rotate(90 12 14.295)"/><path d="M4 16.296h4v-4H4v4Z" transform="rotate(90 6 14.295)"/><path d="M16 16.296h4v-4h-4v4Z" transform="rotate(90 18 14.296)"/><path d="M11.008 10.332H4V3.31h7v7.01Z" transform="rotate(90 7.508 6.824)"/></g></g></svg>',
                'render_callback' => 'NC_Blocks\slider_with_teaser_pair_block',
                'supports' => ['align' => false, 'multiple' => true],
                'enqueue_assets' => function () {
                    wp_enqueue_script(
                        'linkify',
                        get_template_directory_uri() . '/js/linkify.js',
                        [],
                        '',
                        true
                    );
                },
            ]);

            acf_register_block_type([
                'name' => 'nc-video-slider',
                'title' => __('YouTube Video Slider', 'colby-news-theme'),
                'description' => __(
                    'List of YouTube videos, with first two optionally displayed as a Teaser Pair and the rest displayed as a slider.',
                    'colby-news-theme'
                ),
                'category' => 'colby-news',
                'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0Z" transform="rotate(90 12 12)"/><g><path d="M10 18.48h4v-4h-4v4Z" transform="rotate(90 11.999 16.485)"/><path d="M4 18.48h4v-4H4v4Z" transform="rotate(90 5.999 16.485)"/><path d="M16 18.48h4v-4h-4v4Z" transform="rotate(90 17.999 16.485)"/><path d="M4 12.514v-7h7.016v7ZM6.753 7.6v2.82L9.202 9Z"/><path d="M12.984 12.514v-7H20v7Zm2.75-4.914v2.82L18.174 9Z"/></g></svg>',
                'render_callback' => 'NC_Blocks\video_slider_block',
                'supports' => ['align' => false, 'multiple' => true],
                'enqueue_assets' => function () {
                    wp_enqueue_script(
                        'linkify',
                        get_template_directory_uri() . '/js/linkify.js',
                        [],
                        '',
                        true
                    );
                },
            ]);

            acf_register_block_type([
                'name' => 'nc-external-posts-list',
                'title' => __('External Posts List', 'colby-news-theme'),
                'description' => __(
                    'List of posts of the External Posts type.',
                    'colby-news-theme'
                ),
                'category' => 'colby-news',
                'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0Z"/><path d="M4 14h4v-4H4v4Zm0 5h4v-4H4v4ZM4 9h4V5H4v4Zm5 5h12v-4H9v4Zm0 5h12v-4H9v4ZM9 5v4h12V5H9Z"/></svg>',
                'render_callback' => 'NC_Blocks\external_post_list',
                'supports' => ['align' => false, 'multiple' => true],
            ]);
        }

        if ($always_allow || $post_type === 'post') {
            // Register blocks that should only appear on posts
            acf_register_block_type([
                'name' => 'nc-related-posts',
                'title' => __('Related Posts', 'colby-news-theme'),
                'description' => __(
                    'List of posts that share the same Primary Category as the current post.',
                    'colby-news-theme'
                ),
                'category' => 'colby-news',
                'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0Z"/><path d="M4 14h4v-4H4v4Zm0 5h4v-4H4v4ZM4 9h4V5H4v4Zm5 5h12v-4H9v4Zm0 5h12v-4H9v4ZM9 5v4h12V5H9Z"/></svg>',
                'render_callback' => 'NC_Blocks\related_posts_block',
                'supports' => ['align' => false, 'multiple' => true],
            ]);
        }
    }
});
