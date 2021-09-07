<?php 

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_6120109837bcb',
	'title' => 'Related Posts',
	'fields' => array(
		array(
			'key' => 'field_612010c1f5d6b',
			'label' => 'Choose Posts',
			'name' => 'post_source',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'auto' => 'Automatic (match primary category)',
				'manual' => 'Choose posts manually',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => 'auto',
			'layout' => 'vertical',
			'return_format' => 'value',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_6120115b6023b',
			'label' => 'Select Posts',
			'name' => 'select_posts',
			'type' => 'relationship',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_612010c1f5d6b',
						'operator' => '==',
						'value' => 'manual',
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
			'filters' => array(
				0 => 'search',
				1 => 'taxonomy',
			),
			'elements' => array(
				0 => 'featured_image',
			),
			'min' => '',
			'max' => '',
			'return_format' => 'object',
			'acfe_bidirectional' => array(
				'acfe_bidirectional_enabled' => '0',
			),
		),
		array(
			'key' => 'field_6123ddbc4c599',
			'label' => 'Post Count',
			'name' => 'post_count',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_612010c1f5d6b',
						'operator' => '==',
						'value' => 'auto',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 3,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_6123dcff5c58c',
			'label' => 'Tags',
			'name' => 'tags',
			'type' => 'acfe_taxonomy_terms',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_612010c1f5d6b',
						'operator' => '==',
						'value' => 'auto',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'taxonomy' => array(
				0 => 'post_tag',
			),
			'allow_terms' => '',
			'allow_level' => '',
			'field_type' => 'select',
			'default_value' => array(
			),
			'return_format' => 'id',
			'ui' => 0,
			'allow_null' => 0,
			'multiple' => 1,
			'save_terms' => 0,
			'load_terms' => 0,
			'choices' => array(
			),
			'ajax' => 0,
			'placeholder' => '',
			'search_placeholder' => '',
			'layout' => '',
			'toggle' => 0,
			'allow_custom' => 0,
			'other_choice' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/nc-related-posts',
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
	'modified' => 1629740523,
));

endif;