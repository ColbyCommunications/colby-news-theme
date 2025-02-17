<?php

ini_set( 'max_execution_time', 600 );

require_once __DIR__ . '/wp-cli.php';

/**
 * Functions and definitions for newcity/timber-starter theme
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package colby-news-theme
 */

function nc_display_post_blocks() {
	 global $post;
	if ( $post && is_single() ) {
		do_action( 'qm/info', esc_html( $post->post_content ) );
	}
}

add_action( 'wp_footer', 'nc_display_post_blocks' );

if ( ! is_file( __DIR__ . '/vendor/autoload.php' ) ) {
	wp_die(
		'<h1>Missing <code>autoload.php</code></h1>
            <p>This theme requires a Composer autoload file, but none was found.
               You may need to run <code>composer install</code> in the
               theme directory, or add a composer install step to your
               build process.</p>
          '
	);
}

require_once __DIR__ . '/vendor/autoload.php';

if ( is_file( __DIR__ . '/gutenberg-blocks/register-blocks.php' ) ) {
	require_once __DIR__ . '/gutenberg-blocks/register-blocks.php';
}

if ( is_file( __DIR__ . '/gutenberg-blocks/register-templates.php' ) ) {
	require_once __DIR__ . '/gutenberg-blocks/register-templates.php';
}

if ( is_file( get_template_directory() . '/gutenberg-blocks/components/block-components.php' ) ) {
	require_once get_template_directory() . '/gutenberg-blocks/components/block-components.php';
}

if ( ! class_exists( 'Timber\Timber' ) ) {
	wp_die(
		'<h1>Missing Requirement</h1>
            <p>This theme requires Timber to function, but it is not loaded.
               You may need to run <code>composer install</code> in the
               theme directory.</p>
            <p>For more details, visit
            <a href="https://timber.github.io/docs/getting-started/setup/">
                https://timber.github.io/docs/getting-started/setup/
            </a>'
	);
}

$timber = new Timber\Timber();

function nc_get_breadcrumbs( $post_id = null, $include_home = true ) {
	$post_id = $post_id ?? get_the_ID();
	if ( ! $post_id ) {
		return false;
	}

	if ( ! has_post_parent( $post_id ) ) {
		return false;
	}

	$ancestors = get_post_ancestors( $post_id );

	if ( ! $ancestors ) {
		return false;
	}

	$ancestors = array_reverse( $ancestors );

	$breadcrumbs = array_map(
		function ( $id ) {
			return array(
				'title' => get_the_title( $id ),
				'url'   => get_permalink( $id ),
			);
		},
		$ancestors
	);

	if ( $include_home ) {
		array_unshift(
			$breadcrumbs,
			array(
				'title' => 'Home',
				'url'   => get_home_url(),
			)
		);
	}

	return $breadcrumbs;
}

function nc_get_top_ancestor( $post_id = null, $exclude_current = false ) {
	$post_id = $post_id ?? get_the_ID();

	$all_ancestors = get_post_ancestors( $post_id );

	if ( ! is_array( $all_ancestors ) || ! count( $all_ancestors ) ) {
		if ( $exclude_current ) {
			return false;
		}

		return $post_id;
	}

	return $all_ancestors[ count( $all_ancestors ) - 1 ];
}

function nc_get_siblings( $post_id = null ) {
	$post_id = $post_id ?? get_the_ID();
	if ( ! $post_id ) {
		do_action( 'qm/notice', 'No post id found' );
		return false;
	}

	if ( ! has_post_parent( $post_id ) ) {
		do_action( 'qm/notice', 'No siblings found' );
		return false;
	}

	$parent = get_post_parent( $post_id );

	$args = array(
		'orderby'     => 'menu_order',
		'post_parent' => $parent->ID,
		'post_type'   => get_post_type( $post_id ),
		'post_status' => 'publish',
	);

	$children = array_map(
		function ( $child_post ) use ( $post_id ) {
			return array(
				'title'   => get_the_title( $child_post ),
				'url'     => get_post_permalink( $child_post ),
				'current' => $child_post->ID === $post_id,
			);
		},
		get_children( $args )
	);

	return $children;
}

