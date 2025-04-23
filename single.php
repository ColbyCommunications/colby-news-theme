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

$template_part = new NC_Blocks\TemplatePart( $context );

$context['post']->entry_footer = get_newcity_colby_news_entry_footer();

$blog_home = get_option( 'page_for_posts' );

$context['postHeader'] = $template_part->build( 'storyHeader' );

// Get the post primary category
$post_id           = get_the_ID();
$primary_term_name = yoast_get_primary_term( 'category', $post_id );

// Get the latest five related stories by category
$relatedArgs = array(
	'category_name'       => $primary_term_name,
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 5,
	'ignore_sticky_posts' => 1,
	'order'               => 'DESC',
	'post__not_in'        => array( $post_id ),
);

$relatedQuery = new WP_Query( $relatedArgs );
$relatedItems = $relatedQuery->get_posts();

$items_with_data = array();

foreach ( $relatedItems as $relatedItem ) {
	$post_id = $relatedItem->ID;

	// $featured_image = get_the_post_thumbnail( $post_id, 'teaser_new' );
	$image_id = get_post_thumbnail_id($post_id);
	$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
	$image_path     = wp_parse_url( wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'original' ) )['path'];
	$summary        = get_post_meta( $post_id, 'summary', true );
	$featured_image = <<<EOD
    <img
        width="1080" 
        height="720"
        class="attachment-teaser_new size-teaser_new wp-post-image"
        decoding="async" 
        loading="lazy"
        srcset="
            https://news.colby.edu/cdn-cgi/image/width=1080,quality=60,format=auto/https://news.colby.edu{$image_path} 1080w, 
            https://news.colby.edu/cdn-cgi/image/width=300,quality=60,format=auto/https://news.colby.edu{$image_path} 300w, 
            https://news.colby.edu/cdn-cgi/image/width=1024,quality=60,format=auto/https://news.colby.edu{$image_path} 1024w, 
            https://news.colby.edu/cdn-cgi/image/width=600,quality=60,format=auto/https://news.colby.edu{$image_path} 600w, 
            https://news.colby.edu/cdn-cgi/image/width=1536,quality=60,format=auto/https://news.colby.edu{$image_path} 1536w, 
            https://news.colby.edu/cdn-cgi/image/width=2048,quality=60,format=auto/https://news.colby.edu{$image_path} 2048w, 
            https://news.colby.edu/cdn-cgi/image/width=100,quality=60,format=auto/https://news.colby.edu{$image_path} 100w, 
            https://news.colby.edu/cdn-cgi/image/width=540,quality=60,format=auto/https://news.colby.edu{$image_path} 540w, 
            https://news.colby.edu/cdn-cgi/image/width=800,quality=60,format=auto/https://news.colby.edu{$image_path} 800w, 
            https://news.colby.edu/cdn-cgi/image/width=640,quality=60,format=auto/https://news.colby.edu{$image_path} 640w, 
            https://news.colby.edu/cdn-cgi/image/width=320,quality=60,format=auto/https://news.colby.edu{$image_path} 320w, 
            https://news.colby.edu/cdn-cgi/image/width=1090quality=60,format=auto/https://news.colby.edu{$image_path} 1090w, 
            https://news.colby.edu/cdn-cgi/image/width=400,quality=60,format=auto/https://news.colby.edu{$image_path} 400w" 
        sizes="(max-width: 1080px) 100vw, 1080px"
        alt="$image_alt"
    />
    EOD;
	$post_data      = array(
		'post_title'     => $relatedItem->post_title,
		'slug'           => $relatedItem->post_name,
		'featured_image' => $featured_image,
		'summary'        => $summary,
	);

	$items_with_data[] = $post_data;
}

$context['items'] = $items_with_data;

$highlightsArgs = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 2,
	'ignore_sticky_posts' => 1,
	'order'               => 'DESC',
	'tag'                 => 'editors-pick',
	'post__not_in'        => array( $post_id ),
);

$highlightsQuery = new WP_Query( $highlightsArgs );
$highlightsItems = $highlightsQuery->get_posts();

$highlights_with_data = array();

foreach ( $highlightsItems as $highlightsItem ) {
	$post_id = $highlightsItem->ID;

	// $featured_image = get_the_post_thumbnail( $post_id );
	$image_id = get_post_thumbnail_id($post_id);
	$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
	$image_path     = wp_parse_url( wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'original' ) )['path'];
	$featured_image = <<<EOD
    <img
        width="1600" 
        height="1067"
        class="after:content-empty after:absolute after:inset-0 after:bg-black after:bg-opacity-0 group-hover:after:bg-opacity-10 after:transition-colors"
        decoding="async" 
        loading="lazy"
        srcset="
            https://news.colby.edu/cdn-cgi/image/width=1600,quality=60,format=auto/https://news.colby.edu{$image_path} 1600w, 
            https://news.colby.edu/cdn-cgi/image/width=300,quality=60,format=auto/https://news.colby.edu{$image_path} 300w, 
            https://news.colby.edu/cdn-cgi/image/width=1024,quality=60,format=auto/https://news.colby.edu{$image_path} 1024w, 
            https://news.colby.edu/cdn-cgi/image/width=600,quality=60,format=auto/https://news.colby.edu{$image_path} 600w, 
            https://news.colby.edu/cdn-cgi/image/width=1536,quality=60,format=auto/https://news.colby.edu{$image_path} 1536w, 
            https://news.colby.edu/cdn-cgi/image/width=2048,quality=60,format=auto/https://news.colby.edu{$image_path} 2048w, 
            https://news.colby.edu/cdn-cgi/image/width=100,quality=60,format=auto/https://news.colby.edu{$image_path} 100w, 
            https://news.colby.edu/cdn-cgi/image/width=540,quality=60,format=auto/https://news.colby.edu{$image_path} 540w, 
            https://news.colby.edu/cdn-cgi/image/width=800,quality=60,format=auto/https://news.colby.edu{$image_path} 800w, 
            https://news.colby.edu/cdn-cgi/image/width=640,quality=60,format=auto/https://news.colby.edu{$image_path} 640w, 
            https://news.colby.edu/cdn-cgi/image/width=320,quality=60,format=auto/https://news.colby.edu{$image_path} 320w, 
            https://news.colby.edu/cdn-cgi/image/width=1090quality=60,format=auto/https://news.colby.edu{$image_path} 1090w, 
            https://news.colby.edu/cdn-cgi/image/width=400,quality=60,format=auto/https://news.colby.edu{$image_path} 400w" 
        sizes="(max-width: 1600px) 100vw, 1600px"
        alt="$image_alt"
    />
    EOD;
	$is_video       = false;
	if ( has_post_format( 'video', $post_id ) ) {
		$is_video = true;
	}

	$post_data = array(
		'post_title'     => $highlightsItem->post_title,
		'slug'           => $highlightsItem->post_name,
		'featured_image' => $featured_image,
		'withVideoLogo'  => $is_video,
	);

	$highlights_with_data[] = $post_data;
}

$context['highlights'] = $highlights_with_data;


if ( post_password_required( $post->ID ) ) {
	Timber::render(
		'templates/password-required-' . $post->ID . '.twig',
		'templates/password-required-' . $post->type . '.twig',
		'templates/password-required.twig',
		$context
	);
} else {
	Timber::render(
		array(
			'templates/single-' . $post->ID . '.twig',
			'templates/single-' . $post->post_type . '.twig',
			'templates/single.twig',
		),
		$context
	);
}
