<?php

/**
 * Rich Text Area
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

namespace NC_Blocks;

use Timber\Timber;

require_once(get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');

$wrapperClasses = [
];

$spaceAfter = get_row_spacing('sm', 'mb');

if ($spaceAfter) {
    $wrapperClasses[] = $spaceAfter;
}

$classes = '';

if (count($wrapperClasses)) {
    $classes = "class='" . implode_classes($wrapperClasses) . "'";
}

$hr = "<hr />";

$hr = "<div $classes>$hr</div>";

echo $hr;
