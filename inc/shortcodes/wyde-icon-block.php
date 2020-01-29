<?php 
/***************************************** 
/* ICON BLOCK
/*****************************************/
$icon_picker_options = apply_filters('wyde_iconpicker_options', array());

vc_map( array(
            'name' => esc_html__('Icon Block', 'gogreen'),
            'description' => esc_html__('Add icon block.', 'gogreen'),
            'base' => 'wyde_icon_block',
            'controls' => 'full',
            'icon' =>  'wyde-icon icon-block-icon', 
            'weight'    => 900,
            'category' => esc_html__('Wyde', 'gogreen'),
            'params' => array(
                    $icon_picker_options[0],
                    $icon_picker_options[1],
                    $icon_picker_options[2],
                    $icon_picker_options[3],
                    $icon_picker_options[4],
                    $icon_picker_options[5],                    
                    array(
                        'param_name' => 'size',
                        'type' => 'dropdown',
                        'heading' => esc_html__('Icon Size', 'gogreen'),                        
                        'value' => array(
                            esc_html__('Small', 'gogreen') => 'small', 
                            esc_html__('Medium', 'gogreen') => 'medium', 
                            esc_html__('Large', 'gogreen') => 'large',
                        ),
                        'description' => esc_html__('Select icon size.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'style',
                        'type' => 'dropdown',
                        'heading' => esc_html__('Icon Style', 'gogreen'),                        
                        'value' => array(
                            esc_html__('Circle', 'gogreen') => 'circle',
                            esc_html__('Square', 'gogreen') => 'square',
                            esc_html__('None', 'gogreen') => 'none',
                        ),
                        'description' => esc_html__('Select icon style.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'hover',
                        'type' => 'dropdown',
                        'heading' => esc_html__('Hover Effect', 'gogreen'),                        
                        'value' => array(
                            esc_html__('None', 'gogreen') => 'none',
                            esc_html__('Zoom In', 'gogreen') => '1',
                            esc_html__('Zoom Out', 'gogreen')  => '2',
                            esc_html__('Pulse', 'gogreen')  => '3',
                            esc_html__('Left to Right', 'gogreen')  => '4',
                            esc_html__('Right to Left', 'gogreen') => '5',
                            esc_html__('Bottom to Top', 'gogreen') => '6',
                            esc_html__('Top to Bottom', 'gogreen') => '7'
                        ),
                        'description' => esc_html__('Select icon hover effect.', 'gogreen'),
                        'dependency' => array(
		                    'element' => 'style',
		                    'value' => array('circle', 'square')
	                    )
                    ),
                    array(
                        'param_name' => 'color',
                        'type' => 'colorpicker',
                        'heading' => esc_html__('Color', 'gogreen'),                        
                        'description' => esc_html__('Select icon text color.', 'gogreen'),
                        'dependency' => array(
		                    'element' => 'style',
		                    'value' => array('none')
	                    )
                    ),
                    array(
                        'param_name' => 'bg_color',
                        'type' => 'colorpicker',
                        'heading' => esc_html__('Background Color', 'gogreen'),                        
                        'description' => esc_html__('Select icon background color.', 'gogreen'),
                        'dependency' => array(
		                    'element' => 'style',
		                    'value' => array('circle', 'square')
	                    )
                    ),
                    array(
                        'param_name' => 'link',
                        'type' => 'vc_link',
                        'heading' => esc_html__('URL', 'gogreen'),                        
                        'description' => esc_html__('Icon link.', 'gogreen'),                        
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