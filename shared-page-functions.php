<?php

namespace colby_news_page;

use Timber\Timber;
use Timber\Post as TimberPost;

function get_context()
{
    $context = Timber::context();
    $context['post'] = $timber_post = new TimberPost();
    $context['is_front_page'] = is_front_page() && is_home();

    return $context;
}

function render_page($context)
{
    if (empty($context['post'])) {
        return '';
    }

    $post = $context['post'];
    if (post_password_required($post->ID)) {
        Timber::render(
            'templates/password-required-' . $post->ID . '.twig',
            'templates/password-required-' . $post->type . '.twig',
            'templates/password-required.twig',
            $context
        );
    } else {
        Timber::render([
            'templates/page-' . $post->ID . '.twig',
            'templates/page-' . $post->post_type . '.twig',
            'templates/page.twig'
        ], $context);
    }
}
