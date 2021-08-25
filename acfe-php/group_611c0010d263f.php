<?php 

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_611c0010d263f',
	'title' => 'External Post List Settings',
	'fields' => array(
		array(
			'key' => 'field_611c001af3d7b',
			'label' => 'Title',
			'name' => 'title',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Media Coverage',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_611c001ff3d7c',
			'label' => 'Number of Posts',
			'name' => 'post_count',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 4,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 1,
			'max' => '',
			'step' => 1,
		),
		array(
			'key' => 'field_6122cee7b28d7',
			'label' => 'Filter by Tag',
			'name' => 'terms',
			'type' => 'acfe_taxonomy_terms',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
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
				'value' => 'acf/nc-external-posts-list',
			),
		),
	),
	'menu_order' => 0,
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
	'modified' => 1629902410,
));

endif;