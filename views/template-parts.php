<?php

namespace NC_Blocks;

require_once( get_template_directory() . '/gutenberg-blocks/blocks-utilities.php' );
require_once( get_template_directory() . '/gutenberg-blocks/components/block-components.php' );
require_once( get_template_directory() . '/gutenberg-blocks/acf-block-functions.php' );

use Timber\Timber;
use Timber\PostQuery as TimberPostQuery;
use Timber\Image as TimberImage;

class TemplatePart {

	protected $components;
	protected $context;
	protected $twigPath;
	protected $pagination;
	protected $paginatedPostList;
	protected $fallbackImage;

	public function __construct( $context = null ) {
		$this->context       = $context ?? Timber::get_context();
		$this->twigPath      = get_template_directory() . '/views/template-parts';
		$this->fallbackImage = '';
		if ( function_exists( 'nc_fallback_image' ) ) {
			$this->fallbackImage = nc_fallback_image();
		}

		$this->components = array(
			'siteHeader'           => 'siteHeader',
			'siteFooter'           => 'siteFooter',
			'storyHeader'          => 'storyHeader',
			'pagination'           => 'pagination',
			'defaultTeaserBuilder' => 'defaultTeaserBuilder',
			'paginatedPostList'    => 'paginatedPostList',
		);
	}

	public function getTwigPath() {
		return $this->twigPath;
	}

	public function build( $component_name, $args = array(), $print = false ) {
		if ( ! isset( $this->components[ $component_name ] ) ) {
			do_action( 'qm/warn', "No definition for component '$component_name'" );
			return '';
		}

		if ( ! is_callable( array( $this, $this->components[ $component_name ] ) ) ) {
			do_action( 'qm/warn', "$component_name is not a callable method." );
			return '';
		}

		$output = call_user_func( array( $this, $this->components[ $component_name ] ), $args );

		if ( $print ) {
			echo $output;
		}

		return $output;
	}

	protected function pagination( $postList ) {
		if ( isset( $this->pagination ) ) {
			return $this->pagination;
		}

		return Timber::compile(
			$this->twigPath . '/pagination.twig',
			array(
				'pagination' => $postList->pagination(),
			)
		);
	}

	protected function defaultTeaserBuilder( $post_item ) {
		if ( $post_item->thumbnail ) {
			$thumbnail = nc_blocks_image( $post_item->thumbnail->ID, 'teaser_new' );
		} else {
			$thumbnail = new TimberImage( $this->fallbackImage );
			$thumbnail = "<img src='" . $thumbnail->src() . "' alt='' />";
		}

		$preview = '';

		if ( function_exists( 'get_field' ) ) {
			$preview = get_field( 'summary', $post_item->id() );
		}

		$preview = $preview ? $preview : $post_item->preview()->read_more( false );

		$primaryCategory = false;
		if ( function_exists( 'yoast_get_primary_term' ) ) {
			$primaryCategoryID = yoast_get_primary_term_id( 'category', $post_item->ID );
			if ( $primaryCategoryID ) {
				$primaryCategory = get_term( $primaryCategoryID );
				$primaryCategory = array(
					'title' => $primaryCategory->name,
					'url'   => get_term_link( $primaryCategoryID, 'category' ),
				);
			}
		}

		$post_preview = array(
			'title'            => $post_item->title(),
			'id'               => $post_item->id(),
			'link'             => $post_item->link(),
			'post_type'        => $post_item->post_type(),
			'description'      => $preview,
			'primary_category' => $primaryCategory,
			'thumbnail'        => $thumbnail,
		);

		return $post_preview;
	}

