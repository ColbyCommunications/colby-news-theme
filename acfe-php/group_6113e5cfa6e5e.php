<?php 

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_6113e5cfa6e5e',
	'title' => 'Post Query',
	'fields' => array(
		array(
			'key' => 'field_6113e5d8d55d5',
			'label' => 'Post Type(s)',
			'name' => 'post_type',
			'type' => 'acfe_post_types',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => '',
			'field_type' => 'checkbox',
			'default_value' => array(
				0 => 'post',
			),
			'return_format' => 'name',
			'layout' => 'vertical',
			'toggle' => 0,
			'allow_custom' => 0,
			'multiple' => 0,
			'allow_null' => 0,
			'choices' => array(
			),
			'ui' => 0,
			'ajax' => 0,
			'placeholder' => '',
			'search_placeholder' => '',
		),
		array(
			'key' => 'field_61156fceb7ad7',
			'label' => 'Categories',
			'name' => 'categories',
			'type' => 'taxonomy',
			'instructions' => 'Hold Ctrl/Cmd (Win/Mac) to select multiple categories.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'taxonomy' => 'category',
			'field_type' => 'multi_select',
			'allow_null' => 1,
			'add_term' => 0,
			'save_terms' => 0,
			'load_terms' => 0,
			'return_format' => 'object',
			'acfe_bidirectional' => array(
				'acfe_bidirectional_enabled' => '0',
			),
			'multiple' => 0,
		),
		array(
			'key' => 'field_611581247d3c4',
			'label' => 'Tags',
			'name' => 'tags',
			'type' => 'taxonomy',
			'instructions' => 'Hold Ctrl/Cmd (Win/Mac) to select multiple tags.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'taxonomy' => 'post_tag',
			'field_type' => 'multi_select',
			'allow_null' => 1,
			'add_term' => 0,
			'save_terms' => 0,
			'load_terms' => 0,
			'return_format' => 'object',
			'acfe_bidirectional' => array(
				'acfe_bidirectional_enabled' => '0',
			),
			'multiple' => 0,
		),
		array(
			'key' => 'field_611573615ae01',
			'label' => 'Post Format',
			'name' => 'post_format',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'all' => 'All',
				'standard' => 'Standard',
				'video' => 'Video',
			),
			'default_value' => 'all',
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_6113e9b6f1aeb',
			'label' => 'Number of Posts',
			'name' => 'posts_per_page',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 10,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_6113e857d097b',
			'label' => 'Order',
			'name' => 'order',
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
				'DESC' => 'Descending (default)',
				'ASC' => 'Ascending',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => 'DESC',
			'layout' => 'horizontal',
			'return_format' => 'value',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_6125370d5e060',
			'label' => 'Include Current Post',
			'name' => 'include_current',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => 'Include',
			'ui_off_text' => 'Exclude',
		),
		array(
			'key' => 'field_6113ed4422ee3',
			'label' => 'Advanced Query Settings',
			'name' => '',
			'type' => 'accordion',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'open' => 0,
			'multi_expand' => 1,
			'endpoint' => 0,
		),
		array(
			'key' => 'field_6113edf422ee5',
			'label' => 'Order Posts By',
			'name' => 'orderby',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'date' => 'Published Date',
				'modified' => 'Modified Date',
			),
			'default_value' => 'date',
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_6125167591cde',
			'label' => 'Offset Posts',
			'name' => 'offset',
			'type' => 'number',
			'instructions' => 'Instead of starting with the first post found, skip this many items. This is useful when you are displaying the latest post separately.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 0,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_6113ecfb22ee2',
			'label' => 'Post Status',
			'name' => 'post_status',
			'type' => 'acfe_post_statuses',
			'instructions' => 'If this field is blank, default status will be "Published"',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_status' => array(
				0 => 'publish',
				1 => 'future',
				2 => 'private',
				3 => 'draft',
			),
			'field_type' => 'checkbox',
			'default_value' => array(
			),
			'return_format' => 'name',
			'layout' => 'vertical',
			'toggle' => 0,
			'allow_custom' => 0,
			'multiple' => 0,
			'allow_null' => 0,
			'choices' => array(
			),
			'ui' => 0,
			'ajax' => 0,
			'placeholder' => '',
			'search_placeholder' => '',
		),
		array(
			'key' => 'field_6113ea7df1aec',
			'label' => 'Sticky Post Behavior',
			'name' => 'ignore_sticky_posts',
			'type' => 'true_false',
			'instructions' => '<b>Sort Normally</b><br />
Posts marked as sticky are treated like all other posts. Equivalent to <code>ignore_sticky_posts = true</code><br />
<b>Move to Start</b><br />
Posts marked as sticky will be listed before all other posts. Equivalent to <code>ignore_sticky_posts = false</code>',
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
			'ui_on_text' => 'Sort Normally',
			'ui_off_text' => 'Move to Start',
		),
		array(
			'key' => 'field_6113eee24e83f',
			'label' => 'Limit to Specific Posts',
			'name' => 'post__in',
			'type' => 'text',
			'instructions' => 'If you only want specific posts to show up, list their ID\'s here, separated by commas.<br>
When using specified post ID\'s, sticky posts behavior will be set to "Sort Normally" regardless of the setting chosen above.<br>
All other settings above will be honored, so if a given ID does not meet the query criteria, it will not be displayed even if it is in this list.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_6125152b2ccf4',
			'label' => 'Exclude Specific Posts',
			'name' => 'post__not_in',
			'type' => 'text',
			'instructions' => 'If you want specific posts to NOT show up, list their ID\'s here, separated by commas.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/nc-post-list-slider',
			),
		),
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/nc-teaser-pair',
			),
		),
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/nc-slider-with-teaser-pair',
			),
		),
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'special-project.php',
			),
		),
	),
	'menu_order' => 5,
	'position' => 'normal',
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
	'modified' => 1631034694,
));

endif;