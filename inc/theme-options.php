<?php

/**
 * WP-Admin Setup
 *
 * Set up a WP-Admin page for managing turning on and off theme features.
 *
 * @package colby-news-theme
 */

/**
 * Disable some default customizer options
 */
// function newcity_colby_news_remove_settings($wp_customize)
// {
//     $wp_customize->remove_section("colors");
//     $wp_customize->remove_section("background_image");
// }
// add_action("customize_register", "newcity_colby_news_remove_settings");

/** Load script to remove block settings */

function remove_block_style()
{
    wp_enqueue_script(
        'remove-block-styles',
        get_stylesheet_directory_uri() . '/js/remove-block-styles.js',
        [ 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ],
        filemtime(get_stylesheet_directory() . '/js/remove-block-styles.js'),
        true
    );
}
add_action('enqueue_block_editor_assets', 'remove_block_style');

/**
 * Add custom header controls to customizer
 */
function newcity_colby_news_header_settings($wp_customize)
{

    // Footer section and options
    $wp_customize->add_section(
        'newcity_colby_news_footer_options',
        array(
        'title'         => __('Footer Settings', 'colby-news-theme'),
        'priority'      => 160,
        )
    );

    newcity_add_customizer_controls(
        'newcity_colby_news_footer_options',
        [
            [
                'name' => 'newcity_colby_news_office_title',
                'label'       => 'Office Location Title',
                'description' => 'Header for the office location in the footer',
                'default' => 'Colby News',
            ],
            [
                'name' => 'newcity_colby_news_office_address',
                'label' => 'Office Location Address',
                'description' => 'Address for the office location in the footer',
                'default' => '2635 Colby News Rd', 'colby-news-theme',
            ],
            [
                'name' => 'newcity_colby_news_office_address_2',
                'label' => 'Office Location Address (line 2)',
                'default' => 'Mouth of Wilson, VA 24363', 'colby-news-theme',
            ],
            [
                'name' => 'newcity_colby_news_phone',
                'label' => 'Phone',
                'description' => 'Main phone number for the school',
                'default' => '',
            ],
            [
                'name' => 'newcity_colby_news_email',
                'label' => 'Email Address',
                'description' => 'Main email address for the school',
                'default' => '',
            ],
            [
                'name' => 'newcity_colby_news_maps_link',
                'label' => 'Maps & Directions Link',
                'description' => 'URL for the "Maps & Directions" link',
                'default' => '',
            ],
            [
                'name' => 'newcity_colby_news_copyright_text',
                'label' => 'Copyright Notice Text',
                'description' => 'Set the copyright text for the footer. Insert the current year using <code>%year%</code>',
                'default' => '©%year% Colby News. All rights reserved',
            ],
        ],
        $wp_customize,
    );

    $wp_customize->add_setting(
        'newcity_colby_news_footer_logo',
        array(
            'default' => false,
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        (new WP_Customize_Media_Control($wp_customize, 'newcity_colby_news_footer_logo', array(
            'label' => __('Footer Logo Image', 'colby-news-theme'),
            'section' => 'newcity_colby_news_footer_options',
            'mime_type' => 'image',
          )))
    );

    $wp_customize->add_setting(
        'newcity_colby_news_footer_bg',
        array(
            'default' => false,
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        (new WP_Customize_Media_Control($wp_customize, 'newcity_colby_news_footer_bg', array(
            'label' => __('Footer Background Image', 'colby-news-theme'),
            'section' => 'newcity_colby_news_footer_options',
            'mime_type' => 'image',
          )))
    );
}
add_action("customize_register", "newcity_colby_news_header_settings");


/**
 * Add options page.
 */
function newcity_colby_news_add_options_page()
{
    add_theme_page(
        'Theme Options',
        'Theme Options',
        'manage_options',
        'colby-news-theme-options',
        'newcity_colby_news_options_page'
    );

    // Call register settings function.
    add_action('admin_init', 'newcity_colby_news_options');
}
// add_action('admin_menu', 'newcity_colby_news_add_options_page');


/**
 * Register settings for the WP-Admin page.
 */
// function newcity_colby_news_options()
// {
//     register_setting(
//         'colby-news-theme-options',
//         'colby-news-theme-align-wide',
//         array( 'default' => 1 )
//     );
//     register_setting(
//         'colby-news-theme-options',
//         'colby-news-theme-wp-block-styles',
//         array( 'default' => 1 )
//     );
//     register_setting(
//         'colby-news-theme-options',
//         'colby-news-theme-editor-color-palette',
//         array( 'default' => 1 )
//     );
//     register_setting(
//         'colby-news-theme-options',
//         'colby-news-theme-dark-mode'
//     );
//     register_setting(
//         'colby-news-theme-options',
//         'colby-news-theme-responsive-embeds',
//         array( 'default' => 1 )
//     );
// }

// /** Add options page for global alert banner */
// function newcity_add_global_alert_options()
// {

//     // Check function exists.
//     if (function_exists('acf_add_options_page')) {
//         // Register options page.
//         $option_page = acf_add_options_page(array(
//             'page_title'    => __('Global Alert Settings'),
//             'menu_title'    => __('Global Alert'),
//             'menu_slug'     => 'global-alert',
//             'capability'    => 'edit_posts',
//             'redirect'      => false
//         ));
//     }
// }
// add_action('acf/init', 'newcity_add_global_alert_options');

// /**
//  * Build the WP-Admin settings page.
//  */
// function newcity_colby_news_options_page()
// {
// }


// /**
//  * Enable alignwide and alignfull support if the colby-news-theme-align-wide setting is active.
//  */
// function newcity_colby_news_enable_align_wide()
// {
//     // if (get_option('colby-news-theme-align-wide', 1) === 1) {
//         // Add support for full and wide align images.
//         add_theme_support('align-wide');
//     // }
// }
// add_action('after_setup_theme', 'newcity_colby_news_enable_align_wide');


// /**
//  * Enable custom theme colors if the colby-news-theme-editor-color-palette setting is active.
//  */
// function newcity_colby_news_enable_editor_color_palette()
// {
//     if (get_option('colby-news-theme-editor-color-palette', 1) === 1) {
//         // Add support for a custom color scheme.
//         add_theme_support(
//             'editor-color-palette',
//             array(
//                 array(
//                     'name'  => __('Strong Blue', 'colby-news-theme'),
//                     'slug'  => 'strong-blue',
//                     'color' => '#0073aa',
//                 ),
//                 array(
//                     'name'  => __('Lighter Blue', 'colby-news-theme'),
//                     'slug'  => 'lighter-blue',
//                     'color' => '#229fd8',
//                 ),
//                 array(
//                     'name'  => __('Very Light Gray', 'colby-news-theme'),
//                     'slug'  => 'very-light-gray',
//                     'color' => '#eee',
//                 ),
//                 array(
//                     'name'  => __('Very Dark Gray', 'colby-news-theme'),
//                     'slug'  => 'very-dark-gray',
//                     'color' => '#444',
//                 ),
//             )
//         );
//     }
// }
// add_action('after_setup_theme', 'newcity_colby_news_enable_editor_color_palette');


// /**
//  * Enable dark mode if colby-news-theme-dark-mode setting is active.
//  */
// function newcity_colby_news_enable_dark_mode()
// {
//     if (get_option('colby-news-theme-dark-mode') === 1) {
//         // Add support for editor styles.
//         add_theme_support('editor-styles');
//         add_editor_style('style-editor-dark.css');

//         // Add support for dark styles.
//         add_theme_support('dark-editor-style');
//     }
// }
// add_action('after_setup_theme', 'newcity_colby_news_enable_dark_mode');


// /**
//  * Enable dark mode on the front end if colby-news-theme-dark-mode setting is active.
//  */
// function newcity_colby_news_enable_dark_mode_frontend_styles()
// {
//     if (get_option('colby-news-theme-dark-mode') === 1) {
//         wp_enqueue_style(
//             'colby-news-themedark-style',
//             get_template_directory_uri() . '/css/dark-mode.css',
//             null,
//             filemtime(get_template_directory() . '/css/dark-mode.css')
//         );
//     }
// }
// add_action('wp_enqueue_scripts', 'newcity_colby_news_enable_dark_mode_frontend_styles');

// /**
//  * Enable core block styles support if the colby-news-theme-wp-block-styles setting is active.
//  */
// function newcity_colby_news_enable_wp_block_styles()
// {
//     if (get_option('colby-news-theme-wp-block-styles', 1) === 1) {
//         // Adding support for core block visual styles.
//         add_theme_support('wp-block-styles');
//     }
// }
// // add_action('after_setup_theme', 'newcity_colby_news_enable_wp_block_styles');


// /**
//  * Enable responsive embedded content if the colby-news-theme-responsive-embeds setting is active.
//  */
// function newcity_colby_news_enable_responsive_embeds()
// {
//     if (get_option('colby-news-theme-responsive-embeds', 1) === 1) {
//         // Adding support for responsive embedded content.
//         add_theme_support('responsive-embeds');
//     }
// }
// add_action('after_setup_theme', 'newcity_colby_news_enable_responsive_embeds');