	protected function paginatedPostList( $args = array() ) {
		if ( ! isset( $this->paginatedPostList ) ) {
			$args = wp_parse_args(
				$args,
				array(
					'query'  => null,
					'render' => true,
				)
			);

			// Build pagination if not using the default query
			if ( $args['query'] ) {
				global $paged;
				if ( ! isset( $paged ) || ! $paged ) {
					$paged = 1;
				}

				$args['query']['paged'] = $paged;
				$timber_posts           = new TimberPostQuery( $args['query'] );
			} else {
				$timber_posts = new TimberPostQuery();
			}

			$post_previews = array();

			foreach ( $timber_posts->get_posts() as $post_item ) {
				if ( ! empty( $args['transformer_function'] ) && function_exists( $args['transformer_function'] ) ) {
					$transformer_args = ! empty( $args['transformer_args'] ) ? $args['transformer_args'] : array();
					$post_previews[]  = $args['transformer_function']( $post_item, $transformer_args );
				} else {
					$post_previews[] = $this->defaultTeaserBuilder( $post_item );
				}
			}

			$pagination_args = array();

			if ( $args['query'] && array_key_exists( 'raw_offset', $args['query'] ) ) {
				$pagination_args['total'] = ceil( ( $timber_posts->found_posts - $args['query']['raw_offset'] ) / $args['query']['posts_per_page'] );
			}

			$pagination = $timber_posts->pagination( $pagination_args );

			$paginatedPostListArgs = array(
				'posts'            => $post_previews,
				'pagination'       => $pagination,
				'pagination_links' => $this->pagination( $timber_posts ),
				'fallback_image'   => $this->fallbackImage,
				'first_page'       => $pagination->current === 1,
				'postListClasses'  => ! empty( $args['postListClasses'] ) ? $args['postListClasses'] : '',
				'itemClasses'      => ! empty( $args['itemClasses'] ) ? $args['itemClasses'] : '',
			);

			if ( ! $args['render'] ) {
				return $paginatedPostListArgs;
			}

			$this->paginatedPostList = Timber::compile( $this->twigPath . '/post-list.twig', $paginatedPostListArgs );
		}

		return $this->paginatedPostList;
	}

	protected function siteFooter( $args ) {
		$args = wp_parse_args( $args, $this->context );

		if ( is_active_sidebar( 'footer_widgets' ) ) :
			ob_start();
			dynamic_sidebar( 'footer_widgets' );
			$socialLinks = ob_get_clean();
		else :
			$socialLinks = '';
		endif;

		$args['socialLinks'] = $socialLinks;

		$args['footerLogo'] = get_key( $args, 'footerLogo', $this->context['headerLogo'] );

		return Timber::compile( $this->twigPath . '/site-footer.twig', $args );
	}

	protected function siteSearch( $args = array() ) {
		$searchTwig = $this->twigPath . '/site-search.twig';

		return Timber::compile( $searchTwig, $args );
	}

