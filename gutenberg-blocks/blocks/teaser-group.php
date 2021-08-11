<?php

/**
 * Teaser Group
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

namespace NC_Blocks;

require_once(get_template_directory() . '/gutenberg-blocks/blocks-utilities.php');
require_once(get_template_directory() . '/gutenberg-blocks/components/block-components.php');

$component = new Component();

use Timber\Timber;

$context = Timber::context();

$className = 'nc-teaser-group';

$wrapperClasses = [
    $className,
];

$containerClasses = [
    'mx-auto',
    'px-container'
];

if ($is_preview) {
    $wrapperClasses[] = 'pointer-events-none';
}

if (get_field('columnWidth') === 'narrow') {
    $containerClasses[] = 'container-narrow';
} else {
    $containerClasses[] = 'container';
}

$spaceAfter = get_row_spacing(get_field('spaceAfter'), 'mb');

if ($spaceAfter) {
    $wrapperClasses[] = $spaceAfter;
}

$bgColor = get_field('background_color');
if ($bgColor && $bgColor !== 'none') {
    $wrapperClasses[] = $bgColor;

    $rowPaddingSelection = get_field('padding');
    $rowPaddingSelection = $rowPaddingSelection ? $rowPaddingSelection : 'md';
    $rowPadding = get_row_spacing($rowPaddingSelection, 'py');

    if ($rowPadding) {
        $wrapperClasses[] = $rowPadding;
    }
}

$statBlocksColors = [
    'bg-tertiary',
    [
        'background' => 'bg-secondary',
        'text' => 'text-white',
    ],
    [
        'background' => 'bg-primary',
        'text' => 'text-white',
    ],
    'bg-blue-300',
    'bg-blue-100',
];

$gridItems = get_field('teasers');
$gridClasses = [];

if (is_array($gridItems)) {
    $gridItems = array_map(
        function ($teaser, $teaser_number) use ($component) {
            $video = !empty($teaser['video']) ? $teaser['video'] : false;

            if (!empty($teaser['image'])) {
                $media = $component->build('figure', [
                    'mediaType' => $video ? 'video-preview' : 'image',
                    'media' => [
                        'src' => $teaser['image'],
                    ],
                    'caption' => !empty($teaser['caption']) ? $teaser['caption'] : false,
                    'imageSize' => 'teaser',
                    'videoLink' => get_repeater_video('teasers', $teaser_number)
                ]);
            } else {
                $media = false;
            }

            $url = !empty($teaser['link_url']) && !empty($teaser['link_url']['url'])
                    ? $teaser['link_url']['url']
                    : false;

            if ($url) {
                $teaser['url'] = $url;

                if (empty($teaser['video'])) {
                    $teaser['mediaUrl'] = $teaser['url'];
                }
            }

            if ($media) {
                $teaser['figure'] = $media;
            }

            return Timber::compile(get_blocks_twig_directory('/simple-teaser.twig'), $teaser);
        },
        $gridItems,
        array_keys($gridItems),
    );
} else {
    if ($is_preview) {
        $gridItems = [
            Timber::compile(get_blocks_twig_directory('/simple-teaser.twig'), [
                'title' => 'Add some teasers…',
                'body' => 'The first teaser you add will replace this placeholder.',
                'wrapperClasses' => 'border border-gray-500 border-dashed p-4'
            ]),
        ];
        $gridClasses[] = 'pointer-events-none';
        $gridClasses[] = 'opacity-70';
    } else {
        $gridItems = [];
    }
}

$header = $component->build('teaserText', [
    'title' => get_field('title'),
    'superheader' => get_field('superheader'),
    'body' => get_field('body'),
    'wrapperClasses' => ['mb-6'],
]);

$teaserGrid = $component->build('boxGrid', [
    'gridCols' => 'grid-cols-box-md',
    'gridItems' => $gridItems,
    'wrapperClasses' => implode_classes($gridClasses),
]);

?>
<div class="<?php echo implode_classes($wrapperClasses); ?>">
    <div class="<?php echo implode_classes($containerClasses); ?>">
        <?php echo $header; ?>
        <?php echo $teaserGrid; ?>
    </div>
</div>
