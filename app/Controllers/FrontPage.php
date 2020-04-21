<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
//     public function featuredStory() {
//         /*
// 'tax_query' => array(
//                 'relation' => 'AND',
//                 array(
//                     'taxonomy' => 'category',
//                     'field' => 'slug',
//                     'terms' => array('in-the-news')
//                 ), 
//             ),
//             'meta_query'	=> array(
//                 'relation'		=> 'AND',
//                 array(
//                     'key'	  	=> 'featured_story',
//                     'value'	  	=> '1',
//                     'compare' 	=> '=',
//                 ),
//             ),
//         */
//         $args = [
//             'post_type' => 'post',
//             'posts_per_page'=> 1,
//             'order' => 'DESC',
//             'orderby' => 'ID',
//             'category' => 4,
//             'meta_key'     => 'featured_story',
//             'meta_value'   => 1,
//             'meta_compare' => '=',
//             ];

//         $query = new \WP_Query($args);

//         wp_die(var_dump($query->posts));
//         return $query;
//     }
}
