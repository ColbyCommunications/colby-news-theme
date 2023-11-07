<?php

/** Register Gutenberg templates */

namespace NC_Blocks;

// add_filter('default_page_template_title', function () {
//     return __('Page (Default)', 'colby-news-theme');
// });

function nc_blog_post_block_types($allowed_block_types, $block_editor_context)
{
    $post = $block_editor_context->post;
    // if ($post->post_type === 'page') {
    // $allowed_block_types = [
    //     'acf/nc-page-header',
    //     'acf/nc-background-block',
    //     'acf/nc-link-list-horizontal',
    //     'acf/nc-inset-aside',
    //     'acf/nc-alert',
    //     'acf/nc-image-row',
    //     'pb/accordion-item',
    //     'core/block',
    //     'core/buttons',
    //     'core/group',
    //     'core/quote',
    //     'core/columns',
    //     'core/embed',
    //     'core/html',
    //     'core/gallery',
    //     'core/image',
    //     'core/list',
    //     'core/paragraph',
    //     'core/preformatted',
    //     'core/shortcode',
    //     'core/table',
    //     'core/video',
    //     'core/video',
    //     'core/heading',
    // ];
    // }

    return $allowed_block_types;
}
add_filter('allowed_block_types_all', 'NC_Blocks\nc_blog_post_block_types', 10, 2);

function nc_register_templates()
{
    $post_type_object = get_post_type_object('post');
    $post_type_object->template = array(
        ['core/paragraph'],
        // ['acf/nc-related-posts'],
        // ['core/block', [
        //     'ref' => 11949
        // ],
        // ],
        // ['core/heading', [
        //     'content' => __('Highlights', 'colby-news'),
        //     'className' => 'is-style-large-heading'
        // ]],
        // ['acf/nc-teaser-pair', [
        //     'data' => [
        //         'tags' => [92],
        //         'posts_per_page' => 2
        //     ],
        // ]],
        // ['core/separator'],
    );
}
add_action('init', 'NC_Blocks\nc_register_templates');