function nc_get_child_links( $post_id, $current_match = null, $max_depth = -1, $current_depth = 0 ) {
	$post_id = $post_id ?? get_the_ID();
	if ( ! $post_id ) {
		do_action( 'qm/notice', 'No post id found' );
		return false;
	}

	$args = array(
		'orderby'     => 'menu_order',
		'post_parent' => $post_id,
		'order'       => 'ASC',
		'post_type'   => get_post_type( $post_id ),
		'post_status' => 'publish',
	);

	$nav_links = get_posts( $args );

	if ( ! is_array( $nav_links ) ) {
		return false;
	}

	return array_map(
		function ( $child_post ) use ( $current_match, $max_depth, $current_depth ) {
			$link['ID']     = $child_post->ID;
			$link['title']  = $child_post->post_title;
			$link['url']    = get_permalink( $child_post->ID );
			$link['active'] = $current_match === $child_post->ID;

			if ( $max_depth === -1 || $current_depth < $max_depth - 1 ) {
				$link['children']     = nc_get_child_links( $child_post->ID, $current_match, $max_depth, $current_depth + 1 );
				$children_ids         = array_map(
					function ( $child ) {
						return $child['ID'];
					},
					$link['children']
				);
				$link['child_active'] = array_search( true, array_column( $link['children'], 'child_active' ) ) !== false || in_array( $current_match, $children_ids );
			} else {
				$link['children'] = false;
			}

			return $link;
		},
		$nav_links
	);
}

function nc_get_section_nav( $post_id = null, $args = array() ) {
	$mergedArgs = wp_parse_args(
		$args,
		array(
			'show_children' => true,
			'depth'         => -1,
		)
	);

	$post_id = $post_id ?? get_the_ID();
	if ( ! $post_id ) {
		do_action( 'qm/notice', 'No post id found' );
		return false;
	}

	$current_post_ancestors = get_post_ancestors( $post_id );

	$top_ancestor = nc_get_top_ancestor( $post_id );
	if ( ! $top_ancestor ) {
		return false;
	}

	$nav_links = nc_get_child_links( $top_ancestor, $post_id, $mergedArgs['depth'] );

	if ( ! $nav_links ) {
		return false;
	}

	return $nav_links;
}

// Set archive titles
function nc_colby_archive_titles( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'nc_colby_archive_titles' );

if ( ! function_exists( 'newcity_customizer_control' ) ) :
	function newcity_add_customizer_control( $args, $wp_customize ) {
		$default_args = array(
			'name'        => '',
			'label'       => '',
			'description' => '',
			'default'     => '',
			'type'        => 'text',
			'section'     => '',
			'priority'    => 10,
		);

		$args = wp_parse_args( $args, $default_args );

		if ( $args['name'] && $args['section'] ) {
			$wp_customize->add_setting(
				$args['name'],
				array(
					'default'           => __( $args['default'], 'colby-news-theme' ),
					'sanitize_callback' => ! empty( $args['sanitize_callback'] ) ? $args['sanitize_callback'] : 'sanitize_text_field',
					'transport'         => 'refresh',
				)
			);

			$wp_customize->add_control(
				$args['name'],
				array(
					'type'        => $args['type'],
					'priority'    => $args['priority'],
					'section'     => $args['section'],
					'label'       => $args['label'],
					'description' => $args['description'],
				)
			);
		}
	}
endif;

if ( ! function_exists( 'newcity_customizer_controls' ) ) :
	function newcity_add_customizer_controls( $section, $controls, $wp_customize, $starting_priority = 0 ) {
		foreach ( $controls as $key => $control ) {
			$control['section'] = $section;
			if ( empty( $control['priority'] ) ) {
				$control['priority'] = ( ( $key + 1 ) * 10 ) + $starting_priority;
			}
			newcity_add_customizer_control( $control, $wp_customize );
		}
	}
endif;

if ( ! function_exists( 'newcity_social_icons' ) ) :
	function newcity_social_icons( string $url, $args = array() ) {

		$socialIconDetails = array(
			array(
				'url'   => 'facebook.com',
				'icon'  => 'social-facebook',
				'label' => 'Colby News Facebook Page',
				'color' => '',
			),
			array(
				'url'   => 'twitter.com',
				'icon'  => 'social-twitter',
				'label' => 'Colby News Twitter Feed',
				'color' => 'hover:text-[#F00]',
			),
			array(
				'url'   => 'linkedin.com',
				'icon'  => 'social-linkedin',
				'label' => 'Colby News LinkedIn Page',
				'color' => '',
			),
			array(
				'url'   => 'snapchat.com',
				'icon'  => 'social-snapchat',
				'label' => 'Colby News Snapchat Feed',
				'color' => '',
			),
			array(
				'url'   => 'instagram.com',
				'icon'  => 'social-instagram',
				'label' => 'Colby News Instagram Feed',
				'color' => '',
			),
			array(
				'url'   => 'youtube.com',
				'icon'  => 'social-instagram',
				'label' => 'Colby News YouTube Channel',
				'color' => '',
			),
			array(
				'url'   => 'vimeo.com',
				'icon'  => 'social-vimeo',
				'label' => 'Colby News Vimeo Channel',
				'color' => '',
			),
			array(
				'url'   => 'flickr.com',
				'icon'  => 'social-flickr',
				'label' => 'Colby News Flickr',
				'color' => '',
			),
		);

		if ( ! function_exists( 'getIconDetails' ) ) {
			function getIconDetails( $url, $socialIconDetails ) {
				for ( $i = 0; $i < count( $socialIconDetails ); $i += 1 ) {
					if ( strpos( $url, $socialIconDetails[ $i ]['url'] ) ) {
						return $socialIconDetails[ $i ];
					}
				}

				return false;
			}
		}

		$iconDetails = getIconDetails( $url, $socialIconDetails );

		if ( ! $iconDetails ) {
			return false;
		}

		$width      = empty( $args['width'] ) ? 20 : $args['width'];
		$height     = empty( $args['height'] ) ? 20 : $args['height'];
		$hiddenText = empty( $args['title'] ) ? $iconDetails['label'] : $args['title'];

		$iconArgs = array(
			'width'      => $width,
			'height'     => $height,
			'icon'       => $iconDetails['icon'],
			'hiddenText' => $hiddenText,
			'cssIcon'    => true,
			'rawSprite'  => true,
		);

		$component = new \NC_Blocks\Component();

		$color = array_key_exists( 'color', $iconDetails ) ? $iconDetails['color'] : '';
		return "<a href='$url' class='block social-link focus:outline-white'>
		            <span class='sr-only'>$hiddenText</span>
		            <div class='p-2 transition transition-colors rounded-full social-icon $color'>"
		. $component->build( 'icon', $iconArgs ) .
		'</div>
		        </a>';
	}
