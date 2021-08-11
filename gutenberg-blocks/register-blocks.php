<?php

/**
 * Register blocks and set a few block-related settings
 */

namespace NC_Blocks;

use Masterminds\HTML5;
use DOMXPath;

require_once(get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');
require_once(get_template_directory() . '/gutenberg-blocks/components/block-components.php');

add_action('wp_print_styles', function () {
    wp_dequeue_style('wp-block-library');
}, 100);

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
    }

    if (is_array($args['template'])) {
        $innerBlocksTag .= ' template="' . esc_attr(wp_json_encode($args['template'])) . '" ';
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
                'templateLock' => 'all'
                ])
                 . '</div>';
}

add_action('acf/init', function () {
    if (function_exists('acf_register_block')) {
        acf_register_block([
            'name' => 'nc-alert',
            'title' => __('Alert', 'colby-news-theme'),
            'description' => __(
                'Block with an alert displayed within page content.',
                'colby-news-theme'
            ),
            'category' => 'colby-news',
            'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M22.089 23.98c-.05 0-.09-.01-.13-.01H2.02c-.05 0-.09 0-.13 0 -.528 0-.973-.38-1.057-.9 -.05-.27.01-.54.16-.76L11.09 2.13c.29-.583.72-.645.89-.645 .21 0 .61.08.89.645L22.96 22.311c.31.47.19 1.12-.27 1.45 -.19.13-.4.2-.63.2ZM1.89 22.8c-.02.02-.03.04-.05.06 -.02.01-.02.03-.02.05 0 .03.03.05.06.05 .03-.01.06-.01.09-.01h20c.02 0 .05 0 .08 0 0 0 0 0 0 0 .02 0 .03-.01.04-.02 .03-.03.03-.07.01-.1 -.02-.02-.03-.05-.05-.07L11.94 2.54V2.54L1.83 22.75Z"/><path d="M11.996 17.479c-.28 0-.5-.23-.5-.5v-7c0-.28.22-.5.5-.5 .27 0 .5.22.5.5v7c0 .27-.23.5-.5.5Z"/><path d="M12.01 19.979c-.42-.01-.75-.32-.77-.73 -.01-.21.06-.4.2-.55 .13-.15.32-.23.52-.24 .42 0 .75.32.76.72 0 .2-.07.39-.21.54 -.14.14-.33.22-.53.23 -.01-.01-.01-.01-.01-.01s0 0 0 0Z"/></g></svg>',
            'render_callback' => 'NC_Blocks\alert_block',
            'supports' => ['align' => false, 'multiple' => true],
        ]);

        acf_register_block([
            'name' => 'nc-background-block',
            'title' => __('Background Color Section', 'colby-news-theme'),
            'description' => __(
                'Parent container that places a solid background color behind its child blocks.',
                'colby-news-theme'
            ),
            'category' => 'colby-news',
            'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M20 24H4c-2.2 0-4-1.8-4-4V4c0-2.2 1.8-4 4-4h16c2.2 0 4 1.8 4 4v16c0 2.2-1.8 4-4 4ZM4 2c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2H4Z"/><path d="M23 8H1c-.6 0-1-.4-1-1s.4-1 1-1h22c.6 0 1 .4 1 1s-.4 1-1 1Z"/><path d="M5.533 4.06l.5.5 -.93.92 -.51-.5 -.57.569 -.94-.94 .56-.57 -.5-.51 .923-.93 .5.5 .52-.53 .93.935 -.53.52Z"/></g></svg>',
            'render_callback' => 'NC_Blocks\background_wrapper',
            'supports' => ['align' => false, 'multiple' => true, 'jsx' => true],
        ]);

        acf_register_block([
            'name' => 'nc-heading-separator',
            'title' => __('Heading Separator', 'colby-admissions-theme'),
            'description' => __(
                'Place this horizontal line beneath Heading Level 2 (H2) elements to create a visual separation from the rest of the text content.',
                'colby-admissions-theme'
            ),
            'category' => 'colby',
            'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0Z"/><path d="M8 19h3v4h2v-4h3l-4-4 -4 4Zm8-14h-3V1h-2v4H8l4 4 4-4ZM4 11v2h16v-2H4Z"/></svg>',
            'render_template' => __DIR__ . '/blocks/hr.php',
            'supports' => ['align' => false, 'multiple' => true, 'jsx' => false],
        ]);

        // acf_register_block([
        //     'name' => 'nc-hr',
        //     'title' => __('Horizontal Rule / Separator', 'colby-admissions-theme'),
        //     'description' => __(
        //         'A wide line used to separate sections of content from one another.',
        //         'colby-admissions-theme'
        //     ),
        //     'category' => 'colby',
        //     'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0Z"/><path d="M8 19h3v4h2v-4h3l-4-4 -4 4Zm8-14h-3V1h-2v4H8l4 4 4-4ZM4 11v2h16v-2H4Z"/></svg>',
        //     'render_template' => __DIR__ . '/blocks/hr.php',
        //     'supports' => ['align' => false, 'multiple' => true, 'jsx' => false],
        // ]);

        acf_register_block([
            'name' => 'nc-inset-aside',
            'title' => __('Aside Block', 'colby-news-theme'),
            'description' => __('Block that can contain text, an image, and a link list. Meant to be inserted alongside text content.', 'colby-news-theme'),
            'category' => 'colby-news',
            'parent' => ['nc/rich-text'],
            'icon' => 'feedback',
            'render_template' => __DIR__ . '/blocks/inset-aside.php',
            'supports' => ['align' => true, 'multiple' => true, ],
        ]);

        acf_register_block([
            'name' => 'nc-link-list-horizontal',
            'title' => __('Horizontal Link List', 'colby-news-theme'),
            'description' => __('Short list of links arranged in a row', 'colby-news-theme'),
            'category' => 'colby-news',
            'icon' => "<svg height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><g><path d='M 2.5 10 C 2.775 10 3 9.775 3 9.5 C 3 9.225 2.775 9 2.5 9 C 2.225 9 2 9.225 2 9.5 C 2 9.775 2.225 10 2.5 10 Z M 2.5 12 C 2.775 12 3 11.775 3 11.5 C 3 11.225 2.775 11 2.5 11 C 2.225 11 2 11.225 2 11.5 C 2 11.775 2.225 12 2.5 12 Z M 2.5 8 C 2.775 8 3 7.775 3 7.5 C 3 7.225 2.775 7 2.5 7 C 2.225 7 2 7.225 2 7.5 C 2 7.775 2.225 8 2.5 8 Z M 4.5 10 L 10.5 10 C 10.775 10 11 9.775 11 9.5 C 11 9.225 10.775 9 10.5 9 L 4.5 9 C 4.225 9 4 9.225 4 9.5 C 4 9.775 4.225 10 4.5 10 Z M 4.5 12 L 10.5 12 C 10.775 12 11 11.775 11 11.5 C 11 11.225 10.775 11 10.5 11 L 4.5 11 C 4.225 11 4 11.225 4 11.5 C 4 11.775 4.225 12 4.5 12 Z M 4 7.5 C 4 7.775 4.225 8 4.5 8 L 10.5 8 C 10.775 8 11 7.775 11 7.5 C 11 7.225 10.775 7 10.5 7 L 4.5 7 C 4.225 7 4 7.225 4 7.5 Z M 2.5 10 C 2.775 10 3 9.775 3 9.5 C 3 9.225 2.775 9 2.5 9 C 2.225 9 2 9.225 2 9.5 C 2 9.775 2.225 10 2.5 10 Z M 2.5 12 C 2.775 12 3 11.775 3 11.5 C 3 11.225 2.775 11 2.5 11 C 2.225 11 2 11.225 2 11.5 C 2 11.775 2.225 12 2.5 12 Z M 2.5 8 C 2.775 8 3 7.775 3 7.5 C 3 7.225 2.775 7 2.5 7 C 2.225 7 2 7.225 2 7.5 C 2 7.775 2.225 8 2.5 8 Z M 4.5 10 L 10.5 10 C 10.775 10 11 9.775 11 9.5 C 11 9.225 10.775 9 10.5 9 L 4.5 9 C 4.225 9 4 9.225 4 9.5 C 4 9.775 4.225 10 4.5 10 Z M 4.5 12 L 10.5 12 C 10.775 12 11 11.775 11 11.5 C 11 11.225 10.775 11 10.5 11 L 4.5 11 C 4.225 11 4 11.225 4 11.5 C 4 11.775 4.225 12 4.5 12 Z M 4 7.5 C 4 7.775 4.225 8 4.5 8 L 10.5 8 C 10.775 8 11 7.775 11 7.5 C 11 7.225 10.775 7 10.5 7 L 4.5 7 C 4.225 7 4 7.225 4 7.5 Z'></path><path d='M 2.5 15.836 C 2.775 15.836 3 15.611 3 15.336 C 3 15.061 2.775 14.836 2.5 14.836 C 2.225 14.836 2 15.061 2 15.336 C 2 15.611 2.225 15.836 2.5 15.836 Z M 2.5 17.836 C 2.775 17.836 3 17.611 3 17.336 C 3 17.061 2.775 16.836 2.5 16.836 C 2.225 16.836 2 17.061 2 17.336 C 2 17.611 2.225 17.836 2.5 17.836 Z M 2.5 13.836 C 2.775 13.836 3 13.611 3 13.336 C 3 13.061 2.775 12.836 2.5 12.836 C 2.225 12.836 2 13.061 2 13.336 C 2 13.611 2.225 13.836 2.5 13.836 Z M 4.5 15.836 L 10.5 15.836 C 10.775 15.836 11 15.611 11 15.336 C 11 15.061 10.775 14.836 10.5 14.836 L 4.5 14.836 C 4.225 14.836 4 15.061 4 15.336 C 4 15.611 4.225 15.836 4.5 15.836 Z M 4.5 17.836 L 10.5 17.836 C 10.775 17.836 11 17.611 11 17.336 C 11 17.061 10.775 16.836 10.5 16.836 L 4.5 16.836 C 4.225 16.836 4 17.061 4 17.336 C 4 17.611 4.225 17.836 4.5 17.836 Z M 4 13.336 C 4 13.611 4.225 13.836 4.5 13.836 L 10.5 13.836 C 10.775 13.836 11 13.611 11 13.336 C 11 13.061 10.775 12.836 10.5 12.836 L 4.5 12.836 C 4.225 12.836 4 13.061 4 13.336 Z M 2.5 15.836 C 2.775 15.836 3 15.611 3 15.336 C 3 15.061 2.775 14.836 2.5 14.836 C 2.225 14.836 2 15.061 2 15.336 C 2 15.611 2.225 15.836 2.5 15.836 Z M 2.5 17.836 C 2.775 17.836 3 17.611 3 17.336 C 3 17.061 2.775 16.836 2.5 16.836 C 2.225 16.836 2 17.061 2 17.336 C 2 17.611 2.225 17.836 2.5 17.836 Z M 2.5 13.836 C 2.775 13.836 3 13.611 3 13.336 C 3 13.061 2.775 12.836 2.5 12.836 C 2.225 12.836 2 13.061 2 13.336 C 2 13.611 2.225 13.836 2.5 13.836 Z M 4.5 15.836 L 10.5 15.836 C 10.775 15.836 11 15.611 11 15.336 C 11 15.061 10.775 14.836 10.5 14.836 L 4.5 14.836 C 4.225 14.836 4 15.061 4 15.336 C 4 15.611 4.225 15.836 4.5 15.836 Z M 4.5 17.836 L 10.5 17.836 C 10.775 17.836 11 17.611 11 17.336 C 11 17.061 10.775 16.836 10.5 16.836 L 4.5 16.836 C 4.225 16.836 4 17.061 4 17.336 C 4 17.611 4.225 17.836 4.5 17.836 Z M 4 13.336 C 4 13.611 4.225 13.836 4.5 13.836 L 10.5 13.836 C 10.775 13.836 11 13.611 11 13.336 C 11 13.061 10.775 12.836 10.5 12.836 L 4.5 12.836 C 4.225 12.836 4 13.061 4 13.336 Z'></path><path d='M 12.721 10 C 12.996 10 13.221 9.775 13.221 9.5 C 13.221 9.225 12.996 9 12.721 9 C 12.446 9 12.221 9.225 12.221 9.5 C 12.221 9.775 12.446 10 12.721 10 Z M 12.721 12 C 12.996 12 13.221 11.775 13.221 11.5 C 13.221 11.225 12.996 11 12.721 11 C 12.446 11 12.221 11.225 12.221 11.5 C 12.221 11.775 12.446 12 12.721 12 Z M 12.721 8 C 12.996 8 13.221 7.775 13.221 7.5 C 13.221 7.225 12.996 7 12.721 7 C 12.446 7 12.221 7.225 12.221 7.5 C 12.221 7.775 12.446 8 12.721 8 Z M 14.721 10 L 20.721 10 C 20.996 10 21.221 9.775 21.221 9.5 C 21.221 9.225 20.996 9 20.721 9 L 14.721 9 C 14.446 9 14.221 9.225 14.221 9.5 C 14.221 9.775 14.446 10 14.721 10 Z M 14.721 12 L 20.721 12 C 20.996 12 21.221 11.775 21.221 11.5 C 21.221 11.225 20.996 11 20.721 11 L 14.721 11 C 14.446 11 14.221 11.225 14.221 11.5 C 14.221 11.775 14.446 12 14.721 12 Z M 14.221 7.5 C 14.221 7.775 14.446 8 14.721 8 L 20.721 8 C 20.996 8 21.221 7.775 21.221 7.5 C 21.221 7.225 20.996 7 20.721 7 L 14.721 7 C 14.446 7 14.221 7.225 14.221 7.5 Z M 12.721 10 C 12.996 10 13.221 9.775 13.221 9.5 C 13.221 9.225 12.996 9 12.721 9 C 12.446 9 12.221 9.225 12.221 9.5 C 12.221 9.775 12.446 10 12.721 10 Z M 12.721 12 C 12.996 12 13.221 11.775 13.221 11.5 C 13.221 11.225 12.996 11 12.721 11 C 12.446 11 12.221 11.225 12.221 11.5 C 12.221 11.775 12.446 12 12.721 12 Z M 12.721 8 C 12.996 8 13.221 7.775 13.221 7.5 C 13.221 7.225 12.996 7 12.721 7 C 12.446 7 12.221 7.225 12.221 7.5 C 12.221 7.775 12.446 8 12.721 8 Z M 14.721 10 L 20.721 10 C 20.996 10 21.221 9.775 21.221 9.5 C 21.221 9.225 20.996 9 20.721 9 L 14.721 9 C 14.446 9 14.221 9.225 14.221 9.5 C 14.221 9.775 14.446 10 14.721 10 Z M 14.721 12 L 20.721 12 C 20.996 12 21.221 11.775 21.221 11.5 C 21.221 11.225 20.996 11 20.721 11 L 14.721 11 C 14.446 11 14.221 11.225 14.221 11.5 C 14.221 11.775 14.446 12 14.721 12 Z M 14.221 7.5 C 14.221 7.775 14.446 8 14.721 8 L 20.721 8 C 20.996 8 21.221 7.775 21.221 7.5 C 21.221 7.225 20.996 7 20.721 7 L 14.721 7 C 14.446 7 14.221 7.225 14.221 7.5 Z'></path><path d='M 12.721 15.836 C 12.996 15.836 13.221 15.611 13.221 15.336 C 13.221 15.061 12.996 14.836 12.721 14.836 C 12.446 14.836 12.221 15.061 12.221 15.336 C 12.221 15.611 12.446 15.836 12.721 15.836 Z M 12.721 17.836 C 12.996 17.836 13.221 17.611 13.221 17.336 C 13.221 17.061 12.996 16.836 12.721 16.836 C 12.446 16.836 12.221 17.061 12.221 17.336 C 12.221 17.611 12.446 17.836 12.721 17.836 Z M 12.721 13.836 C 12.996 13.836 13.221 13.611 13.221 13.336 C 13.221 13.061 12.996 12.836 12.721 12.836 C 12.446 12.836 12.221 13.061 12.221 13.336 C 12.221 13.611 12.446 13.836 12.721 13.836 Z M 14.721 15.836 L 20.721 15.836 C 20.996 15.836 21.221 15.611 21.221 15.336 C 21.221 15.061 20.996 14.836 20.721 14.836 L 14.721 14.836 C 14.446 14.836 14.221 15.061 14.221 15.336 C 14.221 15.611 14.446 15.836 14.721 15.836 Z M 14.721 17.836 L 20.721 17.836 C 20.996 17.836 21.221 17.611 21.221 17.336 C 21.221 17.061 20.996 16.836 20.721 16.836 L 14.721 16.836 C 14.446 16.836 14.221 17.061 14.221 17.336 C 14.221 17.611 14.446 17.836 14.721 17.836 Z M 14.221 13.336 C 14.221 13.611 14.446 13.836 14.721 13.836 L 20.721 13.836 C 20.996 13.836 21.221 13.611 21.221 13.336 C 21.221 13.061 20.996 12.836 20.721 12.836 L 14.721 12.836 C 14.446 12.836 14.221 13.061 14.221 13.336 Z M 12.721 15.836 C 12.996 15.836 13.221 15.611 13.221 15.336 C 13.221 15.061 12.996 14.836 12.721 14.836 C 12.446 14.836 12.221 15.061 12.221 15.336 C 12.221 15.611 12.446 15.836 12.721 15.836 Z M 12.721 17.836 C 12.996 17.836 13.221 17.611 13.221 17.336 C 13.221 17.061 12.996 16.836 12.721 16.836 C 12.446 16.836 12.221 17.061 12.221 17.336 C 12.221 17.611 12.446 17.836 12.721 17.836 Z M 12.721 13.836 C 12.996 13.836 13.221 13.611 13.221 13.336 C 13.221 13.061 12.996 12.836 12.721 12.836 C 12.446 12.836 12.221 13.061 12.221 13.336 C 12.221 13.611 12.446 13.836 12.721 13.836 Z M 14.721 15.836 L 20.721 15.836 C 20.996 15.836 21.221 15.611 21.221 15.336 C 21.221 15.061 20.996 14.836 20.721 14.836 L 14.721 14.836 C 14.446 14.836 14.221 15.061 14.221 15.336 C 14.221 15.611 14.446 15.836 14.721 15.836 Z M 14.721 17.836 L 20.721 17.836 C 20.996 17.836 21.221 17.611 21.221 17.336 C 21.221 17.061 20.996 16.836 20.721 16.836 L 14.721 16.836 C 14.446 16.836 14.221 17.061 14.221 17.336 C 14.221 17.611 14.446 17.836 14.721 17.836 Z M 14.221 13.336 C 14.221 13.611 14.446 13.836 14.721 13.836 L 20.721 13.836 C 20.996 13.836 21.221 13.611 21.221 13.336 C 21.221 13.061 20.996 12.836 20.721 12.836 L 14.721 12.836 C 14.446 12.836 14.221 13.061 14.221 13.336 Z'></path></g></svg>",
            'render_template' => __DIR__ . '/blocks/link-list-horizontal-block.php',
            'supports' => ['align' => false, 'multiple' => true, ],
        ]);

        acf_register_block([
            'name' => 'nc-page-header',
            'title' => __('Page Header', 'colby-news-theme'),
            'description' => __('Page Header for Colby News pages', 'colby-news-theme'),
            'category' => 'colby-news',
            'icon' => 'cover-image',
            'render_template' => __DIR__ . '/blocks/page-header.php',
            'supports' => ['align' => false, 'multiple' => false, ],
        ]);

        acf_register_block([
            'name' => 'nc-rich-text',
            'title' => __('Rich Text Content', 'colby-news-theme'),
            'description' => __('Text formatted for optimal reading.', 'colby-news-theme'),
            'category' => 'colby-news',
            'icon' => 'text-page',
            'render_template' => __DIR__ . '/blocks/rich-text.php',
            'supports' => ['align' => false, 'multiple' => true, 'jsx' => true ],
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
