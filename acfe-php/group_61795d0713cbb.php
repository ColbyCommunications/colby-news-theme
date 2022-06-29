<?php 

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_61795d0713cbb',
	'title' => 'Featured Image',
	'fields' => array(
		array(
			'key' => 'field_61795d36cd3f2',
			'label' => 'Set Featured Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => 'Featured images are required for every post. Images must be 1600x1067 px.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'uploader' => '',
			'acfe_thumbnail' => 1,
			'return_format' => 'id',
			'preview_size' => 'medium',
			'min_width' => 1600,
			'min_height' => 1067,
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => 2,
			'mime_types' => 'jpg, jpeg, webp',
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
		),
	),
	'menu_order' => 1,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'featured_image',
	),
	'active' => true,
	'description' => '',
	'acfe_display_title' => '',
	'acfe_autosync' => array(
		0 => 'php',
	),
	'acfe_form' => 0,
	'acfe_meta' => '',
	'acfe_note' => '',
	'modified' => 1635344070,
));

endif;