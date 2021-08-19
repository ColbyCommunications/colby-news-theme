<?php

namespace NC_Blocks;

require_once(get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');
require_once(get_template_directory() . '/gutenberg-blocks/components/block-components.php');

use Timber\Timber;

class TemplatePart
{
    protected $components;
    protected $context;
    protected $twigPath;

    public function __construct($context = null)
    {
        $this->context = $context ?? Timber::get_context();
        $this->twigPath = get_template_directory() . '/views/template-parts';
        $this->components = array(
            'siteHeader' => 'siteHeader',
            'siteFooter' => 'siteFooter',
            'storyHeader' => 'storyHeader',
        );
    }

    public function build($component_name, $args = [], $print = false)
    {
        if (!isset($this->components[$component_name])) {
            do_action('qm/warn', "No definition for component '$component_name'");
            return '';
        }

        if (! is_callable([$this, $this->components[$component_name]])) {
            do_action('qm/warn', "$component_name is not a callable method.");
            return '';
        }

        $output = call_user_func([$this, $this->components[$component_name]], $args);

        if ($print) {
            echo $output;
        }

        return $output;
    }

    protected function siteFooter($args)
    {
        $args = wp_parse_args($args, $this->context);

        if (is_active_sidebar('footer_widgets')) :
            ob_start();
            dynamic_sidebar('footer_widgets');
            $socialLinks = ob_get_contents();
            ob_end_clean();
        else :
            $socialLinks = '';
        endif;

        $args['socialLinks'] = $socialLinks;

        $args['footerLogo'] = get_key($args, 'footerLogo', $this->context['headerLogo']);

        return Timber::compile($this->twigPath . '/site-footer.twig', $args);
    }

    protected function siteHeader($args)
    {
        $component = new Component();

        $args = wp_parse_args($args, $this->context);

        $menuPrimary = new \Timber\Menu('menu-primary');
        $additionalLinks = new \Timber\Menu('menu-secondary');

        $realSiteHeader = Timber::compile($this->twigPath . '/site-header-markup.twig', [
            'isRealHeader' => true,
        ]);
        $modalSiteHeader = Timber::compile($this->twigPath . '/site-header-markup.twig', [
            'isRealHeader' => false,
        ]);

        if (is_active_sidebar('main_menu_widgets')) :
            ob_start();
            dynamic_sidebar('main_menu_widgets');
            $emailSignupForm = ob_get_clean();  //or ob_get_clean();
            ob_end_clean();
        else :
            $emailSignupForm = '';
        endif;

        $modalContent = Timber::compile($this->twigPath . '/main-menu-content.twig', [
            'featuredTopicLinks' => $menuPrimary->items,
            'additionalLinks' => $additionalLinks->items,
            'emailSignupForm' => $emailSignupForm,
        ]);

        $menuModal = Timber::compile($this->twigPath . '/modal.twig', [
            'modalId' => 'main-menu',
            'modalLabel' => 'Main Menu',
            'closeButtonId' => 'close-menu',
            'modalContent' => $modalContent,
            'modalSiteHeader' => $modalSiteHeader,
            'modalSiteFooter' => $this->build('siteFooter', []),
        ]);

        $searchModalContent = '';

        $searchModal = Timber::compile($this->twigPath . '/modal.twig', [
            'modalId' => 'site-search',
            'modalLabel' => 'Site Search',
            'closeButtonId' => 'close-search',
            'modalContent' => $searchModalContent,
            'modalSiteHeader' => $modalSiteHeader,
            'modalSiteFooter' => $this->build('siteFooter', []),
        ]);

        $headerLogoID = get_theme_mod('custom_logo');
        if ($headerLogoID) {
            $args['headerLogo'] = wp_get_attachment_image($headerLogoID, 'full');
        } else {
            $args['headerLogo'] = '<img src="' . get_stylesheet_directory_uri() . '/assets/images/logo_colby.svg' . '" alt="Colby College News" />';
        }

        $args['homeLink'] = [
            'title' => 'Back to ' . get_bloginfo('name') . ' Home',
            'url' => get_home_url(),
        ];

        $searchIcons = [
            'off' => $component->build('icon', [
                'icon' => 'interface-search',
                'size' => 5,
            ]),
            'on' => $component->build('icon', [
                'icon' => 'interface-times',
                'size' => 5,
            ]),
        ];

        $args['searchField'] = [
            'url' => '/',
            'name' => 'q',
        ];

        $globalAlert = false;

        $show_globalalert = function_exists('get_field') ? get_field('show_globalalert', 'option') : '';
        if ($show_globalalert) {
            $globalalert = function_exists('get_field') ? get_field('alert', 'option') : '';

            $iconLocation = get_template_directory_uri() . '/assets/icons/icon-sprites.svg#interface-exclamation-triangle';
            $icon = "<svg class='w-8 h-8 transition-transform transform fill-current group-hover:scale-110'>
            <use xlink:href='$iconLocation'></use>
            </svg>";

            $globalalert['icon'] = $icon;

            $globalAlert = Timber::compile($this->twigPath . '/global-alert.twig', $globalalert);
        }

        return Timber::compile($this->twigPath . '/site-header.twig', [
            'realSiteHeader' => $realSiteHeader,
            'globalAlert' => $globalAlert,
            'menuModal' => $menuModal,
            'searchModal' => $searchModal,
        ]);
    }

    protected function storyHeader($args = [])
    {
        $post = get_key($args, 'post');
        $post = $post ? $post : $this->context['post'];

        $defaultArgs = [
            'orientation' => 'portrait',
            'shareButtonsLast' => false,
            'author' => $post->author,
            'postedDate' => $post->date,
        ];

        $imageSize = 'landscape_full_lg';

        $defaultArgs['updatedDate'] = false;
        if (get_the_modified_date($post->ID) > get_the_date($post->ID)) {
            $defaultArgs['updatedDate']  = get_the_modified_date($post->ID);
        }

        if (function_exists('yoast_get_primary_term')) {
            $defaultArgs['primaryCategory'] = yoast_get_primary_term('category', $post->ID);
        }

        if (function_exists('get_field')) {
            $defaultArgs['lengthOfRead'] = get_field('lengthOfRead', $post->ID);
            $defaultArgs['summary'] = get_field('summary', $post->ID);
            $defaultArgs['author'] = get_field('author', $post->ID);
            $defaultArgs['photoCredit'] = get_field('photoCredit', $post->ID);
            $defaultArgs['contact'] = get_field('contact', $post->ID);
        }

        $defaultArgs['title'] = get_the_title($post->ID);

        $video = false;
        if (get_post_format($post->ID) === 'video') {
            $video = get_field('featured_video');
        }

        if ($video) {
            $orientation = 'landscape';
            $featuredImage = $video;
            $featuredImageCaption = '';
        } else {
            $orientation = get_field('vertical_header', $post->ID) ? 'portrait' : 'landscape';
            if ($orientation === 'portrait') {
                $imageSize = 'header_vertical_lg';
                $verticalFeaturedImage = get_field('vertical_image', $post->ID);
                $featuredImage = nc_blocks_image($verticalFeaturedImage, $imageSize);
                $featuredImageCaption = wp_get_attachment_caption($verticalFeaturedImage);
            } else {
                $featuredImage = get_the_post_thumbnail($post->ID, $imageSize);
                $featuredImageCaption = get_the_post_thumbnail_caption($post->ID);
            }
        }


        $figure = '<figure>';
        $figure .= $featuredImage;

        if ($featuredImageCaption) {
            $figure .= "<figcaption class='text-sm'>$featuredImageCaption</figcaption>";
        }

        $figure .= '</figure>';

        $defaultArgs['figure'] = $figure;
        $defaultArgs['orientation'] = $orientation;

        $headerArgs = wp_parse_args($args, $defaultArgs);

        return Timber::compile($this->twigPath . '/story-header.twig', $headerArgs);
    }
}
