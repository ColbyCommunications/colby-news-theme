<?php

/**
 * Quotation
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

namespace NC_Blocks;

require_once(get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');
require_once(get_template_directory() . '/gutenberg-blocks/components/block-components.php');

$component = new Component();

use Timber\Timber;

$context = Timber::context();

$className = 'nc-quotation';

$wrapperClasses = [
    $className,
    'container-narrow',
    'px-container',
    'mx-auto'
];

$spaceAfter = get_row_spacing(get_field('spaceAfter'), 'mb');

if ($spaceAfter) {
    $wrapperClasses[] = $spaceAfter;
}

$contentPlacement = get_field('contentPlacement');

$component->build('quotation', [
    'wrapperClasses' => $wrapperClasses,
    'quotation' => get_field('quotation'),
    'attribution' => get_field('attribution'),
    'image' => get_field('image'),
    'withQuotes' => get_field('withQuotes'),
    'pinImage' => get_field('pinImage'),
    'contentPlacement' => $contentPlacement ? $contentPlacement : 'left',
], true);