endif;

if ( ! function_exists( 'newcity_register_widget_areas' ) ) :
	function newcity_register_widget_areas() {
		register_sidebar(
			array(
				'name'          => 'Main Menu Widgets',
				'id'            => 'main_menu_widgets',
				'before_widget' => '<div>',
				'after_widget'  => '</div>',
			)
		);

		register_sidebar(
			array(
				'name'          => 'Footer Links',
				'id'            => 'footer_widgets',
				'before_widget' => '<div>',
				'after_widget'  => '</div>',
			)
		);
	}
	add_action( 'widgets_init', 'newcity_register_widget_areas' );
endif;

if ( ! function_exists( 'newcity_colby_news_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function newcity_colby_news_setup() {
		/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on colby-news-theme, use a find and replace
		* to change 'colby-news-theme' to the name of your theme in all the template files.
		*/
		load_theme_textdomain( 'colby-news-theme', get_template_directory() . '/languages' );

		// Allow featured image on blog posts
		add_theme_support( 'post-thumbnails', array( 'post', 'external_post' ) );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		remove_theme_support( 'core-block-patterns' );

		add_theme_support(
			'post-formats',
			array(
				'video',
			)
		);

		/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
		add_theme_support( 'title-tag' );

		/** Imports TemplatePart class for creating global header, footer, etc. */
		if ( file_exists( get_template_directory() . '/views/template-parts.php' ) ) {
			require get_template_directory() . '/views/template-parts.php';
		}

		/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		// add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-primary'       => esc_html__( 'Primary Site Nav', 'colby-news-theme' ),
				'menu-secondary'     => esc_html__( 'Secondary Site Nav', 'colby-news-theme' ),
				'menu-footer-social' => esc_html__( 'Social Media Links for Footer', 'colby-news-theme' ),
			)
		);

		// Add locations for Twig files
		Timber\Timber::$dirname = array( Timber\Timber::$dirname, 'gutenberg-blocks/blocks-twig' );
		$timber_dir             = Timber\Timber::$dirname;

		// Add the registered menu to Timber for Twig access
		// add_filter('timber/context', 'add_menus_to_context');
		function add_menus_to_context( $context ) {
			$context['menu_primary']   = new \Timber\Menu( 'menu-primary' );
			$context['menu_secondary'] = new \Timber\Menu( 'menu-secondary' );

			$socialMenu = new \Timber\Menu( 'menu-footer-social' );

			if ( $socialMenu ) {
				$socialMenuWithIcons = array(
					'id'      => $socialMenu->id,
					'term_id' => $socialMenu->term_id,
					'name'    => $socialMenu->name,
					'title'   => $socialMenu->title,
				);
			}

			$socialItems = $socialMenu->items;

			if ( is_array( $socialItems ) ) {
				$socialMenuWithIcons['items'] = array_map(
					function ( $item ) {
						if ( is_string( $item->url ) ) {
								   // Social Icon dimension classes: 'w-5 h-5'
								$socialIcon = newcity_social_icons(
									$item->url,
									array(
										'title'  => $item->title,
										'width'  => 5,
										'height' => 5,
									)
								);
							if ( ! $socialIcon ) {
								return $item;
							}

							return $socialIcon;
						}
						return $item;
					},
					$socialItems
				);
			}

			$context['menu_footer_social'] = $socialMenuWithIcons;

			return $context;
		}

		add_filter( 'timber/context', 'add_template_parts_to_context' );
		function add_template_parts_to_context( $context ) {
			$context = add_header_stuff_to_context( $context );

			$template_part          = new NC_Blocks\TemplatePart( $context );
			$context['site_header'] = $template_part->build( 'siteHeader', array() );

			$context['site_footer'] = $template_part->build( 'siteFooter', array() );
			return $context;
		}

		// Add the header and footer settings to the context
		function add_header_stuff_to_context( $context ) {
			$component = new NC_Blocks\Component();

			$context['iconSprites'] = get_template_directory_uri() . '/assets/icons/icon-sprites.svg';

			$context['headerInfoSlug'] = '<span>' . str_replace( ' • ', '</span><span>', get_bloginfo( 'description' ) ) . '</span>';

			$headerLogoID = get_theme_mod( 'custom_logo' );
			if ( $headerLogoID ) {
				$context['headerLogo'] = wp_get_attachment_image( $headerLogoID, 'full' );
			} else {
				$context['headerLogo'] = '<img src="' . get_stylesheet_directory_uri() . '/assets/images/header_logo.svg' . '" alt="Colby College Division of Research" />';
			}

			$context['homeLink'] = array(
				'title' => 'Back to ' . get_bloginfo( 'name' ) . ' Home',
				'url'   => get_home_url(),
			);

			$copyright_raw        = get_theme_mod(
				'newcity_colby_news_copyright_text',
				'©%year% Colby News.'
			);
			$context['copyright'] = str_replace( '%year%', date( 'Y' ), $copyright_raw );

			return $context;
		}

		/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		// add_theme_support(
		//     'custom-background',
		//     apply_filters(
		//         '_s_custom_background_args',
		//         array(
		//             'default-color' => 'ffffff',
		//             'default-image' => '',
		//         )
		//     )
		// );

		// Remove control panel for selecting theme colors
		// add_theme_support('editor-color-palette');
		// add_theme_support('disable-custom-colors');

		// Add theme support for selective refresh for widgets.
		// add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		add_image_size( 'medium_large', 600, 600, false );
		add_image_size( 'square_icon', 80, 80, array( 'center', 'center' ) );
		add_image_size( 'square', 300, 300, array( 'center', 'top' ) );
		add_image_size( 'routing_card', 350, 500, array( 'center', 'center' ) );
		add_image_size( 'logo', 100, 100 );
		add_image_size( 'teaser', 540, 360, array( 'center', 'center' ) );
		add_image_size( 'teaser_new', 1080, 720, array( 'center', 'center' ) );
		add_image_size( 'teaser_small', 320, 180, array( 'center', 'center' ) );
		add_image_size( 'teaser_large', 800, 450, array( 'center', 'center' ) );
		add_image_size( 'header_vertical_lg', 800, 1066 );
		add_image_size( 'header_vertical_md', 640, 850 );
		add_image_size( 'header_vertical_sm', 320, 425 );
		add_image_size( 'landscape_full_xl', 2400 );
		add_image_size( 'landscape_full_lg', 1090 );
		add_image_size( 'landscape_full_md', 800 );
		add_image_size( 'landscape_full_sm', 400 );
	}
