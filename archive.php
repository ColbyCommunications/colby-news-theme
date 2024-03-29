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
use Timber\PostQuery as TimberPostQuery;

$context = Timber::context();
$templateParts = new \NC_Blocks\TemplatePart($context);

$post_list_args = [];

$post_type = get_post_type();

$frontLoadPicks = false;

if (is_post_type_archive('external_post')) {
    $current_page = get_query_var('paged');
    $current_page = $current_page ? $current_page : 1;

    $story_type = get_query_var('story_type');

    if ($story_type === 'media-coverage') {
        $post_list_args['transformer_function'] = 'NC_Blocks\external_post_teaser_args';
    } else {
        $post_list_args['transformer_function'] = 'NC_Blocks\basic_post_teaser_args';
    }
    $post_list_args['transformer_args'] = ['show_description' => true];

    if ($current_page === 1 && $story_type === 'media-coverage') {
        $post_list_args['postListClasses'] = 'feature-archive';
        $frontLoadPicks = true;
    } else {
        $post_list_args['postListClasses'] = 'normal-archive';
    }
} else {
    $story_type = '';
}

$post_list_args['render'] = false;

$postListRenderArgs = $timber_posts = $templateParts->build('paginatedPostList', $post_list_args);

if ($frontLoadPicks) {
    $picksQuery = [
        'post_type' => $post_type,
        'posts_per_page' => 3,
        'order' => 'DESC',
        'orderby' => 'date',
        'post_status' => ['publish'],
        'perm' => 'readable',
        'ignore_sticky_posts' => 1,
        'tax_query' => [
            [
                'taxonomy' => 'post_tag',
                'field' => 'slug',
                'terms' => ['editors-pick'],
            ]
        ]
    ];

    if ($story_type) {
        $picksQuery['tax_query']['relation'] = 'AND';
        $picksQuery['tax_query'][] = [
            'taxonomy' => 'story_type',
            'field' => 'slug',
            'terms' => [$story_type],
        ];
    }

    $editorsPicks = new TimberPostQuery($picksQuery);
    if (count($editorsPicks->get_posts())) {
        $picksList = [];
        foreach ($editorsPicks->get_posts() as $pick) {
            $pickTeaser = $post_list_args['transformer_function']($pick, $post_list_args['transformer_args']);
            $picksList[] = $pickTeaser;
        }
        $postListRenderArgs['posts'] = array_merge($picksList, $postListRenderArgs['posts']);
    }
}

if (is_category()) {
    $postListRenderArgs['posts'] = array_map(function ($post_args) {
        $post_args['primary_category'] = false;
        return $post_args;
    }, $postListRenderArgs['posts']);
}

$postList = Timber::compile($templateParts->getTwigPath() . '/post-list.twig', $postListRenderArgs);
$context['postList'] = $postList;

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
    'templates/archive-' . $story_type . '.twig',
    'templates/archive-' . get_post_type() . '.twig',
    'templates/archive.twig'
], $context);
