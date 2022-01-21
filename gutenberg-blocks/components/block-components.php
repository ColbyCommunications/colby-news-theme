<?php

namespace NC_Blocks;

use DOMDocument;
use SimpleXMLElement;
use Timber\Timber;
use Timber\Image as TimberImage;
use Timber\ImageHelper as TimberImageHelper;

require_once(\get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');

class Component
{
    protected $components;

    public function __construct()
    {
        $this->components = array(
            'backgroundDots' => 'backgroundDots',
            'backgroundImage' => 'backgroundImage',
            'contentSection' => 'contentSection',
            'billboard' => 'billboard',
            'boxGrid' => 'boxGrid',
            'breadcrumbs' => 'breadcrumbs',
            'buttonGroup' => 'buttonGroup',
            'carousel' => 'carousel',
            'eventDate' => 'eventDate',
            'fancyLink' => 'fancyLink',
            'mediaRow' => 'mediaRow',
            'figure' => 'figure',
            'icon' => 'icon',
            'iconFlag' => 'iconFlag',
            'iconList' => 'iconList',
            'linkList' => 'linkList',
            'linkGroup' => 'linkGroup',
            'mosaicFeatureBlock' => 'mosaicFeatureBlock',
            'pageSection' => 'pageSection',
            'quotation' => 'quotation',
            'routingCard' => 'routingCard',
            'sectionNav' => 'sectionNav',
            'teaserText' => 'teaserText',
            'videoPreview' => 'videoPreview',
        );
    }

    public function build($component_name, $args, $print = false)
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

        if (!$print) {
            return $output;
        }

        echo $output;
    }

    protected function backgroundDots($args = [])
    {
        $imagePath = get_template_directory_uri() . '/assets/images/dotted_line.svg';

        $zIndex = isset($args['zIndex']) ? $args['zIndex'] : 10;
        return "
            <img src='$imagePath' 
            class='absolute z-$zIndex inset-0 w-full h-full max-w-none max-h-none object-center object-cover' / >
        ";
    }

    protected function backgroundImage($args)
    {
        $default_classes = [
            'background-image',
            'absolute',
            'inset-0',
            'z-0',
            'w-full', 'h-full',
            'inset-0',
        ];

        $classes = isset($args['classes']) ? $args['classes'] : [];
        if (is_string($classes)) {
            $classes = explode(' ', $classes);
        }
        if (isset($args['overlay']) && $args['overlay']) {
            $classes[] = $args['overlay'];
            $classes[] = 'has-overlay';
        }

        $image_classes = [
            'w-full',
            'h-full',
        ];
        $image_classes[] = isset($args['align']) && $args['align'] ? $args['align'] : 'object-top';
        $image_classes[] = isset($args['fit']) && $args['fit'] ? $args['fit'] : 'object-cover';

        $classes = implode(' ', array_unique(array_merge($default_classes, $classes)));
        $image_classes = implode(' ', $image_classes);

        $bg_image = "<div class='$classes'>";
        $bg_image .= nc_blocks_image($args['image'], 'widescreen', '', [
            'class' => $image_classes,
            'alt' => '',
        ]);
        $bg_image .= '</div>';

        return $bg_image;
    }

    protected function billboard($args)
    {
        $component = new Component();

        $alignments = [
            'left' => 'text-left',
            'center' => 'text-center'
        ];


        $wrapperClasses = isset($args['wrapperClasses']) && is_array($args['wrapperClasses']) ? $args['wrapperClasses'] : [get_key($args, 'wrapperClasses', '')];

        if (! array_key_exists('align', $args)) {
            $args['align'] = '';
        }


        $args['align'] = array_key_exists($args['align'], $alignments) ? $alignments[$args['align']] : '';
        $args['headingElement'] = isset($args['headingElement']) ? $args['headingElement'] : 'h2';
        $args['headingFont'] = get_key($args, 'headingFont', '') ? $args['headingFont'] : 'font-display';
        $args['headingColor'] = get_key($args, 'headingColor', '') ? $args['headingColor'] : 'text-heading';
        $args['headingFontSize'] = get_key($args, 'headingFontSize', '') ? $args['headingFontSize'] : 'leading-none sm:leading-none md:leading-none text-3xl sm:text-4xl md:text-5xl';



        // $wrapperClasses[] = 'px-container';

        $args['className'] = implode_classes($wrapperClasses);

        $has_links = isset($args['links']) && is_array($args['links']) && count($args['links']) > 0;
        $has_button = !empty($args['button']) && (!empty($args['button']['title']));

        if ($has_links) {
            $links = array_map(function ($link) {
                return $link['link'];
            }, $args['links']);
        } else {
            $links = false;
        }

        if ($has_links || $has_button) {
            $args['linkGroup'] = $component->build('linkGroup', [
                'links' => $links,
                'button' => $args['button'],
                'align' => $args['align'],
                'groupClasses' => $args['align'] === 'text-center' ? 'justify-center' : '',
                'buttonClasses' => 'text-center'
            ]);
        } else {
            $args['linkGroup'] = '';
        }

        $args['hrSpacing'] = [
            'top' => 'mb-5',
        ];

        if ($args['body'] || $args['linkGroup']) {
            $args['hrSpacing']['bottom'] = 'mb-5';
        }

        return Timber::compile(get_blocks_twig_directory('/billboard-text.twig'), $args);
    }

    protected function boxGrid($args)
    {
        return Timber::compile(get_blocks_twig_directory('/box-grid.twig'), $args);
    }

    protected function breadcrumbs($args)
    {
        return Timber::compile(get_blocks_twig_directory('/breadcrumbs.twig'), $args);
    }

    protected function buttonGroup($args)
    {
        $wrapperClasses = isset($args['wrapperClasses']) ? $args['wrapperClasses'] : [];
        if (!empty($args['is_preview'])) {
            $links = previewLinks($args['links'], ['link_title' => 'Add some buttons']);
            $wrapperClasses = previewLinkClasses(
                $wrapperClasses,
                empty($args['links'])
            );

            $args['links'] = $links;
        }
        $args['wrapperClasses'] = is_array($wrapperClasses) ? implode(' ', $wrapperClasses) : $wrapperClasses;

        if (!empty($args['buttonColor']) && $args['buttonColor'] === 'secondary') {
            $args['buttonBgColor'] = 'bg-secondary';
            $args['buttonBgHover'] = 'hocus:bg-secondary-dark';
        }

        return Timber::compile(get_blocks_twig_directory('/button-group.twig'), $args);
    }

    protected function carousel($args)
    {
        $carousel = Timber::compile(get_blocks_twig_directory('/carousel.twig'), $args);

        // onload hack fires when block is added
        if (!empty($args['is_preview'])) {
            $carousel .= "<img 
                className='onload-hack-pp'
                height='0'
                width='0'
                onLoad='initCarousel()'
                src=\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1' %3E%3Cpath d=''/%3E%3C/svg%3E\"
            />";
        }

        wp_enqueue_script('slick-carousel-init');
        return $carousel;
    }

    protected function contentSection(array $args = array())
    {
        $backgroundColors = [
            'white' => 'bg-white',
            'gold' => 'bg-tertiary-light',
            'burgundy' => 'bg-primary-dark',
            'gray' => 'bg-gray-lightest',
        ];

        $className = get_key($args, 'className');
        $gridClasses = get_key($args, 'grid') ? 'container-grid' : '';
        $fullWidth = get_key($args, 'fullWidth', false);
        $fullWidth = $fullWidth ? 'container-full' : '';
        $rowSpacing = get_key($args, 'rowSpacing', 'lg');
        $rowSpacing = get_row_spacing($rowSpacing);

        $iconKey = get_key($args, 'iconKey', false);

        $verticalPadding = get_key($args, 'verticalPadding');
        $backgroundColor = get_key($args, 'backgroundColor');

        if ($backgroundColor && isset($backgroundColors[$backgroundColor])) {
            $backgroundColor = $backgroundColors[$backgroundColor];
            $verticalPadding = $verticalPadding ? get_row_spacing($verticalPadding, 'py') : get_row_spacing('none', 'py');
        }


        $title = get_key($args, 'title', '');
        if ($title) {
            $headingLevel = get_key($args, 'headingLevel', 'h2');
            $titleFont = $headingLevel === 'h2' ? 'prose-h2' : 'prose-h3';
            $title = "<$headingLevel class='mb-3 $titleFont'>$title</$headingLevel>";
        }

        $headerLinksArray = get_key($args, 'headerLinks');
        if (is_array($headerLinksArray) && count($headerLinksArray) > 0) {
            $headerLinksArray = array_map(function ($link) {
                return [
                    'content' => $link
                ];
            }, build_links_array($headerLinksArray));
        } else {
            $headerLinksArray = false;
        }

        $headerLinks = $this->iconList([
            'className' => 'flex flex-col fancy-link-list text-lg font-display',
            'itemClasses' => 'mb-2',
            'arrowList' => true,
            'items' => $headerLinksArray,
        ]);

        $headerBody = get_key($args, 'headerBody', false);

        if ($iconKey) {
            $iconKeyArgs = is_array($iconKey) ? $iconKey : [];
            $headerBody .= $this->iconKey($iconKeyArgs);
        }

        if ($headerBody) {
            $headerBody = "<div class='mb-2 text-text text-base-plus-1'>$headerBody</div>";
        }

        $sectionHeader = '';
        $content = get_key($args, 'content', '');

        if ($title || $headerLinks || $headerBody) {
            $headerMargin = get_key($args, 'headerMargin', 'mb-8');
            $headerClasses = get_key($args, 'headerClasses', '');

            $sectionHeader = "
              <header class='$headerMargin $headerClasses'>
                $title
                $headerBody
                $headerLinks
              </header>
            ";
        }

        if ($sectionHeader) {
            $sectionHeader = "
                <div class='$gridClasses'>
                    $sectionHeader
                </div>
            ";
        }

        $content = "
            <div class='$gridClasses $fullWidth'>
              $content
            </div>
        ";

        return "
            <section class='$className $backgroundColor $verticalPadding $rowSpacing'>
              $sectionHeader
              $content
            </section>
        ";
    }

    protected function eventDate($args)
    {
        return Timber::compile(get_blocks_twig_directory('/event-date.twig'), $args);
    }

    protected function iconKey(array $args = array())
    {
        $iconListArgs = [
            'className' => 'icon-sm',
            'itemClasses' => 'mb-2 italic',
            'items' => get_key(
                $args,
                'items',
                [
                    [
                        'title' => 'Denotes External Website',
                        'icon' => 'interface-external',
                    ],
                ]
            ),
            'iconSize' => get_key($args, 'iconSize', 20),
            'iconClasses' => get_key($args, 'iconClasses', 'text-link'),
        ];

        $iconKey = $this->iconList($iconListArgs);

        return "<aside aria-label='Icon Key'>$iconKey</aside>";
    }

    protected function mediaRow($args)
    {
        return Timber::compile(get_blocks_twig_directory('/media-row.twig'), $args);
    }

    protected function fancyLink($args)
    {
        $arrowColorClass = '';
        if (isset($args['arrowColor'])) {
            if ($args['arrowColor'] === 'dark') {
                $arrowColorClass = 'link-arrow-dark';
            } elseif ($args['arrowColor'] === 'light') {
                $arrowColorClass = 'link-arrow-light';
            }
        }
        $classes = isset($args['className']) ? $args['className'] : '';

        return "<a href='"
                . $args['url']
                . "' class='$classes'>"
                . $args['content']
                . "</a>";
    }

    protected function figure($args)
    {
        $figure_args = $args;

        if (! (isset($args['media']) && isset($args['media']['src']))) {
            return '';
        }
        $image_size = !empty($args['imageSize']) ? $args['imageSize'] : 'large';
        $media_args = isset($args['media']) ? $args['media'] : [];

        if (is_string($media_args)) {
            $media = $media_args;
        } else {
            $media_type = isset($args['mediaType']) ? $args['mediaType'] : 'image';

            $figure_classes = [];
            if (isset($args['classes'])) {
                $figure_classes = is_array($args['classes']) ? $args['classes'] : explode(' ', $args['classes']);
            }
            $classes = isset($media_args['classes']) ? $media_args['classes'] : [];
            $media_args['stretch'] = isset($args['stretch']) && $args['stretch'];
            $media_args['videoLink'] = !empty($args['videoLink']) ? $args['videoLink'] : '';
            $media_args['element'] = isset($args['element']) && $args['element'];

            if ($media_type !== 'video-preview') {
                array_push($classes, 'h-full', 'w-full');
            } else {
                array_push($classes, 'col-start-1', 'row-start-1');
            }


            if ($media_type === 'video-preview') {
                $media_args['class'] = $classes;
                $media_args['size'] = $image_size;
                $media = $this->build('videoPreview', $media_args);
            } else {
                if (isset($media_args['keepAspect']) && $media_args['keepAspect']) {
                    $image_size = 'widescreen_sm';
                }
                $image = nc_blocks_image($media_args['src'], $image_size, '', ['class' => implode(' ', $classes)]);
                $media = $image;
            }
        }

        $figure_args['classes'] = $figure_classes;
        $figure_args['media'] = $media;

        return Timber::compile(get_blocks_twig_directory('/figure.twig'), $figure_args);
    }

    protected function pageSection($args)
    {
        $hasSidebar = get_key($args, 'hasSidebar', false);
        $className = get_key($args, 'className', '');
        if (get_key($args, 'fullWidth', false)) {
            $className .= ' container-full container-wrapper';
        }

        $sectionArgs = wp_parse_args([
            'grid' => ! $hasSidebar,
            'className' => $className,
        ], $args);

        return $this->contentSection($sectionArgs);
    }

    protected function icon($args)
    {
        if (!(isset($args['icon']) && $args['icon'])) {
            return '';
        }

        if (strpos(trim($args['icon']), '<svg') === 0) {
            if (! get_key($args, 'rawSprite', false)) {
                return $args['icon'];
            } else {
                trigger_error('Raw sprite value requires an ID string, not SVG contents');
                return '';
            }
        }

        $icon_local_path = '/assets/icons/icon-sprites.svg';

        $icon = $args['icon'];
        $classes = isset($args['classes']) ? $args['classes'] : '';
        $color = get_key($args, 'color') ? $args['color'] : 'bg-current';
        $size = isset($args['size']) && $args['size'] ? $args['size'] : '20';
        $title = isset($args['title']) ? '<title>' . $args['title'] . '</title>' : '';
        $width = isset($args['width']) && $args['width'] ? $args['width'] : $size;
        $height = isset($args['height']) && $args['height'] ? $args['height'] : $size;

        if (get_key($args, 'rawSprite', false)) {
            $iconContents = file_get_contents(get_template_directory() . $icon_local_path);
            $svg = new SimpleXMLElement($iconContents);
            $svg->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');
            $svg->registerXPathNamespace('xlink', 'http://www.w3.org/1999/xlink');

            $result = $svg->xpath("//svg:symbol[@id=\"$icon\"]");
            if (is_array($result) && count($result) > 0) {
                $symbol = $result[0];
                unset($symbol->attributes()->id);

                if ($title) {
                    $symbol->addChild('title', $title);
                }

                $domSvg = dom_import_simplexml($symbol);
                $domDoc = new DOMDocument('1.0');
                $domDoc->formatOutput = true;
                $domSvg = $domDoc->importNode($domSvg, true);
                $domSvg = $domDoc->appendChild($domSvg);

                $icon = $domDoc->saveXML($domDoc, LIBXML_NOEMPTYTAG);

                $icon = str_replace('symbol', 'svg', $icon);
            } else {
                trigger_error('Attempted to create an SVG from an ID that does not exist: ' . $icon);
            }
        } else {
            $icon_url = get_template_directory_uri() . $icon_local_path;
            $icon = "
                <svg class='icon w-$width h-$height $classes
                    fill-current'>
                    $title
                    <use xlink:href='$icon_url#$icon'></use>
                </svg>
                ";
        }

        if (get_key($args, 'cssIcon')) {
            if ($args['icon'] === 'interface-angle-right-narrow') {
            }
            $iconUrl = $this->svgUrlEncode($icon);
            $iconUrl = trim(str_replace("'", '&apos;', $iconUrl));
            // $iconClasses = isset($args['classes']) ? $args['classes'] : '';
            $classes = trim($classes . "mask-no-repeat mask-contain icon w-$width h-$height $color");
            $iconElement = "<div class='$classes' style='mask-image: url(\"data:image/svg+xml,$iconUrl\"); -webkit-mask-image: url(\"data:image/svg+xml,$iconUrl\")'></div>";
            return $iconElement;
        }


        if (isset($args['hidden_text']) && $args['hidden_text']) {
            $icon .= "<span class='sr-only'>" . $args['hidden_text'] . "</span>";
        }

        return $icon;
    }

    protected function svgUrlEncode($svgPath)
    {
        $data = $svgPath;
        // $data = \file_get_contents($svgPath);
        $data = \preg_replace('/\v(?:[\v\h]+)/', ' ', $data);
        $data = \str_replace('"', "'", $data);
        // re-decode a few characters understood by browsers to improve compression
        $data = str_replace("\n", '', $data);
        $data = preg_replace('/>\s+</', '><', $data);
        $data = \str_replace('<', '%3C', $data);
        $data = \str_replace('>', '%3E', $data);
        return $data;
    }

    protected function iconFlag($args)
    {
        $element = $args['element'] ?? 'div';

        $className = isset($args['className']) ? $args['className'] : '';

        $className = is_string($className) ? $className : '';

        if (! empty($args['classes']) && is_array($args['classes'])) {
            $classes = implode(' ', $args['classes']);
            $className .= $classes;
        }

        $defaultIcon = 'interface-page';

        $icon = ! empty($args['icon'])
        ? $this->icon([ 'icon' => $args['icon'], 'rawSprite' => true, 'cssIcon' => true ])
        : $this->icon([ 'icon' => $defaultIcon, 'rawSprite' => true, 'cssIcon' => true ]);


        $title = !empty($args['title']) ? $args['title'] : '';
        $content = !empty($args['content']) ? $args['content'] : '';

        $finalArgs = array();

        if (isset($args['href'])) {
            $finalArgs['href'] = $args['href'];
        }

        $elementStart = $element;

        if ($element === 'a' || !empty($args['url'])) {
            $elementStart .= ' href="' . $args['url'] . '"';
        }

        return "
            <$elementStart class='icon-flag $className'>
            <div class='icon-flag__icon " . (!empty($args['iconClasses']) ? $args['iconClasses'] : '') . "'>
                $icon
            </div>
            <div class='icon-flag__title " . (!empty($args['titleClasses']) ? $args['titleClasses'] : '') . "'>$title</div>
            <div class='icon-flag__content " . (!empty($args['contentClasses']) ? $args['contentClasses'] : '') . "'>
                $content
            </div>
            </$element>
        ";
    }

    protected function iconList($args)
    {
        if (! is_array(get_key($args, 'items'))) {
            return '';
        }

        $className = isset($args['className']) ? $args['className'] : '';
        $className = is_string($className) ? $className : '';

        $defaultIcon = 'interface-page';
        $iconSize = '20';

        if (!empty($args['arrowList'])) {
            $defaultIcon = 'interface-angle-right-narrow';
            $className .= ' icon-flag-arrow';
        } else {
            $iconSize = !empty($args['iconSize']) ? $args['iconSize'] : $iconSize;
        }

        $listItems = array();

        foreach ($args['items'] as $itemProps) {
            $itemIcon = get_key($itemProps, 'icon', $defaultIcon);

            $itemArgs = $itemProps;
            $itemArgs['element'] = 'div';
            $itemArgs['icon'] = $itemIcon;
            $itemArgs['className'] = get_key($args, 'itemClasses');
            $itemArgs['iconClasses'] = get_key($args, 'iconClasses');

            $thisItem = "<li>"
                . $this->iconFlag($itemArgs)
                . "</li>";

            array_push($listItems, $thisItem);
        }

        $list = "<ul role='list' class='icon-flag-list $className'>";
        foreach ($listItems as $listItem) {
            $list .= $listItem;
        }
        $list .= '</ul>';

        return $list;
    }

    protected function linkGroup($args)
    {
        $button = '';
        $linkList = '';

        $buttonClasses = 'flex-shrink-0 max-w-full mr-8 mb-8 last:mb-0';

        $newButtonClasses = '';
        if (isset($args['buttonClasses'])) {
            if (is_array($args['buttonClasses'])) {
                $newButtonClasses = implode(' ', $args['buttonClasses']);
            } elseif (is_string($newButtonClasses)) {
                $newButtonClasses = $args['buttonClasses'];
            } else {
                $newButtonClasses = '';
            }

            $buttonClasses .= ' ' . $newButtonClasses;
        }

        if (isset($args['align']) && $args['align'] === 'text-center') {
            $buttonClasses .= ' ml-8';
        }

        $groupClasses = get_key($args, 'groupClasses', '');

        $groupClasses = is_array($groupClasses) ? implode(' ', $groupClasses) : $groupClasses;
        if (! is_string($groupClasses)) {
            $groupClasses = '';
        }


        if (isset($args['button']) && (isset($args['button']['title']) || isset($args['button']['url']))) {
            $button = "<a href=" . $args['button']['url'] . " class='btn $buttonClasses'>
            <div class='button-content'>" . $args['button']['title'] . "</div>
            </a>";
        }

        if ($args['links'] && is_array($args['links'])) {
            $linksArray = get_key($args, 'links');
            if (is_array($linksArray)) {
                $linksArray = array_map(function ($link) {
                    return [
                        'content' => $link
                    ];
                }, build_links_array($linksArray));
            }

            $links = $this->iconList([
                'className' => 'flex flex-col fancy-link-list text-lg font-display',
                'itemClasses' => 'mb-2',
                'arrowList' => true,
                'items' => $linksArray,
            ]);

            $linkList = "<div class='$groupClasses'>
                $links
                $button
                </div>";
        } elseif ($button) {
            $linkList = "<div class='$groupClasses'>
                $button
            </div>";
        }

        $classes = isset($args['classes']) ? $args['classes'] : '';

        if (is_array($classes)) {
            $classes = implode(' ', $classes);
        }

        $templateArgs = [
            'linkList' => $linkList,
            'className' => $classes
        ];

        return Timber::compile(get_blocks_twig_directory('/link-group.twig'), $templateArgs);
    }

    protected function linkList($args)
    {
        $groupClasses = [
            'list-arrow',
            'text-xl',
            'sm:text-2xl',
        ];

        if (isset($args['columns']) && $args['columns']) {
            array_push(
                $groupClasses,
                'columns',
                'columns-auto',
                'sm:gap-x-10',
                'md:gap-x-20',
                'lg:gap-x-40'
            );
        }

        $linkClasses = !(isset($args['textColorScheme']) && $args['textColorScheme'] !== 'light')
                        ? ['text-link', 'hocus:text-link-light']
                        : ['underline', 'hocus:no-underline'];

        array_push(
            $linkClasses,
            'font-bold',
        );

        $listItemClasses = [
            'before:text-xl',
            'sm:before:text-2xl',
        ];

        $list = '';

        if (!empty($args['is_preview'])) {
            if (empty($args['wrapperClases'])) {
                $args['wrapperClasses'] = [];
            } else {
                $args['wrapperClasses'] = is_array($args['wrapperClasses']) ? $args['wrapperClasses'] : explode(' ', $args['wrapperClasses']);
            }

            $args['wrapperClasses'][] = 'pointer-events-none';

            if (empty($args['links'])) {
                $args['links'] = [
                    [
                        'title' => 'Add some links',
                        'url' => '#'
                    ],
                ];

                $args['wrapperClasses'][] = 'opacity-70';
            }

            $args['wrapperClasses'] = implode_classes($args['wrapperClasses']);
        }

        if (is_array($args['links'])) {
            $list .= '<ul class="' . implode(' ', $groupClasses) . '">';
            foreach ($args['links'] as $link) {
                $list .= '<li class="' . implode(' ', $listItemClasses) . '"><a href="' . $link['url'] . '" class="' . implode(' ', $linkClasses) . '">'
                            . $link['title'] . '</a>';

                if (isset($link['description']) && $link['description']) {
                    $list .= '<div class=""><span class="text-base sm:text-lg">' . $link['description'] . '</span></div>';
                }
                    $list .= '</li>';
            }
            $list .= '</ul>';
        }
        return $list;
    }

    protected function mosaicFeatureBlock($args)
    {
        if (isset($args['image']) && $args['image']) {
            $image = new TimberImage($args['image']);

            if (count($args['dimensions']) === 2) {
                $imageSrc = TimberImageHelper::resize($image->src, $args['dimensions'][0], $args['dimensions'][1], 'center');
            } else {
                $imageSrc = $image->src;
            }

            $image = "<img class='object-cover w-full h-full max-w-none max-h-none'
                           src='$imageSrc'
                           alt=''
                           width='" . $args['dimensions'][0] . "'
                           height='" . $args['dimensions'][1] . "' />";
        } else {
            $image = '';
        }

        $figure = Timber::compile(get_blocks_twig_directory() . '/figure.twig', [
            'caption' => $args['caption'],
            'media' => $image,
            'display' => 'block',
            'classes' => ['w-full', 'h-full', 'relative'],
            'captionClasses' => [
                'absolute',
                'bottom-0',
                'right-0',
                'text-text-light',
                'bg-primary-dark',
                'px-5',
                'py-4',
                'text-xs',
                'sm:text-sm',
                'font-semibold',
                'leading-xtight',
            ],
        ]);

        return "<a class='block w-full h-full' href='" . $args['url'] . "'>$figure</a>";
    }

    protected function quotation($args, $is_preview = false)
    {
        if (! empty($args['image'])) {
            $args['image'] = nc_blocks_image($args['image'], 'square');
        }

        $attribution = '';
        if (isset($args['attribution']) && is_array($args['attribution'])) {
            if ($args['attribution']['name']) {
                $attribution .= '<div class="font-bold uppercase">' . $args['attribution']['name'] . '</div>';
            }

            if ($args['attribution']['description']) {
                $attribution .= '<div>' . $args['attribution']['description'] . '</div>';
            }
        }

        $args['attribution'] = $attribution;

        return Timber::compile(get_blocks_twig_directory('/quote-text.twig'), $args);
    }

    protected function routingCard($args)
    {
        $title = empty($args['title']) ? '' : $args['title'];
        $url = empty($args['url']) ? '' : $args['url'];
        $image = empty($args['image']) ? '' : $args['image'];

        $image = nc_blocks_image($image, 'routing_card', [
            'class' => 'object-cover w-full h-full',
        ]);

        $card = '<figure class="w-full h-full routing-card group">';
        if ($image) {
            $card .= '<div class="z-0 image">';
            $card .= $image;
            $card .= '</div>';
        }

        if ($title) {
            $card .= '<figcaption class="z-20 px-5 py-5 text-xl font-bold leading-tight text-center bg-tertiary text-primary-dark">';
            if ($url) {
                $card .= "<a class='link-block' href='$url'>$title</a>";
            } else {
                $card .= $title;
            }
            $card .= '</figcaption>';
        }

        return $card;
    }

    protected function sectionNav($args)
    {
        return Timber::compile(get_blocks_twig_directory('/section-nav.twig'), $args);
    }

    /**
     * Teaser Text Block
     *
     * Available arguments (all are optional):
     * - textColorScheme (string) ['light', 'dark', 'default']
     * - textJustify (string) ['left', 'right', 'center']
     * - superheader (string)
     * - title (string)
     * - body (string)
     *
     * @param [type] $args
     * @return string
     */
    protected function teaserText($args)
    {
        $is_preview = !empty($args['is_preview']) && $args['is_preview'];

        $justify_classes = array(
            'left' => 'text-left',
            'right' => 'text-right',
            'center' => 'text-center',
        );

        $wrapperClasses = empty($args['wrapperClasses']) ? [] : $args['wrapperClasses'];

        if (is_string($wrapperClasses)) {
            $wrapperClasses = [ $wrapperClasses ];
        }

        if (isset($args['justify']) && $args['justify']) {
            $args['textJustify'] = $justify_classes[$args['justify']];
        }
        unset($args['justify']);

        if (
            $is_preview
            && empty($args['superheader'])
            && empty($args['title'])
            && empty($args['body'])
        ) {
            $wrapperClasses[] = 'opacity-50';

            $args['title'] = 'Use the field editor to add heading content…';
        }

        $args['wrapperClasses'] = implode_classes($wrapperClasses);

        return Timber::compile(get_blocks_twig_directory('/teaser-text.twig'), $args);
    }

    protected function videoPreview($args)
    {
        $default_args = array(
            'icon' => 'interface-play-circle',
            'iconSize' => '40',
            'imageOpacity' => '100',
            'imageHoverOpacity' => '80'
        );

        $args = wp_parse_args($args, $default_args);

        $image_id = isset($args['src']) ? $args['src'] : '';
        $image_size = isset($args['size']) ? $args['size'] : 'large';
        $image_classes = isset($args['classes']) ? implode(' ', $args['classes']) : '';
        $image_classes = 'z-0 object-cover w-full col-start-1 row-start-1';
        if ($args['imageOpacity']) {
            $image_classes .= ' opacity-' . $args['imageOpacity'];
        }
        if ($args['imageHoverOpacity']) {
            $image_classes .= ' transition-opacity';
            $image_classes .= ' group-hover:opacity-' . $args['imageHoverOpacity'];
        }

        $args['image'] = nc_blocks_image($image_id, $image_size, '', array('class' => $image_classes));

        $icon_args = array(
            'icon' => $args['icon'],
            'hiddenText' => 'Play Video',
            'size' => $args['iconSize']
        );

        $args['icon'] = $this->icon($icon_args);

        wp_enqueue_style('magnific-popup-styles');
        wp_enqueue_script('magnific-popup-library');
        wp_enqueue_script('video-preview-init');

        return Timber::compile(get_blocks_twig_directory('/video-preview.twig'), $args);
    }
}
