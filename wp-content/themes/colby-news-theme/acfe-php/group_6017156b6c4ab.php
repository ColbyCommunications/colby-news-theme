<?php 

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_6017156b6c4ab',
	'title' => 'Buttons',
	'fields' => array(
		array(
			'key' => 'field_6017156b77eb3',
			'label' => 'Links',
			'name' => 'links',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'acfe_repeater_stylised_button' => 1,
			'collapsed' => 'field_60171587347dc',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => 'Add link',
			'sub_fields' => array(
				array(
					'key' => 'field_60171587347dc',
					'label' => 'Link',
					'name' => 'link',
					'type' => 'acfe_advanced_link',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array(
						0 => 'post',
						1 => 'page',
					),
					'taxonomy' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/nc-button-group',
			),
		),
	),
	'menu_order' => 30,
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
	'modified' => 1621963595,
));

endif;