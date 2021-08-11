<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package colby-news-theme
 */

use Timber\Timber;
use Timber\Post as TimberPost;

$context = Timber::context();
$context['posts'] = $timber_posts = Timber::get_posts();
$context['post'] = $timber_post = new TimberPost();
$context['archive'] = [
    'title' => $timber_post->title(),
    'description' => get_the_archive_description(),
];



if (post_password_required($post->ID)) {
    Timber::render(
        'templates/password-required-' . $post->ID . '.twig',
        'templates/password-required-' . $post->type . '.twig',
        'templates/password-required-home.twig',
        'templates/password-required.twig',
        $context
    );
} elseif (is_front_page()) {
    Timber::render([
        'templates/home.twig',
        'templates/archive.twig'
    ], $context);
} else {
    Timber::render([
        'templates/archive.twig'
    ], $context);
}
