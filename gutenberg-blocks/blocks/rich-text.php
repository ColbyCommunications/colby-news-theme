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

require_once(get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');
require_once(get_template_directory() . '/gutenberg-blocks/components/block-components.php');

$allowedBlocks = array(
    'acf/nc-inset-aside',
    'core/image',
    'core/heading',
    'core/paragraph',
    'core/list',
    'core/html',
    'core/subhead',
    'core/text-columns',
    'core/preformatted',
    'code/shortcodes',
    'core/image-gallery',
    'core/audio',
    'core/video',
    'core/shortcode',
    'core/quote',
    'core/code',
    'core/embed',
);

$component = new Component();

$wrapperClasses = [
    'nc-rich-text',
];



$rowSpacing = get_field('spaceAfter');
$rowSpacing = $rowSpacing ? $rowSpacing : 'md';

$verticalPadding = get_field('verticalPadding');
$verticalPadding = $verticalPadding ? $verticalPadding : 'none';

$backgroundColor = get_field('backgroundColor');
$backgroundColor = $backgroundColor ? $backgroundColor : 'gray';

$content = '<div class="rich-text-inner">' . innerBlocks([
    'allowed_blocks' => $allowedBlocks,
    'templateLock' => false,
    'template' => [
        [
            'core/paragraph', [],
        ],
    ],
]) . '</div>';

if ($is_preview) {
    $content = "
        <style>
            .rich-text-preview::before {
                content: 'This text is enclosed in a Formatted Text block. This preview text and border will not be seen on the actual page.';
                font-size: 12px;
                color: #777;
                display: block;
                position: absolute;
                padding: 0 0.5rem;
                background: #FFF;
                top: -0.5rem;
                left: 2rem;
            }
        </style>
        <div class='relative py-6 border rich-text-preview border-gray-light'>
            $content
        </div>
    ";
}

$wrapperClasses = implode_classes($wrapperClasses);

$component->build('pageSection', [
    'className' => $wrapperClasses,
    'rowSpacing' => $rowSpacing,
    'content' => $content,
    'verticalPadding' => $verticalPadding,
    'fullWidth' => true,
], true);