endif;
add_action( 'after_setup_theme', 'newcity_colby_news_setup' );

if ( ! function_exists( 'nc_fallback_image' ) ) {
	function nc_fallback_image() {
		$relative_file_path = '/assets/images/placeholder.png';
		$parent_placeholder = get_template_directory() . $relative_file_path;
		$child_placeholder  = get_stylesheet_directory() . $relative_file_path;

		if ( file_exists( $child_placeholder ) ) {
			return get_stylesheet_directory_uri() . $relative_file_path;
		}

		if ( file_exists( $parent_placeholder ) ) {
			return get_template_directory_uri() . $relative_file_path;
		}

		return false;
	}
}

/**
 * Force dimensions of default image sizes, if necessary
 */
if ( ! function_exists( 'newcity_image_size_force' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function newcity_image_size_setup() {
		// update_option( 'thumbnail_size_w', 180 );
		// update_option( 'thumbnail_size_h', 180 );
		// update_option( 'thumbnail_crop', 1 );
		update_option( 'medium_size_w', 350 );
		update_option( 'medium_size_h', 350 );
		update_option( 'large_size_w', 800 );
		update_option( 'large_size_h', 450 );
	}
endif;
add_action( 'switch_theme', 'newcity_image_size_force' );

// add_filter('pre_update_option_thumbnail_size_w', 'newcity_filter_thumbnail_size_w');
// function newcity_filter_thumbnail_size_w($newvalue)
// {
//     return 180;
// }
// add_filter('pre_update_option_thumbnail_size_h', 'newcity_filter_thumbnail_size_h');
// function newcity_filter_thumbnail_size_h($newvalue)
// {
//     return 180;
// }
// add_filter('pre_update_option_thumbnail_crop', 'newcity_filter_thumbnail_crop');
// function newcity_filter_thumbnail_crop($newvalue)
// {
//     return 1;
// }
add_filter( 'pre_update_option_medium_size_w', 'newcity_filter_medium_size_w' );
function newcity_filter_medium_size_w( $newvalue ) {
	return 350;
}
add_filter( 'pre_update_option_medium_size_h', 'newcity_filter_medium_size_h' );
function newcity_filter_medium_size_h( $newvalue ) {
	return 350;
}
// add_filter('pre_update_option_large_size_w', 'newcity_filter_large_size_w');
// function newcity_filter_large_size_w($newvalue)
// {
//     return 660;
// }
// add_filter('pre_update_option_large_size_h', 'newcity_filter_large_size_h');
// function newcity_filter_large_size_h($newvalue)
// {
//     return 660;
// }

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function newcity_colby_news_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'newcity_colby_news_content_width', 640 );
}
add_action( 'after_setup_theme', 'newcity_colby_news_content_width', 0 );

