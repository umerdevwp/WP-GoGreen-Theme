<?php
/***************************************** 
/* PRICING BOX
/*****************************************/

vc_map( array(
    'name' => esc_html__('Pricing Box', 'gogreen'),
    'description' => esc_html__('Create pricing box.', 'gogreen'),
    'base' => 'wyde_pricing_box',
    'controls' => 'full',
    'icon' =>  'wyde-icon pricing-box-icon', 
    'weight'    => 900,
    'category' => esc_html__('Wyde', 'gogreen'),
    'params' => array(
            array(
                'param_name' => 'heading',
                'type' => 'textfield',                
                'heading' => esc_html__('Title', 'gogreen'),                
                'admin_label' => true,
                'description' => esc_html__('Enter the heading or package name.', 'gogreen')
            ),
            array(
                'param_name' => 'sub_heading',
                'type' => 'textfield',
                'heading' => esc_html__('Sub Heading', 'gogreen'),
                'description' => esc_html__('Enter a short description.', 'gogreen')
            ),
            array(
                'param_name' => 'image',
                'type' => 'attach_image',
                'heading' => esc_html__( 'Image', 'gogreen' ),
                'description' => esc_html__( 'Select image from media library.', 'gogreen' )
            ),
            array(
                'param_name' => 'price',
                'type' => 'textfield',
                'heading' => esc_html__('Price', 'gogreen'),                
                'admin_label' => true,
                'description' => esc_html__('Enter a price. E.g. 100, 150, etc.', 'gogreen')
            ),
            array(
                'param_name' => 'price_unit',
                'type' => 'textfield',
                'heading' => esc_html__('Price Unit', 'gogreen'),
                'description' => esc_html__('Enter a price unit. E.g. $, €, etc.', 'gogreen')
            ),
            array(
                'param_name' => 'price_term',
                'type' => 'textfield',
                'heading' => esc_html__('Price Term', 'gogreen'),
                'description' => esc_html__('Enter a price term. E.g. per month, per year, etc.', 'gogreen')
            ),
            array(
                'param_name' => 'color',
			    'type' => 'colorpicker',
			    'heading' => esc_html__( 'Heading Color', 'gogreen' ),			    
			    'description' => esc_html__( 'Select heading color.', 'gogreen' ),
            ),
            array(
                'param_name' => 'content',
                'type' => 'textarea_html',
                'heading' => esc_html__('Features', 'gogreen'),         
                'description' => esc_html__('Enter the features list or table description.', 'gogreen')
            ),
            array(
                'param_name' => 'button_text',
                'type' => 'textfield',
                'heading' => esc_html__('Button Text', 'gogreen'),
                'description' => esc_html__('Enter a button text.', 'gogreen')
            ),
            array(
                'param_name' => 'button_color',
			    'type' => 'colorpicker',
			    'heading' => esc_html__( 'Button Color', 'gogreen' ),			    
			    'description' => esc_html__( 'Select button background color.', 'gogreen' ),
            ),
            array(
                'param_name' => 'link',
                'type' => 'vc_link',
                'heading' => esc_html__('Button Link', 'gogreen'),
                'description' => esc_html__('Select or enter the link for button.', 'gogreen')
            ),
            array(
                'param_name' => 'featured',
                'type' => 'checkbox',
                'heading' => esc_html__('Featured Box', 'gogreen'),                
                'description' => esc_html__('Make this box as featured', 'gogreen')                
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