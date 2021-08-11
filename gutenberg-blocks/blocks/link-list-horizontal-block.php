<?php

/**
 * Horizontal Link List Columns
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

namespace NC_Blocks;

require_once(get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');
require_once(get_template_directory() . '/gutenberg-blocks/components/block-components.php');
require_once(__DIR__ . '/link-list-horizontal.php');

$component = new Component();

$className = 'nc-link-list-horizontal';

$wrapperClasses = [
    $className,
];

$sectionHeading = get_field('sectionHeading');
if (! is_array($sectionHeading)) {
    $sectionHeading = [];
}

$rowSpacing = get_field('spaceAfter');
$rowSpacing = $rowSpacing ? $rowSpacing : 'md';

$routingLinks = get_field('links');

if ($is_preview && ! is_array($routingLinks)) {
    $routingLinks = [
        [
            'title' => 'Add some links',
            'url' => '',
        ]
    ];
}

$iconKey = false;

foreach ($routingLinks as $teaser) {
    $linkUrl = get_key($teaser, 'link_external');
    if (is_array($linkUrl) && get_key($linkUrl, 'target')) {
        $iconKey = true;
        break;
    }
}

$linkListHorizontal = linkListHorizontal([
    'links' => $routingLinks,
    'containerClasses' => '',
]);

$headerLinks = is_array(get_key($sectionHeading, 'links')) ? $sectionHeading['links'] : [];

$headerLinks = array_map(function ($item) {
    if (get_key($item, 'link')) {
        return $item['link'];
    }
    return $item;
}, $headerLinks);

$component->build('pageSection', [
    'className' => $className,
    'title' => false,
    'headerBody' => false,
    'headingLevel' => get_key($sectionHeading, 'headingLevel', ''),
    'headerLinks' => $headerLinks,
    'rowSpacing' => $rowSpacing,
    'content' => $linkListHorizontal,
    'iconKey' => $iconKey,
    'fullWidth' => true
], true);
