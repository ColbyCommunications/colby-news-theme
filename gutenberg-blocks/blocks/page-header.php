<?php

/**
 * Header with Basic Text and Links
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

namespace NC_Blocks;

require_once(get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');
require_once(get_template_directory() . '/gutenberg-blocks/components/block-components.php');
require_once(__DIR__ . '/fancy-link-row.php');
require_once(__DIR__ . '/image-row.php');

$component = new Component();

$className = 'nc-page-header';

$wrapperClasses = [
    $className,
    'page-header'
];

$rowSpacing = get_field('spaceAfter');
$rowSpacing = $rowSpacing ? $rowSpacing : 'md';

$title = get_field('title') ? get_field('title') : get_the_title($post_id);
$image = get_field('image');
$body = get_field('body');
$button = get_field('button');
$links = get_field('links');

if ($is_preview && ! ($title || $body || $button)) {
    $title = 'Add some content to this block';
}

if (! is_array($links)) {
    $links = [];
}

$minimal = false;

if ($image) {
    $content = imageRow([
        'title' => $title,
        'body' => $body,
        'image' => $image,
        'links' => $links,
        'button' => $button,
        'inset' => true,
        'headingElement' => 'h1',
        'headingFontSize' => 'text-5xl',
        'textClasses' => 'pb-4',
    ]);
} else {
    $content = fancyLinkRow([
        'title' => $title,
        'body' => $body,
        'links' => $links,
        'button' => $button,
        'inset' => false,
        'dividers' => false,
        'headingElement' => 'h1',
        'headingColor' => 'text-primary',
        'headingFontSize' => 'text-5xl',
        'headingClasses' => 'lg:col-span-2',
        'gridClasses' => 'lg:grid-cols-fit-right',
        'textClasses' => 'pb-4 lg:contents',
        'contentClasses' => 'lg:contents',
    ]);

    $minimal = !$body && (! is_array($links) || count($links) < 1);
}

$verticalPadding = $minimal ? 'md' : 'lg';


$backgroundColor = get_field('backgroundColor');

if (!$backgroundColor) {
    $backgroundColor = $minimal || $image ? 'gray' : 'gold';
}

if ($content) {
    $component->build('pageSection', [
        'className' => implode_classes($wrapperClasses),
        'rowSpacing' => $rowSpacing,
        'verticalPadding' => $verticalPadding,
        'backgroundColor' => $backgroundColor,
        'fullWidth' => true,
        'content' => $content,
        'inset' => $image
    ], true);
}
