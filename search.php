<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package colby-news-theme
 */

use Timber\Timber;

$context = Timber::context();

$context['search_query'] = $searchQuery = get_search_query();

$context['relevanssi'] = $relevanssi = function_exists('relevanssi_the_excerpt');

$args = array(
    'post_type'        => array('post', 'page'),
    'posts_per_page'   => 10,
    's'                => $searchQuery,
    'post_status'      => 'publish',
    'relevanssi'       => true,
    'paged'            => $paged
);

$timber_posts = Timber::get_posts($args);
$context['posts'] = $timber_posts;

$search_intro_text = __('Search Results for', 'colby-news-theme');

if (count($timber_posts) > 0) {
    $context['archive'] = [
        'title' => sprintf(
            $search_intro_text . ': %s',
            '<span>' . get_search_query() . '</span>'
        ),
        'description' => get_the_archive_description(),
    ];
} else {
    $context['archive'] = [
        'title' => __('No results found', 'colby-news-theme'),
        'description' => get_the_archive_description(),
    ];

    $context['did_you_mean'] = relevanssi_didyoumean(get_search_query(false), '', '');
}

Timber::render([
    'templates/search.twig',
], $context);
