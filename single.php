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
