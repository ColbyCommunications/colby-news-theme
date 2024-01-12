<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package colby-news-theme
 */

use Timber\Timber;
use Timber\Post as TimberPost;

$context = Timber::context();

$context['post'] = $timber_post = new TimberPost();

$template_part = new NC_Blocks\TemplatePart($context);

$context['post']->entry_footer = get_newcity_colby_news_entry_footer();

$blog_home = get_option('page_for_posts');

$context['postHeader'] = $template_part->build('storyHeader');

// Get the post primary category
$post_id = get_the_ID();
$primary_term_name = yoast_get_primary_term('category', $post_id);

// Get the latest five related stories by category
$relatedArgs = array(
    'category_name' => $primary_term_name,
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 5,
    'ignore_sticky_posts' => 1,
    'order' => 'DESC',
    'post__not_in' => array($post_id),
);

$relatedQuery = new WP_Query($relatedArgs);
$relatedItems = $relatedQuery->get_posts();

$items_with_data = [];

foreach ($relatedItems as $relatedItem) {
    $post_id = $relatedItem->ID;

    $featured_image = get_the_post_thumbnail($post_id, 'teaser_new');
    $summary = get_post_meta($post_id, 'summary', true);

    $post_data = array(
        'post_title' => $relatedItem->post_title,
        'slug' => $relatedItem->post_name,
        'featured_image' => $featured_image,
        'summary' => $summary,
    );

    $items_with_data[] = $post_data;
}

$context['items'] = $items_with_data;

$highlightsArgs = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 2,
    'ignore_sticky_posts' => 1,
    'order' => 'DESC',
    'tag' => 'editors-pick',
    'post__not_in' => array($post_id),
);

$highlightsQuery = new WP_Query($highlightsArgs);
$highlightsItems = $highlightsQuery->get_posts();

$highlights_with_data = [];

foreach ($highlightsItems as $highlightsItem) {
    $post_id = $highlightsItem->ID;

    $featured_image = get_the_post_thumbnail($post_id);

    $is_video = false;
    if (has_post_format('video', $post_id)) {
        $is_video = true;
    }

    $post_data = array(
        'post_title' => $highlightsItem->post_title,
        'slug' => $highlightsItem->post_name,
        'featured_image' => $featured_image,
        'withVideoLogo' => $is_video,
    );

    $highlights_with_data[] = $post_data;
}

$context['highlights'] = $highlights_with_data;


if (post_password_required($post->ID)) {
    Timber::render(
        'templates/password-required-' . $post->ID . '.twig',
        'templates/password-required-' . $post->type . '.twig',
        'templates/password-required.twig',
        $context
    );
} else {
    Timber::render([
        'templates/single-' . $post->ID . '.twig',
        'templates/single-' . $post->post_type . '.twig',
        'templates/single.twig'
    ], $context);
}
