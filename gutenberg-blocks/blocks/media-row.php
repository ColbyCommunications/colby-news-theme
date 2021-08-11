<?php

/** Functions required to build a media row.
 * This component does not have a standalone block.
 */

namespace NC_Blocks;

require_once(get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');
require_once(get_template_directory() . '/gutenberg-blocks/components/block-components.php');


use Timber\Timber;

function mediaRow(array $args = array())
{
    $component = new Component();
    $wrapperClasses = get_key($args, 'className', '');

    $textContentArgs = [
        'align' => "left",
        'wrapperClasses' => get_key($args, 'textClasses', ''),
        'textColorScheme' => get_key($args, 'textColorScheme', ''),
        'title' => get_key($args, 'title', ''),
        'HeadingElement' => get_key($args, 'headingElement', 'h2'),
        'headingColor' => get_key($args, 'headingColor', ''),
        'headingFont' => get_key($args, 'headingFont', ''),
        'fontSize' => get_key($args, 'headingFontSize', ''),
        'headingClasses' => get_key($args, 'headingClasses', ''),
        'gridClasses' => get_key($args, 'gridClasses', ''),
        'showHR' => get_key($args, 'showHR', false),
        'hrColor' => get_key($args, 'hrColor', ''),
        'button' => get_key($args, 'button', false),
        'links' => get_key($args, 'links', []),
        'body' => get_key($args, 'body', ''),
    ];

    $textContent = $component->build('billboard', $textContentArgs);

    $media = get_key($args, 'content', '');

    return Timber::compile(get_blocks_twig_directory('/media-row.twig'), [
        'textContent' => $textContent,
        'media' => $media,
        'mediaSide' => get_key($args, 'mediaSide', 'right'),
        'wrapperClasses' => $wrapperClasses,
        'containerClasses' => get_key($args, 'containerClasses', ''),
        'contentClasses' => get_key($args, 'contentClasses', ''),
        'inset' => get_key($args, 'inset', ''),
    ]);
}
