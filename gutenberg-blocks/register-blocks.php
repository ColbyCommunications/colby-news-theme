<?php

/**
 * Register blocks and set a few block-related settings
 */

namespace NC_Blocks;

require_once(__DIR__ . '/acf-block-functions.php');

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
            'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M22.089 23.98c-.05 0-.09-.01-.13-.01H2.02c-.05 0-.09 0-.13 0 -.528 0-.973-.38-1.057-.9 -.05-.27.01-.54.16-.76L11.09 2.13c.29-.583.72-.645.89-.645 .21 0 .61.08.89.645L22.96 22.311c.31.47.19 1.12-.27 1.45 -.19.13-.4.2-.63.2ZM1.89 22.8c-.02.02-.03.04-.05.06 -.02.01-.02.03-.02.05 0 .03.03.05.06.05 .03-.01.06-.01.09-.01h20c.02 0 .05 0 .08 0 0 0 0 0 0 0 .02 0 .03-.01.04-.02 .03-.03.03-.07.01-.1 -.02-.02-.03-.05-.05-.07L11.94 2.54V2.54L1.83 22.75Z"/><path d="M11.996 17.479c-.28 0-.5-.23-.5-.5v-7c0-.28.22-.5.5-.5 .27 0 .5.22.5.5v7c0 .27-.23.5-.5.5Z"/><path d="M12.01 19.979c-.42-.01-.75-.32-.77-.73 -.01-.21.06-.4.2-.55 .13-.15.32-.23.52-.24 .42 0 .75.32.76.72 0 .2-.07.39-.21.54 -.14.14-.33.22-.53.23 -.01-.01-.01-.01-.01-.01s0 0 0 0Z"/></g></svg>',
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
            'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M22.089 23.98c-.05 0-.09-.01-.13-.01H2.02c-.05 0-.09 0-.13 0 -.528 0-.973-.38-1.057-.9 -.05-.27.01-.54.16-.76L11.09 2.13c.29-.583.72-.645.89-.645 .21 0 .61.08.89.645L22.96 22.311c.31.47.19 1.12-.27 1.45 -.19.13-.4.2-.63.2ZM1.89 22.8c-.02.02-.03.04-.05.06 -.02.01-.02.03-.02.05 0 .03.03.05.06.05 .03-.01.06-.01.09-.01h20c.02 0 .05 0 .08 0 0 0 0 0 0 0 .02 0 .03-.01.04-.02 .03-.03.03-.07.01-.1 -.02-.02-.03-.05-.05-.07L11.94 2.54V2.54L1.83 22.75Z"/><path d="M11.996 17.479c-.28 0-.5-.23-.5-.5v-7c0-.28.22-.5.5-.5 .27 0 .5.22.5.5v7c0 .27-.23.5-.5.5Z"/><path d="M12.01 19.979c-.42-.01-.75-.32-.77-.73 -.01-.21.06-.4.2-.55 .13-.15.32-.23.52-.24 .42 0 .75.32.76.72 0 .2-.07.39-.21.54 -.14.14-.33.22-.53.23 -.01-.01-.01-.01-.01-.01s0 0 0 0Z"/></g></svg>',
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
                'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M22.089 23.98c-.05 0-.09-.01-.13-.01H2.02c-.05 0-.09 0-.13 0 -.528 0-.973-.38-1.057-.9 -.05-.27.01-.54.16-.76L11.09 2.13c.29-.583.72-.645.89-.645 .21 0 .61.08.89.645L22.96 22.311c.31.47.19 1.12-.27 1.45 -.19.13-.4.2-.63.2ZM1.89 22.8c-.02.02-.03.04-.05.06 -.02.01-.02.03-.02.05 0 .03.03.05.06.05 .03-.01.06-.01.09-.01h20c.02 0 .05 0 .08 0 0 0 0 0 0 0 .02 0 .03-.01.04-.02 .03-.03.03-.07.01-.1 -.02-.02-.03-.05-.05-.07L11.94 2.54V2.54L1.83 22.75Z"/><path d="M11.996 17.479c-.28 0-.5-.23-.5-.5v-7c0-.28.22-.5.5-.5 .27 0 .5.22.5.5v7c0 .27-.23.5-.5.5Z"/><path d="M12.01 19.979c-.42-.01-.75-.32-.77-.73 -.01-.21.06-.4.2-.55 .13-.15.32-.23.52-.24 .42 0 .75.32.76.72 0 .2-.07.39-.21.54 -.14.14-.33.22-.53.23 -.01-.01-.01-.01-.01-.01s0 0 0 0Z"/></g></svg>',
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
                'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M22.089 23.98c-.05 0-.09-.01-.13-.01H2.02c-.05 0-.09 0-.13 0 -.528 0-.973-.38-1.057-.9 -.05-.27.01-.54.16-.76L11.09 2.13c.29-.583.72-.645.89-.645 .21 0 .61.08.89.645L22.96 22.311c.31.47.19 1.12-.27 1.45 -.19.13-.4.2-.63.2ZM1.89 22.8c-.02.02-.03.04-.05.06 -.02.01-.02.03-.02.05 0 .03.03.05.06.05 .03-.01.06-.01.09-.01h20c.02 0 .05 0 .08 0 0 0 0 0 0 0 .02 0 .03-.01.04-.02 .03-.03.03-.07.01-.1 -.02-.02-.03-.05-.05-.07L11.94 2.54V2.54L1.83 22.75Z"/><path d="M11.996 17.479c-.28 0-.5-.23-.5-.5v-7c0-.28.22-.5.5-.5 .27 0 .5.22.5.5v7c0 .27-.23.5-.5.5Z"/><path d="M12.01 19.979c-.42-.01-.75-.32-.77-.73 -.01-.21.06-.4.2-.55 .13-.15.32-.23.52-.24 .42 0 .75.32.76.72 0 .2-.07.39-.21.54 -.14.14-.33.22-.53.23 -.01-.01-.01-.01-.01-.01s0 0 0 0Z"/></g></svg>',
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
                'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M22.089 23.98c-.05 0-.09-.01-.13-.01H2.02c-.05 0-.09 0-.13 0 -.528 0-.973-.38-1.057-.9 -.05-.27.01-.54.16-.76L11.09 2.13c.29-.583.72-.645.89-.645 .21 0 .61.08.89.645L22.96 22.311c.31.47.19 1.12-.27 1.45 -.19.13-.4.2-.63.2ZM1.89 22.8c-.02.02-.03.04-.05.06 -.02.01-.02.03-.02.05 0 .03.03.05.06.05 .03-.01.06-.01.09-.01h20c.02 0 .05 0 .08 0 0 0 0 0 0 0 .02 0 .03-.01.04-.02 .03-.03.03-.07.01-.1 -.02-.02-.03-.05-.05-.07L11.94 2.54V2.54L1.83 22.75Z"/><path d="M11.996 17.479c-.28 0-.5-.23-.5-.5v-7c0-.28.22-.5.5-.5 .27 0 .5.22.5.5v7c0 .27-.23.5-.5.5Z"/><path d="M12.01 19.979c-.42-.01-.75-.32-.77-.73 -.01-.21.06-.4.2-.55 .13-.15.32-.23.52-.24 .42 0 .75.32.76.72 0 .2-.07.39-.21.54 -.14.14-.33.22-.53.23 -.01-.01-.01-.01-.01-.01s0 0 0 0Z"/></g></svg>',
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
                'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M22.089 23.98c-.05 0-.09-.01-.13-.01H2.02c-.05 0-.09 0-.13 0 -.528 0-.973-.38-1.057-.9 -.05-.27.01-.54.16-.76L11.09 2.13c.29-.583.72-.645.89-.645 .21 0 .61.08.89.645L22.96 22.311c.31.47.19 1.12-.27 1.45 -.19.13-.4.2-.63.2ZM1.89 22.8c-.02.02-.03.04-.05.06 -.02.01-.02.03-.02.05 0 .03.03.05.06.05 .03-.01.06-.01.09-.01h20c.02 0 .05 0 .08 0 0 0 0 0 0 0 .02 0 .03-.01.04-.02 .03-.03.03-.07.01-.1 -.02-.02-.03-.05-.05-.07L11.94 2.54V2.54L1.83 22.75Z"/><path d="M11.996 17.479c-.28 0-.5-.23-.5-.5v-7c0-.28.22-.5.5-.5 .27 0 .5.22.5.5v7c0 .27-.23.5-.5.5Z"/><path d="M12.01 19.979c-.42-.01-.75-.32-.77-.73 -.01-.21.06-.4.2-.55 .13-.15.32-.23.52-.24 .42 0 .75.32.76.72 0 .2-.07.39-.21.54 -.14.14-.33.22-.53.23 -.01-.01-.01-.01-.01-.01s0 0 0 0Z"/></g></svg>',
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
                'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M22.089 23.98c-.05 0-.09-.01-.13-.01H2.02c-.05 0-.09 0-.13 0 -.528 0-.973-.38-1.057-.9 -.05-.27.01-.54.16-.76L11.09 2.13c.29-.583.72-.645.89-.645 .21 0 .61.08.89.645L22.96 22.311c.31.47.19 1.12-.27 1.45 -.19.13-.4.2-.63.2ZM1.89 22.8c-.02.02-.03.04-.05.06 -.02.01-.02.03-.02.05 0 .03.03.05.06.05 .03-.01.06-.01.09-.01h20c.02 0 .05 0 .08 0 0 0 0 0 0 0 .02 0 .03-.01.04-.02 .03-.03.03-.07.01-.1 -.02-.02-.03-.05-.05-.07L11.94 2.54V2.54L1.83 22.75Z"/><path d="M11.996 17.479c-.28 0-.5-.23-.5-.5v-7c0-.28.22-.5.5-.5 .27 0 .5.22.5.5v7c0 .27-.23.5-.5.5Z"/><path d="M12.01 19.979c-.42-.01-.75-.32-.77-.73 -.01-.21.06-.4.2-.55 .13-.15.32-.23.52-.24 .42 0 .75.32.76.72 0 .2-.07.39-.21.54 -.14.14-.33.22-.53.23 -.01-.01-.01-.01-.01-.01s0 0 0 0Z"/></g></svg>',
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
                'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M22.089 23.98c-.05 0-.09-.01-.13-.01H2.02c-.05 0-.09 0-.13 0 -.528 0-.973-.38-1.057-.9 -.05-.27.01-.54.16-.76L11.09 2.13c.29-.583.72-.645.89-.645 .21 0 .61.08.89.645L22.96 22.311c.31.47.19 1.12-.27 1.45 -.19.13-.4.2-.63.2ZM1.89 22.8c-.02.02-.03.04-.05.06 -.02.01-.02.03-.02.05 0 .03.03.05.06.05 .03-.01.06-.01.09-.01h20c.02 0 .05 0 .08 0 0 0 0 0 0 0 .02 0 .03-.01.04-.02 .03-.03.03-.07.01-.1 -.02-.02-.03-.05-.05-.07L11.94 2.54V2.54L1.83 22.75Z"/><path d="M11.996 17.479c-.28 0-.5-.23-.5-.5v-7c0-.28.22-.5.5-.5 .27 0 .5.22.5.5v7c0 .27-.23.5-.5.5Z"/><path d="M12.01 19.979c-.42-.01-.75-.32-.77-.73 -.01-.21.06-.4.2-.55 .13-.15.32-.23.52-.24 .42 0 .75.32.76.72 0 .2-.07.39-.21.54 -.14.14-.33.22-.53.23 -.01-.01-.01-.01-.01-.01s0 0 0 0Z"/></g></svg>',
                'render_callback' => 'NC_Blocks\related_posts_block',
                'supports' => ['align' => true, 'multiple' => true],
            ]);
        }
    }
});
