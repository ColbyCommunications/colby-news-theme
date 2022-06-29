<?php 

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_611bcca35c1c6',
	'title' => 'Featured Story',
	'fields' => array(
		array(
			'key' => 'field_611bccbbf90bf',
			'label' => 'Use latest Highlight',
			'name' => 'use_latest',
			'type' => 'true_false',
			'instructions' => 'If set to Yes, the story will be the most recent post with the tag "Highlight"',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_611bccfbf90c0',
			'label' => 'Choose Post',
			'name' => 'post_id',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_611bccbbf90bf',
						'operator' => '!=',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'post',
			),
			'taxonomy' => '',
			'allow_null' => 1,
			'multiple' => 0,
			'return_format' => 'id',
			'save_custom' => 0,
			'save_post_status' => 'publish',
			'acfe_bidirectional' => array(
				'acfe_bidirectional_enabled' => '0',
			),
			'ui' => 1,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/nc-featured-story',
			),
		),
	),
	'menu_order' => 1,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
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
	'modified' => 1629211960,
));

endif;