/**
 * Register Google Fonts
 */
function newcity_colby_news_fonts_url() {
	$fonts_url = 'https://fonts.googleapis.com/css2?family=Libre+Franklin:ital,wght@0,100;0,400;0,600;0,800;1,100;1,400;1,600;1,800&display=swap';

	return $fonts_url;
}

/**
 * Enqueue scripts and styles.
 */
function newcity_colby_news_scripts() {
	wp_enqueue_style(
		'gutenbergbase-style',
		get_template_directory_uri() . '/assets/css/tailwind.css',
		null,
		filemtime( get_template_directory() . '/assets/css/tailwind.css' )
	);

	// wp_enqueue_style(
	//     'tailwind-styles',
	//     get_stylesheet_uri(),
	//     null,
	//     filemtime(get_stylesheet_directory() . '/style.css')
	// );

	wp_enqueue_style(
		'colby-news-themeblocks-style',
		get_template_directory_uri() . '/css/blocks.css',
		null,
		filemtime( get_template_directory() . '/css/blocks.css' )
	);

	wp_enqueue_style(
		'colby-news-theme-fonts',
		newcity_colby_news_fonts_url(),
		array(),
		null,
	);

	wp_enqueue_script(
		'micromodal-library',
		'//unpkg.com/micromodal/dist/micromodal.min.js',
		array( 'jquery' ),
		'',
		true
	);

	wp_enqueue_script(
		'focus-visible-polyfill',
		'https://cdn.jsdelivr.net/npm/focus-visible@5.2.0/dist/focus-visible.min.js',
		array( 'jquery' ),
		'',
		true
	);

	wp_enqueue_script(
		'colby-news-theme-navigation',
		get_template_directory_uri() . '/js/site-header.js',
		array( 'jquery', 'micromodal-library' ),
		filemtime( get_template_directory() . '/js/site-header.js' ),
		true
	);

	wp_enqueue_script(
		'algolia-search',
		'https://cdn.jsdelivr.net/npm/algoliasearch@4.5.1/dist/algoliasearch.umd.js',
		null,
		true
	);

	wp_enqueue_script(
		'instant-search',
		'https://cdnjs.cloudflare.com/ajax/libs/instantsearch.js/4.23.0/instantsearch.production.min.js',
		null,
		true
	);

	wp_enqueue_script(
		'algolia-insights',
		get_template_directory_uri() . '/js/insightsScript.js',
		null,
		true
	);

	wp_enqueue_script(
		'colby-news-site-search',
		get_template_directory_uri() . '/js/site-search.js',
		array( 'algolia-search', 'instant-search', 'algolia-insights' ),
		filemtime( get_template_directory() . '/js/site-search.js' ),
		true
	);

	wp_enqueue_script(
		'social-sharing',
		get_template_directory_uri() . '/js/social-sharing.js',
		array(),
		filemtime( get_template_directory() . '/js/social-sharing.js' ),
		true
	);

	wp_enqueue_script(
		'main',
		get_template_directory_uri() . '/assets/main.js',
		array(),
		filemtime( get_template_directory() . '/assets/main.js' ),
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'newcity_colby_news_scripts' );

add_action(
	'enqueue_block_editor_assets',
	function () {
		wp_enqueue_script(
			'hide-editor-panels',
			get_template_directory_uri() . '/js/hide-editor-panels.js',
			array(),
			false,
			true
		);
	}
);

wp_register_style( 'material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons+Sharp' );
wp_enqueue_style( 'material-icons' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function twentytwenty_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'twentytwenty_skip_link_focus_fix' );

function newcity_colby_news_enqueue_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = 'https://fonts.gstatic.com';
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'newcity_colby_news_enqueue_resource_hints', 10, 2 );

