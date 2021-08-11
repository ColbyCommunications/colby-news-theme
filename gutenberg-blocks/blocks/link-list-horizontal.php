<?php

/** Functions required to build a Horizontal Link List
 * Separate from the `link-list-horizontal-block.php` file so it can be used
 * by other blocks as well.
 */

namespace NC_Blocks;

require_once(get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');
require_once(get_template_directory() . '/gutenberg-blocks/components/block-components.php');

function linkListHorizontal(array $args = array())
{

    $component = new Component();

    $links = get_key($args, 'links');
    if (! is_array($links)) {
        $links = [];
    }

    $links = array_map(function ($link) {
        if (get_key($link, 'link_external')) {
            return $link['link_external'];
        }
        if (get_key($link, 'link_url')) {
            return $link['link_url'];
        }
        if (get_key($link, 'link')) {
            return $link['link'];
        }
        return $link;
    }, $links);

    $items = array_map(function ($link) {
        $title = get_key($link, 'title', '');
        $url = get_key($link, 'url', '');

        $linkElement = [
            'title' => "
                <a class='border-0 group' href='$url'>
                    <span className='transition-colors no-underline group-hover:underline'>
                    $title
                    </span>
                </a>"
        ];

        $external = get_key($link, 'target', false);
        if ($external) {
            $linkElement['icon'] = 'interface-external';
        } else {
            $linkElement['icon'] = 'interface-angle-right-narrow';
        }

        return $linkElement;
    }, $links);

    $listArgs = wp_parse_args([
        'items' => $items,
        'className' => 'icon-sm flex flex-wrap gap-8 font-display text-lg ' . get_key($args, 'className', ''),
    ], $args);

    $listArgs = wp_parse_args($listArgs, [
        'itemClasses' => 'mb-2',
        'iconSize' => 16,
        'iconClasses' => 'text-link',
        'arrowList' => true,
    ]);

    return $component->build('iconList', $listArgs);

}