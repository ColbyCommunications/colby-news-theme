<?php

namespace NC_Blocks;

function is_link_valid(array $linkArgs) {
    $titleIsString = is_string(get_key($linkArgs, 'title', false));
    $urlIsString = is_string(get_key($linkArgs, 'url', false));
    return $titleIsString || $urlIsString;
}

function build_link(array $linkArgs)
{
    $title = get_key($linkArgs, 'title', '');
    $url = get_key($linkArgs, 'url');
    $class = get_key($linkArgs, 'class');
    $classAttr = $class ? "class='$class' " : '';
    return "<a href='$url' $classAttr>$title</a>";
}

function build_links_array(array $linkArrays)
{
    $linkArrays = array_map(function ($linkArray) {
        if (!get_key($linkArray, 'url') && get_key($linkArray, 'link')) {
            return $linkArray['link'];
        }
        return $linkArray;
    }, $linkArrays);
    $validLinks = array_filter($linkArrays, 'NC_Blocks\is_link_valid');
    return array_map('NC_Blocks\build_link', $validLinks);
}

function get_blocks_twig_directory($subpath = '')
{
    return get_template_directory() . '/gutenberg-blocks/blocks-twig' . $subpath;
}

function get_blocks_php_directory($subpath = '')
{
    return get_template_directory() . '/gutenberg-blocks/blocks' . $subpath;
}

function get_repeater_video($repeater_name, $repeater_row)
{
    if (function_exists('get_field')) {
        $items = get_field($repeater_name, false, false);

        foreach ($items[$repeater_row] as $field_name => $value) {
            $field_object = get_field_object($field_name);

            if ($field_object['type'] === 'oembed') {
                return $value;
            }
        }
    }
}

function get_key($array, $key, $default = null)
{
    if (is_array($array) && array_key_exists($key, $array)) {
        return $array[$key];
    }

    return $default;
}

function get_row_spacing($amountName, $dimension = 'mb', $screen = '')
{
    $spacing = [
        'default' => [
            'none' => '0',
            '0' => '0',
            'min' => '4',
            'sm' => '4',
            'md' => '8',
            'lg' => '8',
            'xl' => '8',
        ],
        'sm' => [
            'sm' => '8',
            'xl' => '14',
        ],
        'md' => [
            'md' => '8',
            'lg' => '14',
            'xl' => '24',
        ],
        'lg' => [
            // 'xl' => '20',
        ],
        'xl' => [
            // 'xl' => '40',
        ],
    ];

    // DO NOT DELETE THIS COMMENT BLOCK
    // The purpose of the text below is to safelist classes for Tailwind
    // m-0 m-4 m-8 m-14 m-24 m-30 m-40
    // mt-0 mt-4 mt-8 mt-14 mt-24 mt-30 mt-40
    // mb-0 mb-4 mb-8 mb-14 mb-24 mb-30 mb-40
    // mr-0 mr-4 m-r8 mr-14 m-r24 m-r30 mr-40
    // ml-0 ml-4 ml-8 ml-14 ml-24 ml-30 ml-40
    // pt-0 pt-4 pt-8 pt-14 pt-24 pt-30 pt-40
    // pb-0 pb-4 pb-8 pb-14 pb-24 pb-30 pb-40
    // pr-0 pr-4 p-r8 pr-14 p-r24 p-r30 pr-40
    // pl-0 pl-4 pl-8 pl-14 pl-24 pl-30 pl-40
    // sm:m-4 sm:mt-4 sm:mb-4 sm:ml-4 sm:mr-4 sm:p-4 :py-4 sm:pt-4 sm:pb-4 sm:pl-4 sm:pr-4
    // md:m-8 md:mt-8 md:mb-8 md:ml-8 md:mr-8 md:p-8 :py-8 md:pt-8 md:pb-8 md:pl-8 md:pr-8
    // lg:m-8 lg:mt-8 lg:mb-8 lg:ml-8 lg:mr-8 lg:p-8 :py-8 lg:pt-8 lg:pb-8 lg:pl-8 lg:pr-8
    // xl:m-8 xl:mt-8 xl:mb-8 xl:ml-8 xl:mr-8 xl:p-8 :py-8 xl:pt-8 xl:pb-8 xl:pl-8 xl:pr-8
    // sm:m-8 sm:mt-8 sm:mb-8 sm:ml-8 sm:mr-8 sm:p-8 :py-8 sm:pt-8 sm:pb-8 sm:pl-8 sm:pr-8
    // md:m-8 md:mt-8 md:mb-8 md:ml-8 md:mr-8 md:p-8 :py-8 md:pt-8 md:pb-8 md:pl-8 md:pr-8
    // lg:m-14 lg:mt-14 lg:mb-14 lg:ml-14 lg:mr-14 lg:p-14 lg:py-14 lg:pt-14 lg:pb-14 lg:pl-14 lg:pr-14
    // xl:m-24 xl:mt-24 xl:mb-24 xl:ml-24 xl:mr-24 xl:p-24 xl:py-24 xl:pt-24 xl:pb-24 xl:pl-24 xl:pr-24
    // md:m-14 md:mt-14 md:mb-14 md:ml-14 md:mr-14 md:p-14 md:py-14 md:pt-14 md:pb-14 md:pl-14 md:pr-14
    // md:m-24 md:mt-24 md:mb-24 md:ml-24 md:mr-24 md:p-24 md:py-24 md:pt-24 md:pb-24 md:pl-24 md:pr-24
    // xl:m-30 xl:mt-30 xl:mb-30 xl:ml-30 xl:mr-30 xl:p-30 xl:py-30 xl:pt-30 xl:pb-30 xl:pl-30 xl:pr-30
    // lg:m-30 lg:mt-30 lg:mb-30 lg:ml-30 lg:mr-30 lg:p-30 xl:py-30 lg:pt-30 lg:pb-30 lg:pl-30 lg:pr-30
    // xl:m-40 xl:mt-40 xl:mb-40 xl:ml-40 xl:mr-40 xl:p-40 xl:py-40 xl:pt-40 xl:pb-40 xl:pl-40 xl:pr-40

    if ($screen && isset($spacing[$amountName]) && isset($spacing[$amountName][$screen])) {
        return $dimension . '-' . $spacing[$amountName][$screen];
    }

    $classes = [];

    foreach ($spacing as $screenSize => $amounts) {
        if (isset($amounts[$amountName])) {
            $prefix = $screenSize === 'default' ? '' : $screenSize . ':';

            $classes[] = $prefix . $dimension . '-' . $amounts[$amountName];
        }
    }

    return implode_classes($classes);
}