	protected function siteHeader( $args ) {
		$component = new Component();

		$args = wp_parse_args( $args, $this->context );

		$menuPrimary     = new \Timber\Menu( 'menu-primary' );
		$additionalLinks = new \Timber\Menu( 'menu-secondary' );

		$realSiteHeader  = Timber::compile(
			$this->twigPath . '/site-header-markup.twig',
			array(
				'isRealHeader' => true,
			)
		);
		$modalSiteHeader = Timber::compile(
			$this->twigPath . '/site-header-markup.twig',
			array(
				'isRealHeader' => false,
			)
		);

		if ( is_active_sidebar( 'main_menu_widgets' ) ) :
			ob_start();
			dynamic_sidebar( 'main_menu_widgets' );
			$emailSignupForm = ob_get_clean();
		else :
			$emailSignupForm = '';
		endif;

		$modalContent = Timber::compile(
			$this->twigPath . '/main-menu-content.twig',
			array(
				'featuredTopicLinks' => $menuPrimary->items,
				'additionalLinks'    => $additionalLinks->items,
				'emailSignupForm'    => $emailSignupForm,
			)
		);

		$menuModal = Timber::compile(
			$this->twigPath . '/modal.twig',
			array(
				'modalId'         => 'main-menu',
				'modalLabel'      => 'Main Menu',
				'closeButtonId'   => 'close-menu',
				'modalContent'    => $modalContent,
				'modalSiteHeader' => $modalSiteHeader,
				'modalSiteFooter' => $this->build( 'siteFooter', array() ),
			)
		);

		$searchModalContent = $this->siteSearch();

		$searchModal = Timber::compile(
			$this->twigPath . '/modal.twig',
			array(
				'modalId'         => 'site-search',
				'modalLabel'      => 'Site Search',
				'closeButtonId'   => 'close-search',
				'modalContent'    => $searchModalContent,
				'modalSiteHeader' => $modalSiteHeader,
				'modalSiteFooter' => $this->build( 'siteFooter', array() ),
			)
		);

		$headerLogoID = get_theme_mod( 'custom_logo' );
		if ( $headerLogoID ) {
			$args['headerLogo'] = wp_get_attachment_image( $headerLogoID, 'full' );
		} else {
			$args['headerLogo'] = '<img src="' . get_stylesheet_directory_uri() . '/assets/images/logo_colby.svg' . '" alt="Colby College News" />';
		}

		$args['homeLink'] = array(
			'title' => 'Back to ' . get_bloginfo( 'name' ) . ' Home',
			'url'   => get_home_url(),
		);

		$searchIcons = array(
			'off' => $component->build(
				'icon',
				array(
					'icon' => 'interface-search',
					'size' => 5,
				)
			),
			'on'  => $component->build(
				'icon',
				array(
					'icon' => 'interface-times',
					'size' => 5,
				)
			),
		);

		$args['searchField'] = array(
			'url'  => '/',
			'name' => 'q',
		);

		$globalAlert = false;

		$show_global_alert = function_exists( 'get_field' ) ? get_field( 'show_global_alert', 'option' ) : '';
		$show_icon         = function_exists( 'get_field' ) ? get_field( 'show_icon', 'option' ) : '';

		if ( $show_global_alert ) {
			$globalAlert          = array();
			$globalalert['alert'] = function_exists( 'get_field' ) ? get_field( 'alert', 'option' ) : '';

			$iconLocation = get_template_directory_uri() . '/assets/icons/icon-sprites.svg#interface-exclamation-triangle';
			$icon         = false;

			if ( $show_icon ) {
				$icon = "<svg class='w-8 h-8 transition-transform transform fill-current group-hover:scale-110'>
                <use xlink:href='$iconLocation'></use>
                </svg>";
			}

			$globalalert['icon'] = $icon;

			$globalAlert = Timber::compile( $this->twigPath . '/global-alert.twig', $globalalert );
		}

		return Timber::compile(
			$this->twigPath . '/site-header.twig',
			array(
				'realSiteHeader' => $realSiteHeader,
				'globalAlert'    => $globalAlert,
				'menuModal'      => $menuModal,
				'searchModal'    => $searchModal,
			)
		);
	}

