<?php

/**
 * Callback functions for custom blocks and additional
 * functions required for them to work.
 */

namespace NC_Blocks;

use Masterminds\HTML5;
use DOMXPath;
use Timber\Timber;
use WP_Query;

require_once(get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');
require_once(get_template_directory() . '/gutenberg-blocks/components/block-components.php');
require_once(\get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');

/**
 * Applies wrapper div around aligned blocks.
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
add_filter('mce_css', 'NC_Blocks\nc_mce_styles');

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
add_action('admin_notices', 'NC_Blocks\acfe_activation_notice');

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
add_filter('acfe/fields/advanced_link/sub_fields', 'NC_Blocks\nc_advanced_link_no_target', 10, 10);

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
add_filter('acfe/fields/advanced_link/sub_fields', 'NC_Blocks\nc_advanced_link_no_terms', 10, 3);

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
add_filter('acfe/fields/advanced_link/sub_fields', 'NC_Blocks\nc_advanced_link_posts_only', 10, 3);

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
add_filter('acfe/fields/advanced_link/sub_fields/name=link_with_description', 'NC_Blocks\nc_advanced_link_with_description', 10, 3);

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
add_filter('acfe/fields/advanced_link/sub_fields/name=link_url', 'NC_Blocks\nc_advanced_link_url_only', 10, 3);

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

function query_from_fields(array $user_fields = array(), $has_pagination = false, $post_id = null)
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
            if (is_int($term_object)) {
                $term_object = get_term($term_object);
            }

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
    $posts_not_in = get_key($user_fields, 'post__not_in');

    $include_current = get_key($user_fields, 'include_current');

    if (!$include_current && $post_id) {
        $posts_not_in = is_array($posts_not_in) ? array_merge($posts_not_in, [$post_id]) : [$post_id];
    }

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

    if ($posts_not_in && is_string($posts_not_in)) {
        $posts_not_in = explode(',', $posts_not_in);
        $posts_not_in = array_map(function ($post_id) {
            return trim($post_id);
        }, $posts_not_in);
    }

    if (is_array($posts_not_in) && count($posts_not_in)) {
        $new_args['post__not_in'] = $posts_not_in;
    }

    $new_args = wp_parse_args($new_args, $default_args);

    $offset = get_field('offset');

    if ($offset) {
        $new_args['raw_offset'] = $offset;
        if ($has_pagination) {
            $current_page = get_query_var('paged');
            $current_page = $current_page ? $current_page : 1;
            $ppp = $new_args['posts_per_page'];

            $offset = $offset + (($current_page - 1) * $ppp);
        }

        $new_args['offset'] = $offset;
    }

    return $new_args;
}

function nc_get_excerpt($post, $trim = false, array $custom_fields = [])
{
    $post = get_post($post);
    if (empty($post)) {
        return '';
    }

    if (post_password_required($post)) {
        return __('Password protected post.');
    }

    $excerpt = $post->post_excerpt;
    if (!$excerpt) {
        $excerpt = $post->post_content;

        if ($trim === true) {
            $trim = 20;
        }
    }

    if (! $excerpt) {
        return '';
    }

    // If the post is an `external_post`, never trim its content
    if ($trim && $post->post_type !== 'external_post') {
        if (is_int($trim)) {
            $trim = [
                'length' => $trim,
            ];
        }

        if (is_array($trim) && ! empty($trim['length'])) {
            if (empty($trim['more'])) {
                $trim['more'] = '[&hellip;]';
            }

            $excerpt_length = apply_filters('excerpt_length', $trim['length']);
            $excerpt_more = apply_filters('excerpt_more', ' ' . $trim['more']);
            $allowed_tags = wp_kses_allowed_html('data');
            unset($allowed_tags['a']);
            $excerpt = wp_kses($excerpt, $allowed_tags);
            $excerpt = preg_replace('/<!--(.|\s)*?-->/', '', $excerpt);
            $excerpt = wp_trim_words($excerpt, $excerpt_length, $excerpt_more);
        }
    }

    return apply_filters('get_the_excerpt', $excerpt, $post);
}

function related_posts($post_id, $item_count = 5, array $tags = [])
{
    $primary_category = get_primary_category($post_id);

    if (!$primary_category) {
        return false;
    }

    $primary_category_id = $primary_category->term_id;

    $cache_key = "posts_related_$post_id" . '_' . $primary_category_id;


    $query_args = [
        'post_type' => get_post_type($post_id),
        'posts_per_page' => $item_count > 10 ? $item_count : 10,
        'order' => 'DESC',
        'orderby' => 'date',
        'post_status' => ['publish'],
        'perm' => 'readable',
        'ignore_sticky_posts' => 1,
        'post__not_in' => [$post_id],
        'tax_query' => [
            'relation' => 'AND',
            [
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => [$primary_category->slug],
            ]
        ],
    ];

    if (count($tags)) {
        $query_args['tax_query'][] = [
            'taxonomy' => 'post_tag',
            'field' => 'term_id',
            'terms' => $tags,
        ];
    }

    $results = new WP_Query($query_args);

    if (!is_object($results) || !is_array($results->posts)) {
        wp_cache_set($cache_key, false, 120);
        return false;
    }

    $posts = $results->posts;

    if (count($posts) > $item_count) {
        $posts = array_slice($posts, 0, $item_count);
    }

    return $posts;
}

function get_post_type_from_editor()
{
    if (is_admin()) {
        global $pagenow;
        $typenow = '';

        if ('admin-ajax.php' === $pagenow || !$pagenow) {
            return false;
        }

        if ('post-new.php' === $pagenow) {
            if (isset($_REQUEST['post_type']) && post_type_exists($_REQUEST['post_type'])) {
                $typenow = $_REQUEST['post_type'];
            };
        } elseif ('post.php' === $pagenow) {
            if (isset($_GET['post']) && isset($_POST['post_ID']) && (int) $_GET['post'] !== (int) $_POST['post_ID']) {
            // Do nothing
            } elseif (isset($_GET['post'])) {
                $post_id = (int) $_GET['post'];
            } elseif (isset($_POST['post_ID'])) {
                $post_id = (int) $_POST['post_ID'];
            }
            if ($post_id) {
                $post = get_post($post_id);
                if ($post) {
                    $typenow = $post->post_type;
                }
            }
        }

        return $typenow;
    }

    return false;
}

function get_youtube_rss_items($playlistID = null, $item_count = 10)
{
    if ($playlistID) {
        $url = "https://www.youtube.com/feeds/videos.xml?playlist_id=$playlistID";
    } else {
        $url = "https://www.youtube.com/feeds/videos.xml?user=colbycollege";
    }
    $remote_response = wp_remote_get($url);

    if (is_wp_error($remote_response) || $remote_response['response']['code'] !== 200) {
        return false;
    }

    $feed_content = $remote_response['body'];

    $parser = new \Gbuckingham89\YouTubeRSSParser\Parser();
    $parser->loadString($feed_content);
    $entries = $parser->channel->videos;

    $items = [];
    foreach ($entries as $item) {
        $item_id = $item->id;
        $image_url = "https://i.ytimg.com/vi/$item_id/maxresdefault.jpg";
        $image = "<img src='$image_url' width='1280' height='720' alt='' />";
        $items[] = [
            'title' => $item->title,
            'image' => $image,
            'url' => $item->url,
        ];
    }

    return $items;
}

function teaser_list(array $posts, bool $is_preview = false, array $show_fields = array(
    'image',
    'category',
    'video'
))
{
    if (!count($posts)) {
        return;
    }

    $show_fields[] = 'title';
    $show_fields[] = 'url';

    $show_fields_arrays = [];

    foreach ($show_fields as $field_def) {
        if (is_string($field_def)) {
            $show_fields_arrays[$field_def] = [
                'display' => true
            ];
        }

        if (is_array($field_def)) {
            $show_fields[$field_def][0] = $field_def;
        }
    }


    foreach ($posts as $post) {
        if (!is_array($post)) {
            $primary_category = get_primary_category($post->ID);
            if ($primary_category && is_object($primary_category)) {
                $primary_category_url = get_term_link($primary_category);
                $primary_category_name = $primary_category->name;
            } else {
                $primary_category_name = '';
            }

            $post_formats = wp_get_post_terms($post->ID, 'post_format', ['fields' => 'names']);

            $is_video = in_array('Video', $post_formats);

            $teaser = [
                'url' => get_permalink($post->ID),
                'superhead' => $primary_category_name,
                'title' => $post->post_title,
                'withVideoLogo' => $is_video,
            ];

            if (in_array('image', $show_fields)) {
                $teaser['image'] = nc_blocks_image(get_post_thumbnail_id($post->ID), 'teaser');
            }

            if (in_array('category', $show_fields)) {
                $teaser['superhead'] = [ 'title' => $primary_category_name, 'url' => $primary_category_url];
            }

            if (in_array('video', $show_fields)) {
                $teaser['withVideoLogo'] = $is_video;
            }

            if (! empty($show_fields_arrays['description'])) {
                if (empty($show_fields_arrays['description']['trim'])) {
                    $trim = false;
                } else {
                    $trim = $show_fields_arrays['description']['trim'];
                }

                $summary = get_field('summary', $post->ID);
                $teaser['description'] = $summary ? $summary : nc_get_excerpt($post->ID, $trim);
            }
        } else {
            $teaser = $post;
        }

        $teasers[] = $teaser;
    }

    $teasers = array_map(function ($teaser_args) {
        return Timber::compile(get_blocks_twig_directory('/teaser.twig'), $teaser_args);
    }, $teasers);

    return $teasers;
}

function post_list_slider($posts, $is_preview = false)
{
    if (count($posts) < 1) {
        if ($is_preview) {
            return '<div class="p-6 border">No posts match the current query. Try adjusting the query settings.</div>';
        } else {
            return;
        }
    }

    $teasers = teaser_list($posts, $is_preview);

    return Timber::compile(get_blocks_twig_directory('/sliding-teasers.twig'), ['teasers' => $teasers, 'is_preview' => $is_preview]);
}

function teaser_pair($posts, $is_preview = false, $show_fields = array(
    'image',
    'category',
    'video'
))
{
    if (count($posts) < 1) {
        if ($is_preview) {
            return '<div class="p-6 border">No posts match the current query. Try adjusting the query settings.</div>';
        } else {
            return;
        }
    } elseif (count($posts) > 2) {
        $posts = array_slice($posts, 0, 2);
    }


    $teasers = teaser_list($posts, $is_preview, $show_fields);

    return Timber::compile(get_blocks_twig_directory('/teaser-pair.twig'), ['teasers' => $teasers, 'is_preview' => $is_preview]);
}

function slider_with_teaser_pair(array $posts, $is_preview = false)
{
    if (count($posts) > 2) {
        $teaser_pair_posts = array_slice($posts, 0, 2);
        $slider_posts = array_slice($posts, 2);
    } else {
        $teaser_pair_posts = $posts;
        $slider_posts = false;
    }

    $teaser_pair = '';
    $slider = '';

    if (count($teaser_pair_posts)) {
        $teaser_pair = teaser_pair($teaser_pair_posts, $is_preview);
    }

    if ($slider_posts) {
        $slider = post_list_slider($slider_posts, $is_preview);
    }

    return "<div class='wp-block nc-slider-with-teaser-pair'>
        <div class='mb-10'>$teaser_pair</div>
        <div>$slider</div>
    </div>";
}

// Begin render callback functions
function post_list_slider_block($block, $content = '', $is_preview = false, $post_id = 0)
{
    if (function_exists('get_fields')) {
        $fields_from_block = get_fields();
        if (!$fields_from_block) {
            $fields_from_block = $block['data'];
        }
        $fields_from_block = is_array($fields_from_block) ? $fields_from_block : [];
        $query_args = query_from_fields($fields_from_block, false, $post_id);

        $results = new WP_Query($query_args);

        echo '<div class="wp-block">' . post_list_slider($results->posts) . '</div>';
    }
}

function teaser_pair_block($block, $content = '', $is_preview = false, $post_id = 0)
{
    if (function_exists('get_fields')) {
        $fields_from_block = get_fields();
        if (!$fields_from_block) {
            $fields_from_block = $block['data'];
        }
        $fields_from_block = is_array($fields_from_block) ? $fields_from_block : [];
        $query_args = query_from_fields($fields_from_block, false, $post_id);

        $show_fields = get_field('show_fields');

        if (!$show_fields) {
            if (!empty($block['data']['show_fields'])) {
                $show_fields = $block['data']['show_fields'];
            }
        }

        $show_fields = is_array($show_fields) ? $show_fields : array();

        $results = new WP_Query($query_args);

        if (is_array($show_fields)) {
            $show_fields[] = 'image';
            $teaser_pair = teaser_pair($results->posts, $is_preview, $show_fields);
        } else {
            $teaser_pair = teaser_pair($results->posts, $is_preview);
        }


        echo '<div class="wp-block">' . $teaser_pair . '</div>';
    }
}

function slider_with_teaser_pair_block($block, $content = '', $is_preview = false, $post_id = 0)
{
    if (function_exists('get_fields')) {
        $fields_from_block = get_fields();
        if (!$fields_from_block) {
            $fields_from_block = $block['data'];
        }
        $fields_from_block = is_array($fields_from_block) ? $fields_from_block : [];
        $query_args = query_from_fields($fields_from_block, false, $post_id);

        $results = new WP_Query($query_args);

        echo '<div class="wp-block">' . slider_with_teaser_pair($results->posts, $is_preview) . '</div>';
    }
}

function video_slider_block($block, $content = '', $is_preview = false, $post_id = 0)
{
    $display_teaser_pair = false;
    $video_count = false;
    $youtube_id = 'UChGBTvH9tUJbjxiaAAHGPqg';

    if (function_exists('get_field')) {
        $display_teaser_pair = get_field('display_teaser_pair');
        $youtube_id = get_field('youtube_id');
        $video_count = get_field('video_count');
    }

    $video_count = $video_count ? $video_count : null;

    // Get videos from YouTube
    $videos = get_youtube_rss_items($youtube_id, $video_count);

    if ($videos) {
        if ($display_teaser_pair) {
            $content = slider_with_teaser_pair($videos, $is_preview);
        } else {
            $content = post_list_slider($videos, $is_preview);
        }

        echo '<div class="wp-block">' . $content . '</div>';
    } else {
        echo '<h2>No videos found</h2>';
    }
}

function external_post_teaser_args($post, $args = [])
{
    $featured_image = get_post_thumbnail_id($post);
    $source_logo = null;
    if ($featured_image) {
        $source_logo = nc_blocks_image($featured_image, 'logo');
    }

    $sources = wp_get_post_terms($post->ID, 'media_source');

    if (!is_wp_error($sources) && is_array($sources) && count($sources)) {
        $source = $sources[0];
        $source_name = $source->name;

        if (!$source_logo) {
            $source_logo_id = get_field('logo', $source);
            $source_logo = nc_blocks_image($source_logo_id, 'logo');
        }
    } else {
        $source_name = null;
    }

    if (!empty($args['show_description'])) {
        $blurb = nc_get_excerpt($post);
    } else {
        $blurb = null;
    }

    $item_args = [
        'image' =>  $source_logo,
        'source' =>  $source_name,
        'link' =>  [
            'url' => get_field('external_url', $post->ID),
            'title' => get_the_title($post),
        ],
        'blurb' => $blurb,
        'post_type' => $post->post_type,
    ];

    return $item_args;
}

function basic_post_teaser_args($post, $args = [])
{
    if (!empty($args['show_description'])) {
        $blurb = nc_get_excerpt($post);
    } else {
        $blurb = null;
    }

    $item_args = [
        'link' =>  [
            'url' => get_field('external_url', $post->ID),
            'title' => get_the_title($post),
        ],
        'blurb' => $blurb,
        'post_type' => $post->post_type,
        'variant' => 'basic'
    ];

    return $item_args;
}

function external_post_list($block, $content = '', $is_preview = false, $post_id = 0)
{

    $title = 'Media Coverage';
    $post_count = 4;

    if (function_exists('get_field')) {
        // If true, use the latest story with the "Editor's Pick" tag
        $custom_title = get_field('title');
        $custom_post_count = get_field('post_count');

        $title = $custom_title ? $custom_title : $title;
        $post_count = $custom_post_count ? $custom_post_count : $post_count;
    }

    $query_args = [
        'post_type' => ['external_post'],
        'posts_per_page' => $post_count,
        'order' => 'DESC',
        'orderby' => 'date',
        'post_status' => ['publish'],
        'perm' => 'readable',
        'ignore_sticky_posts' => 1,
    ];

    $story_types = get_field('story_type');
    $terms = get_field('terms');

    if (is_array($story_types) || is_array($terms)) {
        $tax_query = [];
        if (is_array($story_types) && is_array($terms)) {
            $tax_query['relation'] = 'AND';
        }

        if (is_array($story_types)) {
            $tax_query[] = [
                [
                    'taxonomy' => 'story_type',
                    'field' => 'term_id',
                    'terms' => $story_types,
                ],
            ];
        }

        if (is_array($terms)) {
            $tax_query[] = [
                [
                    'taxonomy' => 'post_tag',
                    'field' => 'term_id',
                    'terms' => $terms,
                ],
            ];
        }

        $query_args['tax_query'] = $tax_query;
    }


    $query_results = new WP_Query($query_args);
    $post_results = $query_results->posts;

    $post_items = [];

    if (is_array($post_results) && count($post_results) > 0) {
        foreach ($post_results as $index => $post) {
            $show_description = false;

            if ($index === 0) {
                $show_description = true;
            }

            $item_args = external_post_teaser_args($post, ['show_description' => $show_description]);

            $post_items[] = Timber::compile(get_blocks_twig_directory('/media-coverage-item.twig'), $item_args);
        }

        $external_post_list = '<div class="space-y-6 sm:space-y-8">';
        $external_post_list .= "<h2>$title</h2>";
        $external_post_list .= '<ul class="space-y-6">';

        foreach ($post_items as $post_item) {
            $external_post_list .= "<li class='block descendant-a:text-base sm:descendant-a:text-lg'>
                                        $post_item
                                    </li>";
        }

        $external_post_list .= '</ul></div>';
    } else {
        if ($is_preview) {
            $external_post_list = '<div class="text-2xl font-bold">No posts match your selection.</div>';
        } else {
            $external_post_list = '';
        }
    }

    echo '<div class="wp-block">' . $external_post_list . '</div>';
}

function related_posts_block($block, $content = '', $is_preview = false, $post_id = 0)
{
    $post_source = get_field('post_source');

    $related_posts = false;

    if (!$post_source || $post_source === 'auto') {
        $tags = get_field('tags');
        if (!is_array($tags)) {
            $tags = [];
        }
        $post_count = get_field('post_count');
        if (!$post_count) {
            $post_count = 5;
        }
        $related_posts = related_posts($post_id, $post_count, $tags);
    } else {
        $related_posts = get_field('select_posts');
    }


    if ($related_posts) {
        $align = '';
        $align_class = '';
        $block_class = 'wp-block';

        if (function_exists('get_field')) {
            $align_setting = get_field('layout');
            if ($align_setting === 'left') {
                $align = 'data-align="' . $align_setting . '"';
                $align_class = 'align' . $align_setting;

                $block_class = '';
            }
        }

        $image_size = $align ? 'logo' : 'teaser_small';

        $teasers = array_map(function ($post_item) use ($image_size) {
            $image = nc_blocks_image(get_post_thumbnail_id($post_item->ID), $image_size);
            $summary = get_field('summary', $post_item->ID);
            $summary = $summary ? $summary : nc_get_excerpt($post_item->ID, true);
            return [
                'title' => get_the_title($post_item->ID),
                'image' => $image,
                'description' => $summary,
                'url' => get_permalink($post_item)
            ];
        }, $related_posts);


        echo "<div class='$block_class $align_class' $align>";
        Timber::render(get_blocks_twig_directory('/related-stories.twig'), ['items' => $teasers, 'float' => $align]);
        echo '</div>';
    } elseif ($is_preview) {
        echo 'No posts found. You may not have added a category to this post yet, or your filter settings may be too restrictive.';
    }
}

function featured_story_large($block, $content = '', $is_preview = false, $post_id = 0)
{
    $featured_post_id = false;
    $featured_post = false;

    if (function_exists('get_field')) {
        // If true, use the latest story with the "Editor's Pick" tag

        $use_latest = get_field('use_latest');

        if ($use_latest) {
            $query_args = [
                'post_type' => ['post'],
                'posts_per_page' => 1,
                'order' => 'DESC',
                'orderby' => 'date',
                'post_status' => ['publish'],
                'perm' => 'readable',
                'ignore_sticky_posts' => 1,
                'tax_query' => [
                    [
                        'taxonomy' => 'post_tag',
                        'field' => 'slug',
                        'terms' => ['editors-pick'],
                    ]
                ],
            ];

            $query_results = new WP_Query($query_args);
            $post_results = $query_results->posts;
            if (is_array($post_results) && count($post_results) > 0) {
                $featured_post_id = $post_results[0]->ID;
            }
        } else {
            $featured_post_id = get_field('post_id');
        }
    }

    if ($featured_post_id) {
        $featured_post = get_post($featured_post_id);
        if ($featured_post) {
            $template_part = new TemplatePart();
            $link_text = 'Read More';
            if (get_post_format($featured_post_id) === 'video') {
                $link_text = 'Watch';
            }
            $featured_story_block = $template_part->build(
                'storyHeader',
                [
                    'post' => $featured_post,
                    'postedDate' => false,
                    'author' => false,
                    'lengthOfRead' => false,
                    'photoCredit' => false,
                    'contact' => false,
                    'element' => 'div',
                    'link' => [
                        'title' => $link_text,
                        'url' => get_the_permalink($featured_post_id),
                    ],
                    'is_preview' => $is_preview,
                ],
            );
        }
    } else {
        if ($is_preview) {
            $featured_story_block = '<div class="text-xl font-bold">No posts match your selection.</div>';
        } else {
            $featured_story_block = '';
        }
    }
    echo '<div class="wp-block">' . $featured_story_block . '</div>';
}

function breaker_feature($block, $content = '', $is_preview = false, $post_id = 0)
{
    if (function_exists('get_field')) {
        $image = get_field('image');
        if ($image) {
            $image = nc_blocks_image($image, 'landscape_full_xl');
        }

        $args = [
            'image' => $image,
            'superhead' => [
                'title' => get_field('superhead'),
                'url' => get_field('superhead_url')
            ],
            'headline' => get_field('title'),
            'description' => get_field('body'),
            'link' => get_field('link'),
        ];

        echo "<div class='wp-block'><div class='relative full-width'>"
            . Timber::compile(get_blocks_twig_directory('/breaker-feature.twig'), $args)
            . "</div></div>";
    }
}