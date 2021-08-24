<?php

/*
Template Name: Special Project Archive
Template Post Type: page
*/

use Timber\Timber;
use NC_Blocks;

require get_template_directory() . '/shared-page-functions.php';
require_once get_template_directory() . '/gutenberg-blocks/register-blocks.php';

$context = colby_news_page\get_context();

$fields = get_fields($context['post']->ID);
$query = NC_Blocks\query_from_fields($fields, true);

$templateParts = new \NC_Blocks\TemplatePart($context);

$context['postList'] = $timber_posts = $templateParts->build('paginatedPostList', ['query' => $query]);

if (is_singular() || is_home()) {
    $title = get_the_title();
}

$context['archive'] = [
    'title' => $title,
];

if (! is_paged()) {
    $context['header_content'] = $context['post']->content;
}

Timber::render([
    'templates/archive.twig'
], $context);
