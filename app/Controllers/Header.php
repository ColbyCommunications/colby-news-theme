<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Header extends Controller
{
    public static function getBrand()
    {
        // die();
        $output = get_bloginfo( 'name' );

        if ( has_custom_logo() ) {

        // get the url for the image
        $logo_url = wp_get_attachment_url(get_theme_mod( 'custom_logo' ));

        // wrap in image tag, save as string
        $logo   = '<img height=50 src="' . $logo_url . '">';

        // optional, hide the site name, screen reader friendly
        $output = '<span class="sr-only">' . get_bloginfo( 'name' ) . '</span>';

        // stick them together
        $output .= $logo;

        }

        return $output;
    }

}
