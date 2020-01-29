<?php
/***************************************** 
/* DONUT CHART
/*****************************************/
$icon_picker_options = apply_filters('wyde_iconpicker_options', array());
$icon_picker_options[0]['dependency'] = array(
		                    'element' => 'label_style',
		                    'value' => array('icon')
		                );

vc_map( array(
            'name' => esc_html__('Donut Chart', 'gogreen'),
            'description' => esc_html__('Animated donut chart.', 'gogreen'),
            'base' => 'wyde_donut_chart',
            'controls' => 'full',
            'icon' =>  'wyde-icon donut-chart-icon', 
            'weight'    => 900,
            'category' => esc_html__('Wyde', 'gogreen'),
            'params' => array(
                    array(
                        'param_name' => 'title',
                        'type' => 'textfield',
                        'heading' => esc_html__('Title', 'gogreen'),                        
                        'admin_label' => true,
                        'description' => esc_html__('Set chart title.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'value',
                        'type' => 'textfield',
                        'heading' => esc_html__('Chart Value', 'gogreen'),
                        'admin_label' => true,
                        'description' => esc_html__('Input chart value here. can be 1 to 100.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'label_style',
                        'type' => 'dropdown',                        
                        'heading' => esc_html__('Label Style', 'gogreen'),                        
                        'value' => array(
                            'Text' => '', 
                            'Icon' => 'icon', 
                        ),
                        'description' => esc_html__('Select a label style.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'label',
                        'type' => 'textfield',
                        'heading' => esc_html__('Label', 'gogreen'),                      
                        'description' => esc_html__('Set chart label.', 'gogreen'),
                        'dependency' => array(
		                    'element' => 'label_style',
		                    'is_empty' => true,
		                )
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
                            esc_html__('Default', 'gogreen') => '', 
                            esc_html__('Outline', 'gogreen') => 'outline', 
                            esc_html__('Inline', 'gogreen') => 'inline', 
                        ),
                        'description' => esc_html__('Select style.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'bar_color',
                        'type' => 'colorpicker',
                        'heading' => esc_html__('Bar Color', 'gogreen'),                        
                        'description' => esc_html__('Select bar color.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'bar_border_color',
                        'type' => 'colorpicker',                        
                        'heading' => esc_html__('Border Color', 'gogreen'),
                        'description' => esc_html__('Select border color.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'fill_color',
                        'type' => 'colorpicker',
                        'heading' => esc_html__('Fill Color', 'gogreen'),
                        'description' => esc_html__('Select background color of the whole circle.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'start',
                        'type' => 'dropdown',
                        'heading' => esc_html__('Start', 'gogreen'),                        
                        'value' => array(
                            esc_html__('Default', 'gogreen') => '', 
                            esc_html__('90 degree', 'gogreen') => '90', 
                            esc_html__('180 degree', 'gogreen') => '180', 
                            esc_html__('270 degree', 'gogreen') => '270', 
                        ),
                        'description' => esc_html__('Select the degree to start animate.', 'gogreen')
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
));