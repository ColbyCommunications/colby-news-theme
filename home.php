<?php

/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package colby-news-theme
 */

use Timber\Timber;
use Timber\Post as TimberPost;
use Timber\Image as TimberImage;
use Timber\ImageHelper as TimberImageHelper;
use Timber\PostQuery;

$context = Timber::context();
$context['posts'] = $timber_posts = new PostQuery();

$context['post'] = $timber_post = new TimberPost();
$context['archive'] = [
    'title' => $timber_post->title(),
    'description' => get_the_archive_description(),
];

$fallbackImageUrl = get_template_directory_uri() . '/assets/images/placeholder.png';
$fallbackImage = new TimberImage($fallbackImageUrl);
$context['fallback_image'] = $fallbackImage;

if (get_query_var('paged') === 0 || get_query_var('paged') === 1) {
    $context['first_page'] = true;
}

$breadcrumbs = nc_get_breadcrumbs($timber_post->ID);

if (is_array($breadcrumbs)) {
    $context['breadcrumbs'] = $breadcrumbs = Timber::compile(get_template_directory() . '/gutenberg-blocks/blocks-twig/breadcrumbs.twig', [
        'links' => $breadcrumbs
    ]);
}

if ($timber_posts->pagination()) {
    $context['pagination'] = Timber::compile(get_template_directory() . '/views/template-parts/pagination.twig', [
        'pagination' => $timber_posts->pagination()->get_pagination()
    ]);
}

if ($post && post_password_required($post->ID)) {
    Timber::render(
        'templates/password-required-' . $post->ID . '.twig',
        'templates/password-required-' . $post->type . '.twig',
        'templates/password-required-home.twig',
        'templates/password-required.twig',
        $context
    );
} else {
    Timber::render([
        'templates/home.twig',
        'templates/archive.twig'
    ], $context);
}
