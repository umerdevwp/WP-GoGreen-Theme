<?php
/***************************************** 
/* ACTION BOX
/*****************************************/
$icon_picker_options = apply_filters('wyde_iconpicker_options', array());
$icon_picker_options[0]['group'] = esc_html__( 'Button', 'gogreen' );
$icon_picker_options[1]['group'] = esc_html__( 'Button', 'gogreen' );
$icon_picker_options[2]['group'] = esc_html__( 'Button', 'gogreen' );
$icon_picker_options[3]['group'] = esc_html__( 'Button', 'gogreen' );
$icon_picker_options[4]['group'] = esc_html__( 'Button', 'gogreen' );
$icon_picker_options[5]['group'] = esc_html__( 'Button', 'gogreen' );


vc_map( array(
	'name' => esc_html__( 'Action Box', 'gogreen' ),
	'base' => 'wyde_action_box',
    'icon' =>  'wyde-icon action-box-icon', 
	'category' => esc_html__('Wyde', 'gogreen'),
    'weight'    => 900,
	'description' => esc_html__( 'Catch visitors attention with call to action box', 'gogreen' ),
	'params' => array(
		array(
            'param_name' => 'title',
			'type' => 'textfield',            
			'heading' => esc_html__( 'Heading first line', 'gogreen' ),
			'admin_label' => true,
			'description' => esc_html__( 'Text for the first heading line.', 'gogreen' )
		),
		array(
            'param_name' => 'content',
			'type' => 'textarea_html',
			'value' => esc_html__( 'I am promo text. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'gogreen' )
		),
        array(
            'param_name' => 'bg_color',
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Background Color', 'gogreen' ),
			'description' => esc_html__( 'Select background color for this element.', 'gogreen' )
		),
        array(
            'param_name' => 'button_text',
            'type' => 'textfield',
            'heading' => esc_html__('Title', 'gogreen'),
            'admin_label' => true,
            'description' => esc_html__('Text on the button.', 'gogreen'),
            'group' => esc_html__( 'Button', 'gogreen' )
        ),
        array(
            'param_name' => 'link',
			'type' => 'vc_link',
			'heading' => esc_html__( 'URL (Link)', 'gogreen' ),
			'description' => esc_html__( 'Set a button link.', 'gogreen' ),
            'group' => esc_html__( 'Button', 'gogreen' )
		),
        $icon_picker_options[0],
        $icon_picker_options[1],
        $icon_picker_options[2],
        $icon_picker_options[3],
        $icon_picker_options[4],
        $icon_picker_options[5],
        array(
            'param_name' => 'style',
            'type' => 'dropdown',
            'heading' => esc_html__('Style', 'gogreen'),
            'value' => array(
                esc_html__('Square', 'gogreen') => '', 
                esc_html__('Round', 'gogreen') => 'round', 
                esc_html__('Rounded', 'gogreen') => 'rounded', 
                esc_html__('Square Outline', 'gogreen') => 'outline', 
                esc_html__('Round Outline', 'gogreen') => 'outline round', 
                esc_html__('Rounded Outline', 'gogreen') => 'outline rounded', 
                esc_html__('None', 'gogreen') => 'none', 
            ),
            'description' => esc_html__('Select button style.', 'gogreen'),
            'group' => esc_html__( 'Button', 'gogreen' )
        ),
        array(
            'param_name' => 'size',
            'type' => 'dropdown',
            'heading' => esc_html__('Size', 'gogreen'),
            'value' => array(
                esc_html__('Small', 'gogreen') => '', 
                esc_html__('Large', 'gogreen') =>'large', 
            ),
            'description' => esc_html__('Select button size.', 'gogreen'),
            'group' => esc_html__( 'Button', 'gogreen' )
        ),
        array(
            'param_name' => 'color',
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Text Color', 'gogreen' ),            
            'description' => esc_html__( 'Select button text color.', 'gogreen' ),
            'group' => esc_html__( 'Button', 'gogreen' )
        ),
        array(
            'param_name' => 'hover_color',
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Hover Color', 'gogreen' ),            
            'description' => esc_html__( 'Select button hover text color.', 'gogreen' ),
            'group' => esc_html__( 'Button', 'gogreen' ),
            'dependency' => array(
                'element' => 'style',
                'value' => array( 'outline', 'outline round', 'outline rounded' )
            )
        ),
        array(
            'param_name' => 'button_color',
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Background Color', 'gogreen' ),            
            'description' => esc_html__( 'Select button background color.', 'gogreen' ),
            'group' => esc_html__( 'Button', 'gogreen' ),
            'dependency' => array(
                'element' => 'style',
                'value' => array( '', 'round', 'rounded' )
            )
        ),
		array(
            'param_name' => 'animation',
            'type' => 'wyde_animation',
            'heading' => esc_html__('Animation', 'gogreen'),
            'description' => esc_html__('Select a CSS3 Animation that applies to this element.', 'gogreen')
        ),
        array(
            'param_name' => 'animation_delay',
            'type' => 'textfield',
            'heading' => esc_html__('Animation Delay', 'gogreen'),
            'description' => esc_html__('Defines when the animation will start (in seconds). Example: 0.5, 1, 2, ...', 'gogreen'),
            'dependency' => array(
				'element' => 'animation',
				'not_empty' => true
			)
        ),
		array(
            'param_name' => 'el_class',
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra CSS Class', 'gogreen' ),			
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'gogreen' )
		),
		array(
            'param_name' => 'css',
			'type' => 'css_editor',
			'heading' => esc_html__( 'CSS', 'gogreen' ),			
			'group' => esc_html__( 'Design Options', 'gogreen' )
		)
	)
) );