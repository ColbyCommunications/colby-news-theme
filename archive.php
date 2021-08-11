<?php

/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package colby-news-theme
 */

use Timber\Timber;
use Timber\PostQuery;

$context = Timber::context();
$context['posts'] = $timber_posts = new PostQuery();

$context['archive'] = [
    'title' => get_the_archive_title(),
    'description' => get_the_archive_description(),
];


Timber::render([
    'templates/home.twig',
    'templates/archive.twig'
], $context);
