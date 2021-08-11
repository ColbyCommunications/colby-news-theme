<?php

/**
 * Teaser Text
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

$className = 'nc-teaser-text';

$headingSizes = [
    'h2' => [
        'superheader' => 'text-2xl',
        'header' => 'text-4xl'
    ],
    'h3' => [
        'superheader' => 'text-xl',
        'header' => 'text-3xl'
    ],
];

$args['superheader'] = get_field('superheader');
$args['title'] = get_field('title');
$args['body'] = get_field('body');
$args['element'] = get_field('element');

if ($args['element'] && isset($headingSizes[$args['element']])) {
    $args['headerSize'] = $headingSizes[$args['element']]['header'];
    $args['superheaderSize'] = $headingSizes[$args['element']]['superheader'];
}

$wrapperClasses = [
    $className,
    'container-narrow',
    'w-full',
    'mx-auto'
];

$spaceAfter = get_row_spacing(get_field('spaceAfter'), 'mb');

if ($spaceAfter) {
    $wrapperClasses[] = $spaceAfter;
}

if ($block['name'] === 'acf/nc-block-title') {
    $wrapperClasses[] = 'mb-6';
}

$args['wrapperClasses'] = $wrapperClasses;

$args['is_preview'] = $is_preview;

$component->build('teaserText', $args, true);