	protected function storyHeader( $args = array() ) {
		$post = get_key( $args, 'post' );
		$post = $post ? $post : $this->context['post'];

		$defaultArgs = array(
			'orientation'      => 'landscape',
			'shareButtonsLast' => false,
			'author'           => $post->author,
			'postedDate'       => $post->date,
		);

		$imageSize = 'landscape_full_lg';

		$defaultArgs['updatedDate'] = false;
		if ( get_the_modified_date( $post->ID ) > get_the_date( $post->ID ) ) {
			$defaultArgs['updatedDate'] = get_the_modified_date( $post->ID );
		}

		if ( function_exists( 'yoast_get_primary_term' ) ) {
			$primaryCategoryID = yoast_get_primary_term_id( 'category', $post->ID );
			if ( $primaryCategoryID && ! is_wp_error( $primaryCategoryID ) ) {
				$primaryCategory                = get_term( $primaryCategoryID );
				$defaultArgs['primaryCategory'] = array(
					'title' => $primaryCategory->name,
					'url'   => get_term_link( $primaryCategoryID, 'category' ),
				);
			}
		}

		$all_fields  = get_fields( $post->ID );
		$is_revision = wp_is_post_revision( $post );

		if ( function_exists( 'get_field' ) ) {
			$defaultArgs['lengthOfRead'] = get_post_meta( $post->ID, '_yoast_wpseo_estimated-reading-time-minutes' )[0] . strtoupper( ' min read' );
			$defaultArgs['summary']      = get_post_field( 'summary', $post->ID );
			$defaultArgs['author']       = get_post_field( 'author', $post->ID );
			$defaultArgs['photoCredit']  = get_post_field( 'photoCredit', $post->ID );
			$defaultArgs['contact']      = array(
				'name'  => get_post_field( 'contact_name', $post->ID ),
				'email' => get_post_field( 'contact_email', $post->ID ),
				'phone' => get_post_field( 'contact_phone', $post->ID ),
			);
		}

		$defaultArgs['title'] = get_the_title( $post->ID );

		$video = false;
		if ( get_post_format( $post->ID ) === 'video' ) {
			$video = get_field( 'featured_video' );
		}

		$figure_responsive = false;

		if ( $video ) {
			$orientation          = 'landscape';
			$featuredImage        = $video;
			$featuredImageCaption = '';
			$figure_responsive    = true;
		} else {
			$orientation           = get_post_field( 'vertical_header', $post->ID ) ? 'portrait' : 'landscape';
			$verticalFeaturedImage = get_post_field( 'vertical_image', $post->ID );
			if ( $orientation === 'portrait' && $verticalFeaturedImage ) {
				$imageSize = 'header_vertical_lg';
				// $featuredImage        = nc_blocks_image( $verticalFeaturedImage, $imageSize );
				$featuredImage        = wp_parse_url( wp_get_attachment_image_url( $verticalFeaturedImage, 'original' ) );
				$featuredImageCaption = wp_get_attachment_caption( $verticalFeaturedImage );
			} else {
				$featuredImage        = wp_parse_url( get_the_post_thumbnail_url( $post->ID, 'original' ) );
				$featuredImageCaption = get_the_post_thumbnail_caption( $post->ID );

			}
		}

		if ( is_front_page() ) {
			$featuredImageCaption = false;
		}

		$figure = '<figure>';
		if ( $figure_responsive ) {
			$figure .= '<div class="responsive-embed">';
		}
		if ( $video ) {
			$figure .= $featuredImage;
		} else {
			$figure .= <<<EOD
            <img
                loading="lazy"
                decoding="async"
                srcset="
                    https://news.colby.edu/cdn-cgi/image/width=1090,quality=60/https://news.colby.edu{$featuredImage['path']} 1090w, 
                    https://news.colby.edu/cdn-cgi/image/width=300,quality=60/https://news.colby.edu{$featuredImage['path']} 300w, 
                    https://news.colby.edu/cdn-cgi/image/width=1024,quality=60/https://news.colby.edu{$featuredImage['path']} 1024w,
                    https://news.colby.edu/cdn-cgi/image/width=600,quality=60/https://news.colby.edu{$featuredImage['path']} 600w,
                    https://news.colby.edu/cdn-cgi/image/width=1536,quality=60/https://news.colby.edu{$featuredImage['path']} 1536w,
                    https://news.colby.edu/cdn-cgi/image/width=100,quality=60/https://news.colby.edu{$featuredImage['path']} 100w,
                    https://news.colby.edu/cdn-cgi/image/width=540,quality=60/https://news.colby.edu{$featuredImage['path']} 540w,
                    https://news.colby.edu/cdn-cgi/image/width=1080,quality=60/https://news.colby.edu{$featuredImage['path']} 1080w,
                    https://news.colby.edu/cdn-cgi/image/width=800,quality=60/https://news.colby.edu{$featuredImage['path']} 800w,
                    https://news.colby.edu/cdn-cgi/image/width=640,quality=60/https://news.colby.edu{$featuredImage['path']} 640w,
                    https://news.colby.edu/cdn-cgi/image/width=320,quality=60/https://news.colby.edu{$featuredImage['path']} 320w,
                    https://news.colby.edu/cdn-cgi/image/width=400,quality=60/https://news.colby.edu{$featuredImage['path']} 400w,
                    https://news.colby.edu/cdn-cgi/image/width=1600,quality=60/https://news.colby.edu{$featuredImage['path']} 1600w
                "
                src="https://news.colby.edu/cdn-cgi/image/width=1090,quality=60/https://news.colby.edu{$featuredImage['path']}"
                sizes="(max-width: 1090px) 100vw, 1090px"
                alt=""
            />
        EOD;
		}
		if ( $figure_responsive ) {
			$figure .= '</div>';
		}
		if ( $featuredImageCaption ) {
			$figure .= "<figcaption class='text-sm'>$featuredImageCaption</figcaption>";
		}

		$figure .= '</figure>';

		$defaultArgs['figure']       = $figure;
		$defaultArgs['orientation']  = $orientation;
		$defaultArgs['shareButtons'] = Timber::compile( $this->twigPath . '/social-sharing.twig' );

		$headerArgs = wp_parse_args( $args, $defaultArgs );

		return Timber::compile( $this->twigPath . '/story-header.twig', $headerArgs );
	}
}
