<?php

/*
Template Name: Marketing Landing Page (No Nav)
Template Post Type: page
*/

require get_template_directory() . '/shared-page-functions.php';

$context = colby_news_page\get_context();

$context['no_nav'] = true;

colby_news_page\render_page($context);
