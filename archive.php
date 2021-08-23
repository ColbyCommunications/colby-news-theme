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

$context = Timber::context();
$templateParts = new \NC_Blocks\TemplatePart($context);

$context['postList'] = $timber_posts = $templateParts->build('paginatedPostList');

if (is_home()) {
    $timber_post = new TimberPost();
    $title = $timber_post->title();
} else {
    $title = get_the_archive_title();
}

$context['archive'] = [
    'title' => $title,
    'description' => get_the_archive_description(),
];

Timber::render([
    'templates/home.twig',
    'templates/archive.twig'
], $context);
