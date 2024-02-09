<?php

if ( ! ( defined( 'WP_CLI' ) && WP_CLI ) ) {
	return;
}

class Remove_Blocks_Script {
	public function removeBlocks() {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => -1,
    );

    $posts = new WP_Query($args);

    if ($posts->have_posts()) {
        while ($posts->have_posts()) {
            $posts->the_post();

            $post_id      = get_the_ID();
            $post_content = get_post_field('post_content', $post_id);

            $blocks_to_remove = ['acf/nc-related-posts', 'acf/nc-teaser-pair'];

            // Parse the blocks in the post content
            $blocks = parse_blocks($post_content);

						// Check if the last block is 'core/separator'
            $last_block = end($blocks);
            if ($last_block && $last_block['blockName'] === 'core/separator') {
                array_pop($blocks); // Remove the last 'core/separator' block
            }

						$filteredArray = array_map(function ($block) {
							// Convert 'core/paragraph' blocks to 'acf/paragraph'
							if ($block['blockName'] === 'core/paragraph') {
									$block['blockName'] = 'acf/paragraph';
							}

							return $block;
						}, $blocks);

            $filteredArray = array_filter($blocks, function ($block) use ($blocks_to_remove) {
                if (in_array($block['blockName'], $blocks_to_remove)) {
                    return false;
                }

								// Check for subscribe block
                if ($block['blockName'] === 'core/block' && isset($block['attrs']['ref']) && ($block['attrs']['ref'] === 11949) !== false) {
                    return false;
                }

                // Check for "core/heading" blocks with innerHTML containing "Highlights"
								if ($block['blockName'] === 'core/heading' && isset($block['innerHTML']) && strpos($block['innerHTML'], 'Highlights') !== false) {
										return false;
								}

                return true;
            });

            // Convert the modified blocks back to content
            $new_post_content = '';

            foreach ($filteredArray as $block) {
                $new_post_content .= serialize_block($block);
            }

            // Update the post content with the modified blocks
            wp_update_post(array('ID' => $post_id, 'post_content' => $new_post_content));
        }
    }
    WP_CLI::success( "done" );
  }
}

WP_CLI::add_command( 'removeBlocks', 'Remove_Blocks_Script' );