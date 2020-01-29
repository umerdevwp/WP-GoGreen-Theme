<?php  
/* Products Slider
---------------------------------------------------------- */
class WPBakeryShortCode_Wyde_WC_Products_Slider extends WPBakeryShortCode {
}

vc_map( array(
    'name' => esc_html__('Products Slider', 'gogreen'),
    'description' => esc_html__('Displays products in slider.', 'gogreen'),
    'base' => 'wyde_wc_products_slider',
    'controls' => 'full',
    'icon' =>  'icon-wpb-woocommerce', 
    'category' => esc_html__( 'WooCommerce', 'gogreen' ),
    'params' => array(
        array(
            'param_name' => 'posts_query',
            'type' => 'loop',
            'heading' => esc_html__( 'Custom Posts', 'gogreen' ),               
            'settings' => array(
                'post_type'  => array('hidden' => true),
                'categories'  => array('hidden' => true),
                'tags'  => array('hidden' => true),
                'size' => array( 'hidden' => true),
                'order_by' => array( 'value' => 'date' ),
                'order' => array( 'value' => 'DESC' ),
            ),
            'description' => esc_html__( 'Create WordPress loop, to populate content from your site.', 'gogreen' )
        ),
        array(
            'param_name' => 'count',
            'type' => 'textfield',
            'heading' => esc_html__('Post Count', 'gogreen'),                
            'value' => '10',
            'description' => esc_html__('Number of posts to show.', 'gogreen'),                
        ),
        array(
            'param_name' => 'visible_items',
            'type' => 'dropdown',
            'heading' => esc_html__('Visible Items', 'gogreen'),                
            'value' => array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10'),
            'std' => '3',
            'description' => esc_html__('The maximum amount of items displayed at a time.', 'gogreen'),            
        ),
        array(
            'param_name' => 'transition',
            'type' => 'dropdown',
            'heading' => esc_html__('Transition', 'gogreen'),                
            'value' => array(
                esc_html__('Slide', 'gogreen') => '', 
                esc_html__('Fade', 'gogreen') => 'fade', 
            ),
            'description' => esc_html__('Select animation type.', 'gogreen'),
            'dependency' => array(
                'element' => 'visible_items',
                'value' => array('1')
            )
        ),
        array(
            'param_name' => 'show_navigation',
            'type' => 'checkbox',
            'heading' => esc_html__('Show Navigation', 'gogreen'),                
            'description' => esc_html__('Display "next" and "prev" buttons.', 'gogreen'),            
        ),
        array(
            'param_name' => 'show_pagination',
            'type' => 'checkbox',
            'heading' => esc_html__('Show Pagination', 'gogreen'),                
            'description' => esc_html__('Show pagination.', 'gogreen'),            
        ),
        array(
            'param_name' => 'slide_loop',
            'type' => 'checkbox',
            'heading' =>  esc_html__('Loop', 'gogreen'),                
            'description' => esc_html__('Inifnity loop. Duplicate last and first items to get loop illusion.', 'gogreen'),
            'dependency' => array(
                'element' => 'layout',
                'is_empty' => true
            )
        ),
        array(
            'param_name' => 'auto_play',
            'type' => 'checkbox',             
            'heading' => esc_html__('Auto Play', 'gogreen'),                
            'description' => esc_html__('Auto play slide.', 'gogreen'),
            'dependency' => array(
                'element' => 'layout',
                'is_empty' => true
            )
        ),
        array(
            'param_name' => 'speed',
            'type' => 'dropdown',
            'heading' => esc_html__('Speed', 'gogreen'),                    
            'value' => array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10'),
            'std' => '4',
            'description' => esc_html__('The amount of time between each slideshow interval (in seconds).', 'gogreen'),
            'dependency' => array(
                'element' => 'auto_play',
                'value' => 'true'
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