add_theme_support( 'responsive-embeds' );
add_theme_support( 'editor-styles' );

function newcity_colby_news_add_editor_style() {
	add_editor_style(
		get_template_directory_uri() . '/assets/css/tailwind.css'
	);

	add_editor_style(
		'editor-styles-custom.css'
	);
}

add_action( 'after_setup_theme', 'newcity_colby_news_add_editor_style' );
add_action( 'pre_get_posts', 'newcity_colby_news_add_editor_style' );

function newcity_colby_news_add_editor_scripts() {
	wp_enqueue_script(
		'hide-blocks',
		get_template_directory_uri() . '/js/hide-blocks.js',
		array(),
		filemtime( get_template_directory() . '/js/hide-blocks.js' )
	);
}
add_action( 'enqueue_block_editor_assets', 'newcity_colby_news_add_editor_scripts' );

/**
 * Implement the Custom Header feature.
 */
// require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Register custom post types
 */
require get_template_directory() . '/inc/post-types.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Theme Settings
 */
require get_template_directory() . '/inc/theme-options.php';

add_filter( 'relevanssi_excerpt_content', 'nc_relevanssi_remove_content' );
function nc_relevanssi_remove_content( $content ) {
	return preg_replace( '#<(.*) class=".*?relevanssi_noindex".*?</\1>#ms', '', $content );
}

if ( file_exists( get_template_directory() . '/inc/rest-api.php' ) ) {
	require get_template_directory() . '/inc/rest-api.php';
}

/**
 * Customized favicon
 */
// require get_template_directory() . '/inc/favicon.php';

/** Modify OpenGraph tags to add a version */
add_filter( 'wpseo_opengraph_image', 'nc_opengraph_image' );

function nc_opengraph_image( $url ) {

	$file = get_attached_file( get_post_thumbnail_id() );
	return $url . '?v=' . filemtime( $file );
}

add_filter( 'wpseo_opengraph_type', 'yoast_change_opengraph_type', 10, 1 );

function yoast_change_opengraph_type( $type ) {

	if ( is_archive() ) {
		return 'website';
	} else {
		return $type;
	}
}

/**
 * Dump variable.
 */
if ( ! function_exists( 'd' ) ) {
	function d() {
		call_user_func_array( 'dump', func_get_args() );
	}
}

/**
 * Dump variables and die.
 */
if ( ! function_exists( 'dd' ) ) {
	function dd() {
		call_user_func_array( 'dump', func_get_args() );
		die();
	}
}

function exclude_post_types( $should_index, WP_Post $post ) {
	// Add all post types you don't want to make searchable.
	$excluded_post_types = array( 'page' );
	if ( false === $should_index ) {
		return false;
	}

	return ! in_array( $post->post_type, $excluded_post_types, true );
}

// Hook into Algolia to manipulate the post that should be indexed.
add_filter( 'algolia_should_index_searchable_post', 'exclude_post_types', 10, 2 );

add_filter(
	'algolia_post_images_sizes',
	function ( $sizes ) {
		$sizes[] = 'teaser_new';

		return $sizes;
	}
);

if ( ! wp_next_scheduled( 'page_metrics' ) ) {
	$time = strtotime( 'today' );
	$time = $time + 75600;
	wp_schedule_event( $time, 'daily', 'page_metrics' );
}

add_action( 'rest_api_init', 'create_api_posts_meta_field' );

function create_api_posts_meta_field() {
	// register_rest_field ( 'name-of-post-type', 'name-of-field-to-return', array-of-callbacks-and-schema() )
	register_rest_field(
		'post',
		'post-meta-fields',
		array(
			'get_callback' => 'get_post_meta_for_api',
			'schema'       => null,
		)
	);

	register_rest_field(
		'external_post',
		'external_url',
		array(
			'get_callback' => 'get_external_post_meta_for_api',
			'schema'       => null,
		)
	);
}

function get_external_post_meta_for_api( $object ) {
	// get the id of the post object array
	$post_id = $object['id'];
	// return the post meta
	$external_url = get_field( 'external_url', $post_id );
	return $external_url;
}

function get_post_meta_for_api( $object ) {
	// get the id of the post object array
	$post_id = $object['id'];
	// return the post meta
	$primary_term_name = yoast_get_primary_term( 'category', $post_id );
	return array_merge( array( 'primary_category' => $primary_term_name ), get_post_meta( $post_id ) );
}

