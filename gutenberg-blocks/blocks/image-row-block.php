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
require_once(__DIR__ . '/image-row.php');

$component = new Component();

$className = 'nc-image-row';

$wrapperClasses = [
    $className,
];

$rowSpacing = get_field('spaceAfter');
$rowSpacing = $rowSpacing ? $rowSpacing : 'md';

$title = get_field('title');
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

$mediaSide = get_field('mediaSide');
$mediaSide = $mediaSide ? $mediaSide : 'right';

$minimal = false;

$content = imageRow([
    'title' => $title,
    'body' => $body,
    'image' => $image,
    'links' => $links,
    'button' => $button,
    'inset' => true,
    'headingElement' => 'h2',
    'headingFontSize' => 'text-5xl',
    'textClasses' => 'pb-4',
    'mediaSide' => $mediaSide,
]);

$verticalPadding = $minimal ? 'md' : 'lg';

$backgroundColor = get_field('backgroundColor');

$backgroundColor = $backgroundColor ? $backgroundColor : 'gray';

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
