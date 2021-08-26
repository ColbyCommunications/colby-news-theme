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

$post_list_args = [];

$post_type = get_post_type();

if ($post_type === 'external_post') {
    $current_page = get_query_var('paged');
    $current_page = $current_page ? $current_page : 1;

    $post_list_args['transformer_function'] = 'NC_Blocks\external_post_teaser_args';
    $post_list_args['transformer_args'] = ['show_description' => true];

    if ($current_page === 1) {
        $post_list_args['postListClasses'] = 'feature-archive';
    } else {
        $post_list_args['postListClasses'] = 'normal-archive';
    }
} else {
    // $post_list_args['postListClasses'] = 'max-w-[56.25rem]';
}

$context['postList'] = $timber_posts = $templateParts->build('paginatedPostList', $post_list_args);


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
    'templates/archive-' . get_post_type() . '.twig',
    'templates/archive.twig'
], $context);