function filter_rest_external_post_query( $args, $request ) {
	$params = $request->get_params();
	if ( isset( $params['story_type_slug'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'story_type',
				'field'    => 'slug',
				'terms'    => $params['story_type_slug'],
			),
		);
	}
	return $args;
}
// add the filter
add_filter( 'rest_external_post_query', 'filter_rest_external_post_query', 10, 2 );

add_action( 'page_metrics', 'page_metrics_function' );
function page_metrics_function() {
	// get data from SiteImprove API
	$ch = curl_init();
	curl_setopt_array(
		$ch,
		array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL            => 'https://api.siteimprove.com/v2/sites/28518335051/analytics/content/all_pages?page=1&page_size=1000&period=this_month&search_in=url',
			CURLOPT_USERPWD        => PLATFORM_VARIABLES['gaceto_siteimprove_api_creds'],
		)
	);
	$response_json = curl_exec( $ch );
	curl_close( $ch );
	$response = json_decode( $response_json, true );

	// get all published WP posts
	$args = array(
		'numberposts' => -1,
		'post_type'   => 'post',
		'post_status' => 'publish',
	);

	$all_posts = get_posts( $args );

	// iterate over all posts
	foreach ( $all_posts as $post ) {
		// extract post data
		$id         = $post->ID;
		$post_title = $post->post_title;
		$post_slug  = $post->post_name;

		// filter SiteImprove data, matching on slug
		$filtered_array = array_filter(
			$response['items'],
			function ( $item ) use ( $post_slug ) {
				$processed_slug = filter_slug( $item['url'], $item['title'] );

				if ( $processed_slug ) {
					return $processed_slug === $post_slug;
				} else {
					return false;
				}
			}
		);

		if ( $filtered_array ) {
			// we have a match
			$slug       = array_values( $filtered_array )[0]['url'];
			$page_views = array_values( $filtered_array )[0]['page_views'];
			$title      = array_values( $filtered_array )[0]['title'];

			update_post_meta( $id, 'siteimprove_page_views', $page_views );
		} else {
			// we dont
			update_post_meta( $id, 'siteimprove_page_views', 0 );
		}
	}
	shell_exec( 'wp algolia reindex searchable_posts' );
}

/**
 * Filter and return slug from a url. Also filter
 * out 'page not found'
 *
 * @return false if not successful. String if filtered successfully
 *
 */
function filter_slug( $slug, $title ) {
	$pattern = '^https://news.colby.edu/story/(.+)/$^';
	$result  = preg_match( $pattern, $slug, $matches );

	$final_slug = false;

	if ( false !== $result && $matches ) {
		$char_blacklist = array( '/', '%', 'wp-content', 'elementor', 'preview=' );

		$bypass = false;

		foreach ( $char_blacklist as $char ) {
			if ( stripos( $matches[1], $char ) !== false ) {
				$bypass = true;
			}
		}

		if ( $title === 'Page not found - Colby News' ) {
			$bypass = true;
		}

		if ( ! $bypass ) {
			$final_slug = $matches[1];
		}
	}

	return $final_slug;
}

function get_total_pubs() {
	 // get total of unique media publications (ie Boston Globe, WSJ, CNBC)
	$terms = get_terms( array( 'taxonomy' => 'media_source' ) );
	return count( $terms );
}

function get_all_categories() {
	 $categories            = get_categories();
	$primary_category_array = array();
	foreach ( $categories as $category ) {
		array_push( $primary_category_array, $category->name );
	};
	$key = array_search( 'Uncategorized', $primary_category_array );
	if ( $key !== false ) {
		unset( $primary_category_array[ $key ] );
		return json_encode( $primary_category_array );
	}
}

function post_shared_attributes( array $shared_attributes, WP_Post $post ) {
	// get siteimprove_page_views to send to algolia
	if ( $post->post_type === 'post' ) {
		$shared_attributes['siteimprove_page_views'] = (int) get_post_meta( $post->ID, 'siteimprove_page_views', true );
		$shared_attributes['summary']                = strip_tags( get_post_meta( $post->ID, 'summary', true ) );
		// gets the primary category
		$primary_term_name                     = yoast_get_primary_term( 'category', $post->ID );
		$shared_attributes['primary_category'] = $primary_term_name;
		// strips html tags and decodes html entities from the post title
		$shared_attributes['post_title'] = strip_tags( html_entity_decode( get_the_title( $post ) ) );
	}

	if ( $post->post_type === 'external_post' ) {
		// if we have a media_source
		if ( get_the_terms( $post->ID, 'media_source' ) ) {
			$media_source         = get_the_terms( $post->ID, 'media_source' )[0];
			$media_source_term_id = get_the_terms( $post->ID, 'media_source' )[0]->term_id;
			$media_source_logo    = get_field( 'logo', 'media_source_' . $media_source_term_id );

			// if there's a media source tag and a logo for that media source
			if ( $media_source_logo && wp_get_attachment_image_src( $media_source_logo, 'logo' ) ) {
				$image                               = wp_get_attachment_image_src( $media_source_logo, 'logo' )[0];
				$shared_attributes['external_image'] = $image;
			}

			$media_source_name = $media_source->name;
			if ( ! empty( $media_source ) ) {
				$shared_attributes['media_source'] = $media_source_name;
			}
		}

		if ( get_post_meta( $post->ID, 'external_url', true ) ) {
			$shared_attributes['external_url'] = get_post_meta( $post->ID, 'external_url', true );
		}

		// strips html tags and decodes html entities from the post title
		$shared_attributes['post_title'] = strip_tags( html_entity_decode( get_the_title( $post ) ) );
	}

	return $shared_attributes;
}

