<?php
/***************************************** 
/* SECTION SEPARATOR
/*****************************************/

vc_map( array(
	'name' => esc_html__( 'Section Separator', 'gogreen' ),
	'base' => 'wyde_section_separator',
    'icon' =>  'wyde-icon section-separator-icon', 
	'category' => esc_html__('Wyde', 'gogreen'),
    'weight'    => 900,
	'description' => esc_html__( 'Section separator.', 'gogreen' ),
	'params' => array(
        array(
            'param_name' => 'style',
            'type' => 'dropdown',
            'heading' => esc_html__('Style', 'gogreen'),            
            'value' => array(
                esc_html__('Style 1', 'gogreen') => '1', 
                esc_html__('Style 2', 'gogreen') => '2', 
                esc_html__('Style 3', 'gogreen') => '3', 
                esc_html__('Style 4', 'gogreen') => '4', 
                esc_html__('Style 5', 'gogreen') => '5', 
            ),
            'description' => esc_html__('Select separator style.', 'gogreen'),
        ),
        array(
            'param_name' => 'reflect',
            'type' => 'checkbox',
            'heading' => esc_html__('Reflect', 'gogreen'),            
            'value' => array(
                esc_html__('Horizontal', 'gogreen') => 'reflect-h',
            ),
            'description' => esc_html__('Select to horizontal flip the separator shape.', 'gogreen')
        ),
        array(
            'param_name' => 'overlap',
            'type' => 'dropdown',
            'heading' => esc_html__('Overlap', 'gogreen'),            
            'value' => array(
                esc_html__('Top', 'gogreen') => 'top',
                esc_html__('Bottom', 'gogreen') => 'bottom', 
            ),
            'description' => esc_html__('Select the direction of another object that will be overlapped.', 'gogreen')
        ),
        array(
            'param_name' => 'background_color',
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Background Color', 'gogreen' ),            
            'description' => esc_html__( 'Select background color.', 'gogreen' ),
            'value' => '#fff',
        ),
        array(
            'param_name' => 'shape_color',
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Shape Color', 'gogreen' ),            
            'description' => esc_html__( 'Select shape color.', 'gogreen' ),
            'value' => '',
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
        