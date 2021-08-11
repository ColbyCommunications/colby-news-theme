<?php

/** Functions required to build an Image/Text row.
 * Separate from the `image-row-block.php` file so it can be used
 * by other blocks as well.
 */

namespace NC_Blocks;

require_once(get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');
require_once(get_template_directory() . '/gutenberg-blocks/components/block-components.php');
require_once(__DIR__ . '/media-row.php');


function imageRow(array $args = array())
{
    $component = new Component();

    $mediaArgs = get_key($args, 'media', []);

    $mediaArgs['fit'] = get_key($mediaArgs, 'fit', 'object-cover');
    $mediaArgs['src'] = get_key($args, 'image', '');

    $figureArgs = [
        'mediaType' => 'image',
        'media' => $mediaArgs,
        'imageSize' => 'teaser_large',
        'videoLink' => get_key($args, 'vide0', false),
        'caption' => get_key($args, 'caption', ''),
        'classes' => ['h-full', 'object-cover'],
        'stretch' => true,
    ];

    $media = $component->build('figure', $figureArgs);

    $mediaRowArgs = wp_parse_args([
        'contentAlignVertical' => 'justify-start',
        'headingColor' => get_key($args, 'headingColor', 'text-black'),
        'headingFontSize' => get_key($args, 'headingFontSize', 'text-4xl'),
        'containerClasses' => get_key($args, 'containerClasses', ''),
        'contentClasses' => get_key($args, 'textClasses', ''),
        'showHR' => false,
        'content' => $media,
        'inset' => get_key($args, 'inset'),
        'mediaSide' => get_key($args, 'mediaSide'),
    ], $args);

    return mediaRow($mediaRowArgs);
}
