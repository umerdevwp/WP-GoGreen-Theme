<?php
/***************************************** 
/* SEPARATOR
/*****************************************/

$icon_picker_options = apply_filters('wyde_iconpicker_options', array());
$icon_picker_options[0]['dependency'] = array(
		                    'element' => 'label_style',
		                    'value' => array('icon')
		                );

vc_map( array(
	    'name' => esc_html__( 'Separator', 'gogreen' ),
	    'base' => 'wyde_separator',
	    'icon' => 'wyde-icon separator-icon',
	    'show_settings_on_create' => true,
        'weight'    => 900,
	    'category' => esc_html__('Wyde', 'gogreen'),
	    'description' => esc_html__( 'Horizontal separator line', 'gogreen' ),
	    'params' => array(
            array(
                'param_name' => 'label_style',
                'type' => 'dropdown',
                'heading' => esc_html__('Label Style', 'gogreen'),                
                'value' => array(
                    esc_html__('None', 'gogreen') => '', 
                    esc_html__('Text', 'gogreen') => 'text', 
                    esc_html__('Icon', 'gogreen') => 'icon', 
                ),
                'description' => esc_html__('Select a label style.', 'gogreen')
            ),
            array(
                'param_name' => 'title',
                'type' => 'textfield',
                'heading' => esc_html__('Title', 'gogreen'),                
                'description' => esc_html__('Input a title text separator.', 'gogreen'),
                'dependency' => array(
		            'element' => 'label_style',
		            'value' => array('text'),
		        )
            ),
            $icon_picker_options[0],
            $icon_picker_options[1],
            $icon_picker_options[2],
            $icon_picker_options[3],
            $icon_picker_options[4],
            $icon_picker_options[5],            
            array(
                'param_name' => 'text_align',
                'type' => 'dropdown',
                'heading' => esc_html__('Text Alignment', 'gogreen'),                
                'value' => array(
                    esc_html__('Left', 'gogreen') => 'left', 
                    esc_html__('Center', 'gogreen') => 'center', 
                    esc_html__('Right', 'gogreen') => 'right', 
                ),
                'description' => esc_html__('Select text alignment.', 'gogreen')
            ),
            array(
                'param_name' => 'style',
			    'type' => 'dropdown',
			    'heading' => esc_html__('Style', 'gogreen' ),			    
			    'value' => array(
            	    esc_html__('Solid', 'gogreen') => '',
		            esc_html__('Dashed', 'gogreen') => 'dashed',
		            esc_html__('Dotted', 'gogreen') => 'dotted',
		            esc_html__('Double', 'gogreen') => 'double',
	            ),
			    'description' => esc_html__( 'Separator style', 'gogreen' )
		    ),
		    array(
                'param_name' => 'border_width',
			    'type' => 'dropdown',
			    'heading' => esc_html__( 'Border Thickness', 'gogreen' ),			    
			    'value' => array(
                    '1px',
                    '2px',
                    '3px',
                    '4px',
                    '5px',
                    '6px',
                    '7px',
                    '8px',
                    '9px',
                    '10px',
                ),
			    'description' => esc_html__( 'Select border thickness.', 'gogreen' ),
		    ),
		    array(
                'param_name' => 'el_width',
			    'type' => 'dropdown',
			    'heading' => esc_html__( 'Width', 'gogreen' ),			    
			    'value' => array(
                    '10%',
                    '20%',
                    '30%',
                    '40%',
                    '50%',
                    '60%',
                    '70%',
                    '80%',
                    '90%',
                    '100%',
                ),
			    'description' => esc_html__( 'Separator element width in percents.', 'gogreen' ),
		    ),
            array(
                'param_name' => 'color',
			    'type' => 'colorpicker',
			    'heading' => esc_html__( 'Color', 'gogreen' ),			    
			    'description' => esc_html__( 'Select separator border and text color.', 'gogreen' ),
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