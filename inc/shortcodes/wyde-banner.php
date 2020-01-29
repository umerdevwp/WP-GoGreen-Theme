<?php
/***************************************** 
/* ACTION BOX
/*****************************************/	
class WPBakeryShortCode_Wyde_Banner extends WPBakeryShortCode {
    
}

vc_map( array(
	'name' => esc_html__( 'Banner', 'gogreen' ),
	'base' => 'wyde_banner',
	'icon' => 'wyde-icon banner-icon',
	'weight'    => 900,
	'category' => esc_html__('Wyde', 'gogreen'),
	'description' => esc_html__( 'Banner.', 'gogreen' ),
	'params' => array(
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
            'description' => esc_html__('Enter subheading text.', 'gogreen')
        ),
        array(
            'param_name' => 'subheading_color',
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Subheading Color', 'gogreen' ),                    
            'description' => esc_html__( 'Select subheading text color.', 'gogreen' )
        ),
        array(
        	'param_name' => 'image',
            'type' => 'attach_image',
            'heading' => esc_html__( 'Image', 'gogreen' ),
            'description' => esc_html__( 'Select image from media library.', 'gogreen' )
        ),
        array(
        	'param_name' => 'image_size',
	        'type' => 'dropdown',
	        'heading' => esc_html__( 'Image Size', 'gogreen' ),		        
	        'value' => array(
                esc_html__('Medium (340x340)', 'gogreen' ) => 'gogreen-medium',
                esc_html__('Large (640x640)', 'gogreen' ) => 'gogreen-large',
                esc_html__('Extra Large (960x960)', 'gogreen' ) => 'gogreen-xlarge',
                esc_html__('Full Width (min-width: 1280px)', 'gogreen' ) => 'gogreen-fullwidth',
                esc_html__('Original', 'gogreen' ) => 'full',
	        ),
	        'description' => esc_html__( 'Select image size.', 'gogreen' ),
	        'std'	=> 'full',
        ),
        array(
            'param_name' => 'link',
	        'type' => 'vc_link',
	        'heading' => esc_html__( 'URL (Link)', 'gogreen' ),			        
	        'description' => esc_html__( 'Set a Read More link.', 'gogreen' )
	    ),
	    array(
            'param_name' => 'banner_style',
            'type' => 'dropdown',
            'heading' => esc_html__('Banner Style', 'gogreen'),                    
            'value' => array(
                esc_html__('Style 1', 'gogreen') => '1', 
                esc_html__('Style 2', 'gogreen') => '2', 
                esc_html__('Style 3', 'gogreen') => '3',
                esc_html__('Style 4', 'gogreen') => '4', 
            ),
            'description' => esc_html__('Select banner style.', 'gogreen'),
        ),
        array(
            'param_name' => 'bg_color',
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Background Color', 'gogreen' ),                    
            'description' => esc_html__( 'Select text background color.', 'gogreen' ),
            'dependency' => array(
                'element' => 'banner_style',
                'value' => array( '1' )
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
		),

	),
) );
