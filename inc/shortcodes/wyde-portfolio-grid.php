<?php
/***************************************** 
/* PORTFOLIO GRID
/*****************************************/

vc_map( array(
    'name' => esc_html__('Portfolio Grid', 'gogreen'),
    'description' => esc_html__('Displays Portfolio list.', 'gogreen'),
    'base' => 'wyde_portfolio_grid',    
    'controls' => 'full',
    'icon' =>  'wyde-icon portfolio-grid-icon', 
    'weight'    => 900,
    'category' => esc_html__('Wyde', 'gogreen'),
    'params' => array(            
            array(
                'param_name' => 'view',
                'type' => 'dropdown',                
                'heading' => esc_html__('View', 'gogreen'),                
                'admin_label' => true,
                'value' => array(
                    esc_html__('Grid (Without Space)', 'gogreen') => 'grid', 
                    esc_html__('Grid (With Space)', 'gogreen') => 'grid-space',
                    esc_html__('Photoset', 'gogreen') => 'photoset',
                    esc_html__('Masonry 1', 'gogreen') => 'masonry-1',
                    esc_html__('Masonry 2', 'gogreen') => 'masonry-2',
                ),
                'description' => esc_html__('Select portfolio layout style.', 'gogreen')
            ),
            array(
                'param_name' => 'columns',
                'type' => 'dropdown',
                'heading' => esc_html__('Columns', 'gogreen'),                
                'value' => array(
                    '2', 
                    '3', 
                    '4',
                ),
                'std' => '4',
                'description' => esc_html__('Select the number of grid columns.', 'gogreen'),
                'dependency' => array(
		            'element' => 'view',
		            'value' => array('grid', 'grid-space', 'photoset')
		        )
            ),
            array(
                'param_name' => 'hover_effect',
                'type' => 'dropdown',
                'heading' => esc_html__('Hover Effect', 'gogreen'),                
                'admin_label' => true,
                'value' => array(
                    esc_html__('Apollo', 'gogreen') => 'apollo', 
                    esc_html__('Duke', 'gogreen') => 'duke',                 
                    esc_html__('Rotate Zoom In', 'gogreen') => 'rotateZoomIn',                           
                    esc_html__('GoGreen', 'gogreen') => 'gogreen', 
                ),
                'description' => esc_html__('Select the hover effect for portfolio items.', 'gogreen'),
                'dependency' => array(
		            'element' => 'view',
		            'value' => array('grid', 'grid-space', 'masonry', 'masonry-1', 'masonry-2')
		        )
            ),
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
                'param_name' => 'hide_filter',
                'type' => 'checkbox',
                'heading' => esc_html__('Hide Filter', 'gogreen'),                
                'description' => esc_html__('Display animated category filter to your grid.', 'gogreen')
            ),
            array(
                'param_name' => 'pagination',
                'type' => 'dropdown',         
                'heading' => esc_html__('Pagination Type', 'gogreen'),                
                'value' => array(
                    esc_html__('Infinite Scroll', 'gogreen') => '1',
                    esc_html__('Show More Button', 'gogreen') => '2',
                    esc_html__('Hide', 'gogreen') => 'hide',
                    ),
                'description' => esc_html__('Select the pagination type.', 'gogreen')
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