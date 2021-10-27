<?php 

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_611e824d0b996',
	'title' => 'Featured Video',
	'fields' => array(
		array(
			'key' => 'field_611e8280d85fb',
			'label' => '',
			'name' => '',
			'type' => 'message',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'The featured video will display <i>instead of</i> the featured image on the story post. Previews of the story found elsewhere, such as post lists, will still use the featured image.',
			'new_lines' => 'wpautop',
			'esc_html' => 0,
		),
		array(
			'key' => 'field_611e82d9d85fc',
			'label' => 'Video',
			'name' => 'featured_video',
			'type' => 'oembed',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'width' => 1066,
			'height' => 600,
		),
		array(
			'key' => 'field_612d32031cc49',
			'label' => 'Video File',
			'name' => 'video_file',
			'type' => 'file',
			'instructions' => 'Use this field to add a video file associated with the post. This theme does not currently support displaying video files.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'uploader' => '',
			'return_format' => 'url',
			'min_size' => '',
			'max_size' => '',
			'mime_types' => '',
			'library' => 'all',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
			array(
				'param' => 'post_format',
				'operator' => '==',
				'value' => 'video',
			),
		),
	),
	'menu_order' => 5,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'tooltip',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'acfe_display_title' => '',
	'acfe_autosync' => array(
		0 => 'php',
	),
	'acfe_form' => 0,
	'acfe_meta' => '',
	'acfe_note' => '',
	'modified' => 1635343980,
));

endif;