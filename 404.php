<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package colby-admissions-theme
 */

use Timber\Timber;

$context = Timber::context();

require_once(get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');
require_once(get_template_directory() . '/gutenberg-blocks/components/block-components.php');

$component = new NC_Blocks\Component();

$context = Timber::context();

$className = 'nc-page-header';

$wrapperClasses = [
    $className,
];

$background_image = get_template_directory_uri() . '/assets/images/bkg_watercolor-progressive.jpg';

$top_decoration = Timber::compile(NC_Blocks\get_blocks_twig_directory() . '/painted-top.twig', $context);

$imageClasses = [
    'w-full',
    'max-w-none',
    'max-h-none',
    'object-cover',
    'object-center',
    'h-full',
    'absolute',
    ];

$imageWrapperClasses = ['background-image', 'z-0', 'w-full', 'inset-0', 'absolute'];

$background_image = NC_Blocks\nc_blocks_image(false, 'cover', '', [
    'alt' => '',
    'class' => implode(' ', $imageClasses),
    'fallback' => $background_image
]);

$background_image_container = '<div class="' . implode(' ', $imageWrapperClasses) . '">';
$background_image_container .= $background_image;
$background_image_container .= '</div>';

$classes = ['overflow-hidden', 'bg-blue-700'];

$content_classes = ['my-12', 'pt-20', 'container-narrow'];

$context['page_header'] = [
    'wrapperClasses' => NC_Blocks\implode_classes($wrapperClasses),
    'classes' => $classes,
    'contentClasses' => $content_classes,
    'backgroundImage' => $background_image_container,
    'topDecoration' => $top_decoration,
];

Timber::render(
    'templates/404.twig',
    $context
);
