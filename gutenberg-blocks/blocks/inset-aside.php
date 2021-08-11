<?php

/**
 * Inset Aside
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

$className = 'nc-inset-aside';


$wrapperClasses = [
    $className,
];

$align = $block['align'];
if ($align) {
    $wrapperClasses[] = 'align' . $block['align'];
}

$title = get_field('title');
$body = get_field('body');

$image = get_field('image');

$image = nc_blocks_image($image, 'medium_uncropped');

$links = get_field('links');
$linkGroup = '';

if (is_array($links)) {
    $links = array_map(function ($linkItem) {
        return $linkItem['link'];
    }, $links);

    $linkGroup = $component->build('linkGroup', [
        'links' => $links
    ]);
}

Timber::render(get_blocks_twig_directory('/inset-aside.twig'), [
    'className' => implode(' ', $wrapperClasses),
    'title' => $title,
    'body' => $body,
    'image' => $image,
    'linkGroup' => $linkGroup,
]);