function implode_classes(array $array)
{
    return implode(' ', $array);
}

function nc_menu_item_to_array($menuItem)
{
    $itemArray = [
        'title' => $menuItem->title,
        'url' => $menuItem->url,
    ];

    if (is_array($menuItem->children)) {
        $itemArray['children'] = $menuItem->children;
    }

    return $itemArray;
}

function nc_blocks_image_from_url($url = '', $attr = '')
{
    if (!wp_http_validate_url($url)) {
        return '';
    }

    $default_attr = [
        'src' => $url,
        'class' => '',
        'alt' => '',
    ];

    // Add `loading` attribute.
    if (wp_lazy_loading_enabled('img', 'wp_get_attachment_image')) {
        $default_attr['loading'] = 'lazy';
    }

    $attr = wp_parse_args($attr, $default_attr);

    // If the default value of `lazy` for the `loading` attribute is overridden
    // to omit the attribute for this image, ensure it is not included.
    if (array_key_exists('loading', $attr) && ! $attr['loading']) {
        unset($attr['loading']);
    }

    $attr = array_map('esc_attr', $attr);
    $html = rtrim("<img ");

    foreach ($attr as $name => $value) {
        $html .= " $name=" . '"' . $value . '"';
    }

    $html .= ' />';

    return $html;
}

function previewLinks($links, $args = [])
{
    $default_args = [
        'link_title' => 'Add some links',
        'link_url' => '#',
    ];

    $args = wp_parse_args($args, $default_args);

    if (empty($links)) {
        return [
            [
                'title' => $args['link_title'],
                'url' => $args['link_url']
            ],
        ];
    }
    return $links;
}

function previewLinkClasses($classes, $emptyLinks, $args = [])
{
    $string_classes = ! is_array($classes);
    $new_classes = $string_classes ? explode(' ', $classes) : $classes;

    $default_args = [
        'preview_classes' => ['pointer-events-none'],
        'empty_classes' => ['opacity-70'],
    ];

    $args = wp_parse_args($args, $default_args);

    $new_classes = array_merge($new_classes, $args['preview_classes']);

    if ($emptyLinks) {
        $new_classes = array_merge($new_classes, $args['empty_classes']);
    }

    if ($string_classes) {
        return implode(' ', $new_classes);
    }

    return $new_classes;
}

/**
 * Adds a fallback to the default `wp_get_attachment_image`
 *
 * Accepts all arguments from the original WP function.
 * If no image is returned, attempts to load the image defined in
 *    $attr['fallback'] instead.
 *
 * Fallback can be either an ID or a direct URL.
 * Value can be passed as a string or an array. If passed as an array,
 * the ID/URL should be assigned to $attr['fallback']['src'].
 *
 * Custom attributes for the fallback can be passed as
 * $attr['fallback']['attr'].
 *
 * If no fallback-specific attributes are passed, the original $attrs
 * will be passed instead.
 *
 * @param [type] $id
 * @param string $size
 * @param boolean $icon
 * @param string|array $attr
 *        New attribute: 'fallback' (string|int|array)
 *                       values (if array):
 *                       - 'src' (string) - ID or URL of fallback image
 *                       - 'attr' (array) - same options as original WP function
 *                       - recursively accepts any possible $attr values, including 'fallback'
 *
 * @return string
 */
function nc_blocks_image($id, $size = 'thumbnail', $icon = false, $attr = [])
{
    $fallback = is_array($attr) && isset($attr['fallback']) ? $attr['fallback'] : '';

    unset($attr['fallback']);
    $intended_image = wp_get_attachment_image($id, $size, $icon, $attr);
    if ($intended_image) {
        return $intended_image;
    }

    if (!$fallback) {
        return '';
    }

    if (!isset($fallback['attr']) || !is_array($fallback['attr'])) {
        $fallback_attr = $attr;
        unset($fallback_attr['fallback']);
    } else {
        $fallback_attr = $fallback['attr'];
    }

    $fallback_src = isset($fallback['src']) ? $fallback['src'] : $fallback;

    if (is_numeric($fallback_src)) {
        return nc_blocks_image($fallback_src, $size, $icon, $fallback_attr);
    }

    if (is_string($fallback_src)) {
        return nc_blocks_image_from_url($fallback_src, $fallback_attr);
    }
}
