<?php

/**
 * Register blocks and set a few block-related settings
 */

namespace NC_Blocks;

use Masterminds\HTML5;
use DOMXPath;
use Timber\Timber;

require_once(get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');
require_once(get_template_directory() . '/gutenberg-blocks/components/block-components.php');
require_once(\get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');

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
    if (!function_exists('acf_register_block')) {
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

add_action('after_setup_theme', 'NC_Blocks\remove_editor_panels');
function remove_editor_panels()
{
    // add_theme_support('disable-custom-colors');
    // add_theme_support('editor-color-palette');
    // add_theme_support('editor-gradient-presets', []);
    // add_theme_support('disable-custom-gradients');
    // add_theme_support('editor-font-sizes');
}

// add_filter(
//     'block_editor_settings_all',
//     function ($editor_settings) {
//         $editor_settings['__experimentalUseEditorFeature']['typography']['dropCap'] = false;
//         $editor_settings['disableCustomFontSizes'] = 1;
//         return $editor_settings;
//     }
// );

/**
 * Applies wrapper div around aligned blocks.
 *
 * Copy this function into your WordPress theme's `functions.php` file
 * and change the `themeprefix` accordingly.
 *
 * @see   https://developer.wordpress.org/reference/hooks/render_block/
 * @link  https://codepen.io/webmandesign/post/gutenberg-full-width-alignment-in-wordpress-themes
 *
 * @param  string $block_content  The block content about to be appended.
 * @param  array  $block          The full block, including name and attributes.
 */
function wrap_alignment($block_content, $block)
{
    if ($block_content && !empty($block['attrs']['align'])) {
        $html5 = new HTML5();
        $dom = $html5->loadHTML($block_content);

        $de = $dom ? $dom->documentElement : false;
        if ($de) {
            if ($de->isDefaultNamespace($de->namespaceURI)) {
                $de->removeAttributeNS($de->getAttributeNode("xmlns")->nodeValue, "");
                $dom->loadXML($dom->saveXML());
            }

            $xpath = new DOMXPath($dom);
            $blockElement = $xpath->query('//div')->item(0);
            if ($blockElement) {
                $currentClasses = explode(' ', $blockElement->getAttribute('class'));
                $currentClasses[] = 'wp-block';
                $blockElement->setAttribute('class', implode(' ', $currentClasses));
                $blockElement->setAttribute('data-align', $block['attrs']['align']);

                $dom->removeChild($dom->doctype);

                # remove <html><body></body></html>
                $dom->replaceChild($dom->firstChild->firstChild, $dom->firstChild);

                $block_content = $dom->saveHTML();
            }
        }
    }
    return $block_content;
}

add_filter('render_block', 'NC_Blocks\wrap_alignment', 10, 2);

add_filter('mce_css', 'NC_Blocks\nc_mce_styles');
function nc_mce_styles($url)
{
    if (!empty($url)) {
        $url .= ',';
    }

    // Retrieves the plugin directory URL and adds editor stylesheet
    // Change the path here if using different directories
    $url .= get_template_directory_uri() . '/css/editor-styles.css';

    return $url;
}

add_action('admin_notices', 'NC_Blocks\acfe_activation_notice');
function acfe_activation_notice()
{
    if (!class_exists('acfe')) {
        ?>
        <div class="notice notice-error">
            <p>
                A plugin required by this theme, <strong>Advanced Custom Fields: Extended</strong>,
                is not activated.
            </p>
        </div>
        <?php
    }
}

add_filter('acfe/fields/advanced_link/sub_fields', 'NC_Blocks\nc_advanced_link_no_target', 10, 10);
function nc_advanced_link_no_target($sub_fields, $field, $value)
{
    /**
     * @array $sub_fields   Sub fields array
     * @array $field        Advanced Link field
     * @array $value        Advanced Link values
     */

    if ($field['_name'] !== 'link_url' && $field['_name'] !== 'link_external') {
        $sub_fields = array_filter($sub_fields, function ($field) {
            return $field['name'] !== 'target';
        });
    }

    return $sub_fields;
}

add_filter('acfe/fields/advanced_link/sub_fields', 'NC_Blocks\nc_advanced_link_no_terms', 10, 3);
function nc_advanced_link_no_terms($sub_fields, $field, $value)
{
    /**
     * @array $sub_fields   Sub fields array
     * @array $field        Advanced Link field
     * @array $value        Advanced Link values
     */

    $sub_fields = array_map(function ($field) {
        if ($field['name'] === 'type') {
            $field['choices']['url'] = 'External URL';
            $field['choices']['post'] = 'Page in this CMS';

            unset($field['choices']['term']);
        }

        if ($field['name'] === 'url') {
            $field['label'] = 'External URL';
            $field['instructions'] = "Manually enter a web address (including colby.edu pages not starting with colby.edu/news/)";
        }

        if ($field['name'] === 'post') {
            $field['label'] = 'Page in this CMS';
            $field['instructions'] = "Select from pages inside the Admissions Wordpress site (those starting with colby.edu/news/)";
        }

        if ($field['name'] === 'target') {
            $field['message'] = 'Show the “External Link” icon';
        }

        return $field;
    }, $sub_fields);

    $sub_fields = array_filter($sub_fields, function ($field) {
        return $field['name'] !== 'term';
    });

    return $sub_fields;
}

add_filter('acfe/fields/advanced_link/sub_fields', 'NC_Blocks\nc_advanced_link_posts_only', 10, 3);
function nc_advanced_link_posts_only($sub_fields, $field, $value)
{
    /**
     * @array $sub_fields   Sub fields array
     * @array $field        Advanced Link field
     * @array $value        Advanced Link values
     */

    $sub_fields = array_map(function ($field) {
        if ($field['name'] === 'post') {
            $field['conditional_logic'] = [
                [
                    [
                        'field' => 'type',
                        'operator' => '==',
                        'value' => 'post',
                    ]
                ]
            ];
        }
        return $field;
    }, $sub_fields);

    return $sub_fields;
}

add_filter('acfe/fields/advanced_link/sub_fields/name=link_with_description', 'NC_Blocks\nc_advanced_link_with_description', 10, 3);
function nc_advanced_link_with_description($sub_fields, $field, $value)
{
    /**
     * @array $sub_fields   Sub fields array
     * @array $field        Advanced Link field
     * @array $value        Advanced Link values
     */


    $sub_fields[] = array(
        'name'      => 'description',
        'label'     => 'Description',
        'type'      => 'textarea',
    );

    return $sub_fields;
}

add_filter('acfe/fields/advanced_link/sub_fields/name=link_url', 'NC_Blocks\nc_advanced_link_url_only', 10, 3);
function nc_advanced_link_url_only($sub_fields, $field, $value)
{
    /**
     * @array $sub_fields   Sub fields array
     * @array $field        Advanced Link field
     * @array $value        Advanced Link values
     */


    $sub_fields = array_filter($sub_fields, function ($field) {
        return $field['name'] !== 'title';
    });

    return $sub_fields;
}

/**
 * Add a block category for theme-specific blocks
 *
 * @param array $categories Array of block categories.
 *
 * @return array
 */
function nc_block_categories($categories)
{
    $category_slugs = wp_list_pluck($categories, 'slug');
    return in_array('colby-news', $category_slugs, true) ? $categories : array_merge(
        array(
            array(
                'slug'  => 'colby-news',
                'title' => __('Colby News', 'colby-news-theme'),
                'icon'  => null,
            ),
        ),
        $categories
    );
}
add_filter('block_categories_all', 'NC_Blocks\nc_block_categories');

function innerBlocks($args = [])
{
    $default_args = [
        'allowed_blocks' => false,
        'template' => false,
        'templateLock' => null,
        'templateInsertUpdatesSelection' => false,
        'renderAppender' => false

    ];

    $args = wp_parse_args($args, $default_args);

    $innerBlocksTag = '<InnerBlocks ';

    if (is_array($args['allowed_blocks'])) {
        $innerBlocksTag .= ' allowedBlocks="' . esc_attr(wp_json_encode($args['allowed_blocks'])) . '" ';
    } elseif (is_string($args['allowed_blocks'])) {
        $innerBlocksTag .= ' allowedBlocks="' . esc_attr($args['allowed_blocks']) . '" ';
    }

    if (is_array($args['template'])) {
        $innerBlocksTag .= ' template="' . esc_attr(wp_json_encode($args['template'])) . '" ';
    } elseif (is_string($args['template'])) {
        $innerBlocksTag .= ' template="' . esc_attr($args['template']) . '" ';
    }

    if (isset($args['templateLock'])) {
        if ($args['templateLock'] === false) {
            $templateLock = 'false';
        } else {
            $templateLock = '\"' . $args['templateLock'] . '\"';
        }


        $innerBlocksTag .= ' templateLock=' . $templateLock . ' ';
    }

    if (!empty($args['templateInsertUpdatesSelection'])) {
        $innerBlocksTag .= ' templateInsertUpdatesSelection="' . $args['templateInsertUpdatesSelection'] . '" ';
    }

    if (!empty($args['renderAppender'])) {
        $innerBlocksTag .= ' renderAppender="' . $args['renderAppender'] . '" ';
    }

    return $innerBlocksTag . ' />';
}

function allowed_blocks_callback($block, $content = '', $is_preview = false, $post_id = 0)
{
    $allowed_blocks = [
        'acf/nc-rich-text',
        'core/table',
        'core/embed',
        'core/columns'
    ];

    $innerBlocks = innerBlocks([
        'allowed_blocks' => $allowed_blocks,
        'templateLock' => false,
    ]);

    if ($is_preview) {
        $innerBlocks = '<div class="nc-allowed-blocks">' . $innerBlocks . '</div>';
    }
    echo $innerBlocks;
}

function accordion_wrapper($block, $content = '', $is_preview = false, $post_id = 0)
{
    $allowed_blocks = [
        'pb/accordion-item',
    ];

    $template = [
        [
            'pb/accordion-item', [],
        ],
    ];

    $rowSpacing = '';

    if (function_exists('get_field')) {
        $rowSpacing = get_field('spaceAfter');
    }

    $rowSpacing = $rowSpacing ? $rowSpacing : 'md';
    $rowSpacing = get_row_spacing($rowSpacing);


    echo '<div class="mx-auto prose nc-accordion container-narrow px-container' . " $rowSpacing" . '">'
            . innerBlocks([
                'allowed_blocks' => $allowed_blocks,
                'template' => $template,
                'templateLock' => false
                ])
                 . '</div>';
}

function post_list_slider($block, $content = '', $is_preview = false, $post_id = 0)
{
    $allowed_blocks = [
        'core/query',
        'core/post-featured-image',
        'core/post-title',
        'core/post-date',
        'core/post-excerpt'
    ];

    $template = [
        [
            'core/query', [],
        ],
    ];

    $innerBlocks = innerBlocks([
        'allowed_blocks' => $allowed_blocks,
        'template' => $template,
        'templateLock' => false,
    ]);

    echo '<div class="py-4 nc-post-list-slider bg-tertiary">' . $innerBlocks . '</div>';
}

function alert_block($block, $content = '', $is_preview = false, $post_id = 0)
{
    $component = new Component();

    $rowSpacing = '';
    $body = '';

    if (function_exists('get_field')) {
        $rowSpacing = get_field('spaceAfter');

        $body = get_field('body');
    }

    $content = $component->build('iconFlag', [
        'content' => $body,
        'className' => 'prose',
    ]);

    $component->build('pageSection', [
        'content' => $content,
        'rowSpacing' => $rowSpacing,
        'className' => 'bg-[#e5ebf1] pt-4',
    ], true);
}

function background_wrapper($block, $content = '', $is_preview = false, $post_id = 0)
{
    $component = new Component();
    $rowSpacing = function_exists('get_field') ? get_field('spaceAfter') : '';
    $rowSpacing = $rowSpacing ? $rowSpacing : 'md';

    $verticalPadding = function_exists('get_field') ? get_field('verticalPadding') : '';
    $verticalPadding = $verticalPadding ? $verticalPadding : 'md';

    $backgroundColor = function_exists('get_field') ? get_field('backgroundColor') : '';
    $backgroundColor = $backgroundColor ? $backgroundColor : 'gray';

    $content = '<div class="background-wrapper-inner">' . innerBlocks([
        // 'allowed_blocks' => $allowed_blocks,
        'templateLock' => false,
        'template' => [
            [
                'core/paragraph', [],
            ],
        ],
    ]) . '</div>';

    $wrapper = $component->build('pageSection', [
        'wrapperClasses' => 'background-wrapper',
        'backgroundColor' => $backgroundColor,
        'rowSpacing' => $rowSpacing,
        'content' => $content,
        'verticalPadding' => $verticalPadding,
        'fullWidth' => true,
    ], true);

    return $wrapper;
}

function query_from_fields(array $user_fields = array())
{
    $default_args = [
        'post_type' => ['post'],
        'posts_per_page' => 10,
        'order' => 'DESC',
        'orderby' => 'date',
        'post_status' => ['publish'],
        'perm' => 'readable',
        'ignore_sticky_posts' => 1
    ];

    $new_args = [];
    $customizable_fields = ['post_type', 'posts_per_page', 'order', 'orderby', 'post_status', 'ignore_sticky_posts'];

    foreach ($customizable_fields as $field_name) {
        $field_value = get_key($user_fields, $field_name);
        if ($field_value !== null && $field_value !== '') {
            $new_args[$field_name] = $field_value;
        }
    }

    $post_format = get_key($user_fields, 'post_format');

    if ($post_format && $post_format !== 'all') {
        $post_format_query = [
            'taxonomy' => 'post_format',
            'field' => 'slug',
        ];

        if ($post_format === 'standard') {
            $post_format_query['terms'] = array(
                'post-format-aside',
                'post-format-audio',
                'post-format-chat',
                'post-format-gallery',
                'post-format-image',
                'post-format-link',
                'post-format-quote',
                'post-format-status',
                'post-format-video'
            );

            $post_format_query['operator'] = 'NOT IN';
        } else {
            $post_format_query['terms'] = [ "post-format-$post_format" ];
            $post_format_query['operator'] = 'IN';
        }
        $tax_query_master = [$post_format_query];
    } else {
        $post_format_query = false;
        $tax_query_master = null;
    }


    // Convert raw taxonomy terms into a valid `tax_query` value
    $categories = get_key($user_fields, 'categories');
    $categories = $categories ? $categories : [];
    $tags = get_key($user_fields, 'tags');
    $tags = $tags ? $tags : [];
    $taxonomy_terms = array_merge($categories, $tags);


    if (is_array($taxonomy_terms)) {
        $tax_query = [];
        $taxonomies = [];

        foreach ($taxonomy_terms as $term_object) {
            if (is_object($term_object)) {
                if (! array_key_exists($term_object->taxonomy, $taxonomies)) {
                    $taxonomies[$term_object->taxonomy] = [];
                }

                $taxonomies[$term_object->taxonomy][] = $term_object->term_id;
            }
        }

        foreach ($taxonomies as $taxonomy => $taxonomy_terms) {
            $tax_query[] = [
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => $taxonomy_terms,
            ];
        }

        $tax_query['relation'] = 'AND';

        if ($tax_query_master) {
            $tax_query_master['relation'] = 'AND';
            $tax_query_master[] = $tax_query;
        } else {
            $tax_query_master = $tax_query;
        }
    }

    $new_args['tax_query'] = $tax_query_master;

    $posts_in = get_key($user_fields, 'post__in');

    if ($posts_in && is_string($posts_in)) {
        $posts_in = explode(',', $posts_in);

        if (count($posts_in)) {
            $posts_in = array_map(function ($post_id) {
                return trim($post_id);
            }, $posts_in);

            $new_args['post__in'] = $posts_in;
            $new_args['ignore_sticky_posts'] = 1;
        }
    }

    return wp_parse_args($new_args, $default_args);
}

function table_wrapper($block, $content = '', $is_preview = false, $post_id = 0)
{
    $allowed_blocks = [
        'core/table',
    ];

    $template = [
        [
            'core/table', [],
        ],
    ];

    $rowSpacing = function_exists('get_field') ? get_field('spaceAfter') : '';
    $rowSpacing = $rowSpacing ? $rowSpacing : 'md';
    $rowSpacing = get_row_spacing($rowSpacing);

    echo '<div class="mx-auto nc-table-wrapper' . " $rowSpacing" . '">'
            . innerBlocks([
                'allowed_blocks' => $allowed_blocks,
                'template' => $template,
                'templateLock' => false,
                ])
                 . '</div>';
}

add_action('acf/init', function () {
    if (function_exists('acf_register_block')) {
        acf_register_block([
            'name' => 'nc-post-list-slider',
            'title' => __('Post List Slider', 'colby-news-theme'),
            'description' => __(
                'List of posts displayed as a horizontal slider.',
                'colby-news-theme'
            ),
            'category' => 'colby-news',
            'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M22.089 23.98c-.05 0-.09-.01-.13-.01H2.02c-.05 0-.09 0-.13 0 -.528 0-.973-.38-1.057-.9 -.05-.27.01-.54.16-.76L11.09 2.13c.29-.583.72-.645.89-.645 .21 0 .61.08.89.645L22.96 22.311c.31.47.19 1.12-.27 1.45 -.19.13-.4.2-.63.2ZM1.89 22.8c-.02.02-.03.04-.05.06 -.02.01-.02.03-.02.05 0 .03.03.05.06.05 .03-.01.06-.01.09-.01h20c.02 0 .05 0 .08 0 0 0 0 0 0 0 .02 0 .03-.01.04-.02 .03-.03.03-.07.01-.1 -.02-.02-.03-.05-.05-.07L11.94 2.54V2.54L1.83 22.75Z"/><path d="M11.996 17.479c-.28 0-.5-.23-.5-.5v-7c0-.28.22-.5.5-.5 .27 0 .5.22.5.5v7c0 .27-.23.5-.5.5Z"/><path d="M12.01 19.979c-.42-.01-.75-.32-.77-.73 -.01-.21.06-.4.2-.55 .13-.15.32-.23.52-.24 .42 0 .75.32.76.72 0 .2-.07.39-.21.54 -.14.14-.33.22-.53.23 -.01-.01-.01-.01-.01-.01s0 0 0 0Z"/></g></svg>',
            'render_callback' => function ($block, $content = '', $is_preview = false, $post_id = 0) {
                if (function_exists('get_fields')) {
                    $fields_from_block = get_fields();
                    $fields_from_block = is_array($fields_from_block) ? $fields_from_block : [];
                    $query_args = query_from_fields($fields_from_block);

                    $results = new \WP_Query($query_args);

                    $teasers = [];

                    if (count($results->posts) < 1) {
                        if ($is_preview) {
                            echo '<div class="p-6 border">No posts match the current query. Try adjusting the query settings.</div>';
                        } else {
                            return;
                        }
                    }

                    foreach ($results->posts as $result) {
                        $primary_category = get_primary_category($result->ID);
                        if ($primary_category && is_object($primary_category)) {
                            $primary_category = $primary_category->name;
                        } else {
                            $primary_category = '';
                        }

                        $post_formats = wp_get_post_terms($result->ID, 'post_format', ['fields' => 'names']);

                        $is_video = in_array('Video', $post_formats);

                        $teasers[] = [
                            'image' => nc_blocks_image(get_post_thumbnail_id($result->ID), 'teaser'),
                            'url' => get_permalink($result->ID),
                            'superhead' => $primary_category,
                            'title' => $result->post_title,
                            'withVideoLogo' => $is_video,
                        ];

                    }

                    $teasers = $teasers;

                    $teasers = array_map(function ($teaser_args) {
                        return Timber::compile(get_blocks_twig_directory('/teaser.twig'), $teaser_args);
                    }, $teasers);

                    Timber::render(get_blocks_twig_directory('/sliding-teasers.twig'), ['teasers' => $teasers]);
                }
            },
            'supports' => ['align' => false, 'multiple' => true, 'jsx' => true],
            'enqueue_assets' => function () {
                wp_enqueue_script(
                    'sliding-teasers',
                    get_template_directory_uri() . '/js/sliding-teasers.js',
                    [],
                    '',
                    true
                );
            },
        ]);
        acf_register_block([
            'name' => 'nc-info-getter',
            'title' => __('Info Getter', 'colby-news-theme'),
            'description' => __(
                'Blank block for debugging.',
                'colby-news-theme'
            ),
            'category' => 'colby-news',
            'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M22.089 23.98c-.05 0-.09-.01-.13-.01H2.02c-.05 0-.09 0-.13 0 -.528 0-.973-.38-1.057-.9 -.05-.27.01-.54.16-.76L11.09 2.13c.29-.583.72-.645.89-.645 .21 0 .61.08.89.645L22.96 22.311c.31.47.19 1.12-.27 1.45 -.19.13-.4.2-.63.2ZM1.89 22.8c-.02.02-.03.04-.05.06 -.02.01-.02.03-.02.05 0 .03.03.05.06.05 .03-.01.06-.01.09-.01h20c.02 0 .05 0 .08 0 0 0 0 0 0 0 .02 0 .03-.01.04-.02 .03-.03.03-.07.01-.1 -.02-.02-.03-.05-.05-.07L11.94 2.54V2.54L1.83 22.75Z"/><path d="M11.996 17.479c-.28 0-.5-.23-.5-.5v-7c0-.28.22-.5.5-.5 .27 0 .5.22.5.5v7c0 .27-.23.5-.5.5Z"/><path d="M12.01 19.979c-.42-.01-.75-.32-.77-.73 -.01-.21.06-.4.2-.55 .13-.15.32-.23.52-.24 .42 0 .75.32.76.72 0 .2-.07.39-.21.54 -.14.14-.33.22-.53.23 -.01-.01-.01-.01-.01-.01s0 0 0 0Z"/></g></svg>',
            'render_callback' => function ($block, $content = '', $is_preview = false, $post_id = 0) {
                echo '<pre>' . print_r($content, true) . '</pre>';
            },
            'supports' => ['align' => false, 'multiple' => true, 'jsx' => true],
        ]);
    }
});

add_action('admin_enqueue_scripts', 'NC_Blocks\nc_enqueue_admin_scripts');
function nc_enqueue_admin_scripts()
{
    if (file_exists(get_template_directory() . '/style-admin.css')) {
        wp_enqueue_style('nc-admin-styles', get_template_directory_uri() . '/style-admin.css');
    }
}


// add_action('acf/input/admin_enqueue_scripts', 'NC_Blocks\nc_enqueue_control_scripts');
// function nc_enqueue_control_scripts()
// {
//     if (file_exists(__DIR__ . '/js/acf-controls.js')) {
//         wp_enqueue_script('nc-acf-controls', get_stylesheet_directory_uri() . '/gutenberg-blocks/js/acf-controls.js');
//     }
// }
