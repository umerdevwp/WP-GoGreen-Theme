<?php
/***************************************** 
/* HEADING
/*****************************************/
vc_map( array(
            'name' => esc_html__('Heading', 'gogreen'),
            'description' => esc_html__('Heading text.', 'gogreen'),
            'base' => 'wyde_heading',
            'controls' => 'full',
            'icon' =>  'wyde-icon heading-icon', 
            'weight'    => 999,
            'category' => esc_html__('Wyde', 'gogreen'),
            'params' => array(
                array(
                    'param_name' => 'style',
                    'type' => 'dropdown',                    
                    'heading' => esc_html__('Style', 'gogreen'),                    
                    'value' => array(                        
                        esc_html__('Top Subtitle', 'gogreen') => '1', 
                        esc_html__('Bottom Subtitle ', 'gogreen') => '2', 
                        esc_html__('With Background', 'gogreen') => '3', 
                        esc_html__('Simple', 'gogreen') => '4', 
                        esc_html__('Vertical Line', 'gogreen') => '5',      
                        esc_html__('Vertical Line - Right', 'gogreen') => '6', 
                        esc_html__('Minimal', 'gogreen') => '7', 
                        esc_html__('Headline', 'gogreen') => '8',
                        esc_html__('Separator', 'gogreen') => '9',                   
                    ),
                    'description' => esc_html__('Select a heading style.', 'gogreen')
                ),
                array(
                    'param_name' => 'title',
                    'type' => 'textarea',
                    'heading' => esc_html__('Heading', 'gogreen'),                    
                    'admin_label' => true,
                    'description' => esc_html__('Enter heading text.', 'gogreen')
                ),
                array(
                    'param_name' => 'heading_color',
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Heading Color', 'gogreen' ),                    
                    'description' => esc_html__( 'Select heading text color.', 'gogreen' )
                ),
                array(
                    'param_name' => 'subheading',
                    'type' => 'textarea',                    
                    'heading' => esc_html__('Subheading', 'gogreen'),                    
                    'admin_label' => true,                    
                    'description' => esc_html__('Enter subheading text.', 'gogreen'),
                    'dependency' => array(
                        'element' => 'style',
                        'value' => array('1', '2', '3', '4', '5', '6', '7', '8'),
                    )
                ),
                array(
                    'param_name' => 'subheading_color',
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Subheading Color', 'gogreen' ),                    
                    'description' => esc_html__( 'Select subheading text color.', 'gogreen' ),
                    'dependency' => array(
                        'element' => 'style',
                        'value' => array('1', '2', '3', '4', '5', '6', '7', '8'),
                    )
                ),
                array(
                    'param_name' => 'text_align',
                    'type' => 'dropdown',
                    'heading' => esc_html__('Text Alignment', 'gogreen'),                    
                    'value' => array(                        
                        esc_html__('Left', 'gogreen') => 'left', 
                        esc_html__('Center', 'gogreen') =>'center', 
                        esc_html__('Right', 'gogreen') => 'right', 
                    ),
                    'description' => esc_html__('Select text alignment.', 'gogreen'),
                    'std' => 'center',
                    'dependency' => array(
                        'element' => 'style',
                        'value' => array('1', '2', '3', '4', '7', '8', '9'),
                    )
                ),
                array(
                    'param_name' => 'background_color',
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Background Color', 'gogreen' ),                    
                    'description' => esc_html__( 'Select background color.', 'gogreen' ),
                    'dependency' => array(
                        'element' => 'style',
                        'value' => array('3'),
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
            )
) );