<?php 
/***************************************** 
/* ACTION BOX
/*****************************************/
$icon_picker_options = apply_filters('wyde_iconpicker_options', array());

vc_map( array(
            'name' => esc_html__('Counter Box', 'gogreen'),
            'description' => esc_html__('Animated numbers.', 'gogreen'),
            'base' => 'wyde_counter_box',
            'controls' => 'full',
            'icon' =>  'wyde-icon counter-box-icon', 
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
                        'param_name' => 'title',
                        'type' => 'textfield',
                        'heading' => esc_html__('Title', 'gogreen'),                        
                        'admin_label' => true,
                        'description' => esc_html__('Set counter title.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'start',
                        'type' => 'textfield',
                        'heading' => esc_html__('Start From', 'gogreen'),                        
                        'value' => '0',
                        'description' => esc_html__('Set start value.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'value',
                        'type' => 'textfield',                        
                        'heading' => esc_html__('Value', 'gogreen'),                        
                        'value' => '100',
                        'description' => esc_html__('Set counter value.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'format',
                        'type' => 'textfield',                        
                        'heading' => esc_html__('Format', 'gogreen'),   
                        'value' => '#,###.',                     
                        'description' => esc_html__('Set the number format. For example: #,###. = 1,000 and #,###.00 = 1,000.00', 'gogreen'). ' <a href="http://mottie.github.io/javascript-number-formatter/" target="_blank">See full list</a>',
                    ),
                    array(
                        'param_name' => 'unit',
                        'type' => 'textfield',                        
                        'heading' => esc_html__('Unit', 'gogreen'),                        
                        'description' => esc_html__('Set counter unit.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'color',
			            'type' => 'colorpicker',
			            'heading' => esc_html__( 'Color', 'gogreen' ),			            
			            'description' => esc_html__( 'Select a color.', 'gogreen' ),
                    ),
                    array(
                        'param_name' => 'style',
                        'type' => 'dropdown',
                        'heading' => esc_html__('Style', 'gogreen'),                        
                        'value' => array(
                            esc_html__('Top icon', 'gogreen') => '1', 
                            esc_html__('Left icon', 'gogreen') => '2', 
                        ),
                        'description' => esc_html__('Select counter box style.', 'gogreen')
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