add_filter( 'algolia_searchable_post_shared_attributes', 'post_shared_attributes', 10, 2 );

add_filter( 'timber/twig', 'add_to_twig' );

function add_to_twig( $twig ) {
	// Adding a function.
	$twig->addFunction( new Timber\Twig_Function( 'get_total_pubs', 'get_total_pubs' ) );
	$twig->addFunction( new Timber\Twig_Function( 'get_all_categories', 'get_all_categories' ) );
	return $twig;
}

function custom_api_get_external_posts_with_media_source() {
	$args = array(
		'post_type'      => 'external_post',
		'posts_per_page' => -1,
		'status'         => 'publish',
	);

	$query = new WP_Query( $args );
	$posts = $query->get_posts();

	$formatted_posts = array_map(
		function ( $post ) {
			$image = '';
			$tags  = array();

			$post_tags = get_the_tags( $post );
			if ( $post_tags ) {
				foreach ( $post_tags as $tag ) {
					$tags[] = array( 'name' => $tag->slug );
				}
			}

			if ( isset( get_the_terms( $post->ID, 'media_source' )[0]->term_id ) ) {
				$media_source_term_id = get_the_terms( $post->ID, 'media_source' )[0]->term_id;
				$media_source_logo    = get_field( 'logo', 'media_source_' . $media_source_term_id );

				if ( $media_source_logo && wp_get_attachment_image_src( $media_source_logo, 'logo' ) ) {
					$image = wp_get_attachment_image_src( $media_source_logo, 'logo' )[0];
				}
			}

			return array(
				'id'           => $post->ID,
				'post_status'  => $post->post_status,
				'post_author'  => $post->post_author,
				'post_date'    => $post->post_date,
				'post_type'    => $post->post_type,
				'title'        => array( 'rendered' => $post->post_title ),
				'story_type'   => get_the_terms( $post, 'story_type' ),
				'content'      => array( 'rendered' => $post->post_content ),
				'external_url' => $post->external_url,
				'taxonomy'     => get_the_terms( $post, 'media_source' ),
				'image'        => $image,
				'tags'         => $tags,
			);
		},
		$posts
	);

	return rest_ensure_response( $formatted_posts );
}

function register_custom_api_routes() {
	register_rest_route(
		'custom/v1',
		'/external-posts',
		array(
			'methods'  => 'GET',
			'callback' => 'custom_api_get_external_posts_with_media_source',
		)
	);
}

add_action( 'rest_api_init', 'register_custom_api_routes' );


// TODO: this was producing warnings on the backend of wp
// add_action(
// 	'rest_api_init',
// 	function() {
// 		header( 'Access-Control-Allow-Origin: *' );
// 		header( 'Access-Control-Allow-Methods: GET' );
// 	}
// );

function prefix_defer_css_rel_preload( $html, $handle, $href ) {
	if ( ! is_admin() ) {
		$scriptArr = array( 'gutenbergbase-style', 'colby-news-themeblocks-style', 'colby-news-theme-fonts', 'material-icons' );
		if ( in_array( $handle, $scriptArr ) ) {
			$html = '<link rel="preload" href="' . $href . '" as="style" id="' . $handle . '" onload="this.onload=null;this.rel=\'stylesheet\'">'
			. '<noscript><link rel="preload" href="' . $href . '" as="style" id="' . $handle . '" onload="this.onload=null;this.rel=\'stylesheet\'"></noscript>';
		}
	}
	return $html;
}
add_filter( 'style_loader_tag', 'prefix_defer_css_rel_preload', 10, 3 );

function get_post_summary() {
    global $post;
    if($post && ($post->post_type == 'post')):
        $summary = get_field('summary', $post->ID);
        return $summary;
    endif;
}

function register_custom_yoast_variables() {
    wpseo_register_var_replacement( '%%Summary%%', 'get_post_summary', 'advanced', 'text from the summary field' );
}

add_action('wpseo_register_extra_replacements', 'register_custom_yoast_variables');