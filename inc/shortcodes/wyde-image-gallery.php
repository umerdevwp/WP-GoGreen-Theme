<?php
/***************************************** 
/* IMAGE GALLERY
/*****************************************/
vc_map( array(
            'name' => esc_html__('Image Gallery', 'gogreen'),
            'description' => esc_html__('Create beautiful responsive image gallery.', 'gogreen'),
            'base' => 'wyde_image_gallery',
            'controls' => 'full',
            'icon' =>  'wyde-icon image-gallery-icon',
            'weight'    => 900,
            'category' => esc_html__('Wyde', 'gogreen'),
            'params' => array(
                array(
                    'param_name' => 'images',
                    'type' => 'attach_images',            
                    'heading' => esc_html__('Images', 'gogreen'),                                 
                    'description' => esc_html__('Upload or select images from media library.', 'gogreen')
                ),
		        array(
                    'param_name' => 'image_size',
			        'type' => 'dropdown',
			        'heading' => esc_html__( 'Image Size', 'gogreen' ),	
                    'admin_label' => true,		        
			        'value' => array(
    			        esc_html__('Thumbnail (150x150)', 'gogreen' ) => 'thumbnail',
                        esc_html__('Medium (340x340)', 'gogreen' ) => 'gogreen-medium',
                        esc_html__('Large (640x640)', 'gogreen' ) => 'gogreen-large',
                        esc_html__('Extra Large (960x960)', 'gogreen' ) => 'gogreen-xlarge',
                        esc_html__('Full Width (min-width: 1280px)', 'gogreen' ) => 'gogreen-fullwidth',
                        esc_html__('Original', 'gogreen' ) => 'full',
			        ),
			        'description' => esc_html__( 'Select image size.', 'gogreen' )
		        ),
		        array(
                    'param_name' => 'gallery_type',
			        'type' => 'dropdown',
			        'heading' => esc_html__( 'Gallery Type', 'gogreen' ),		
                    'admin_label' => true,	        
			        'value' => array(
                        esc_html__('Grid (Without Space)', 'gogreen') => 'grid', 
                        esc_html__('Grid (With Space)', 'gogreen') => 'grid-space',
				        esc_html__('Masonry', 'gogreen') => 'masonry',
				        esc_html__('Slider', 'gogreen') => 'slider',
			        ),
			        'description' => esc_html__( 'Select gallery type.', 'gogreen' )
		        ),
                array(
                    'param_name' => 'columns',
                    'type' => 'dropdown',
                    'heading' => esc_html__('Columns', 'gogreen'),                    
                    'value' => array(
                        '1', 
                        '2', 
                        '3', 
                        '4',
                        '5',
                        '6',
                    ),
                    'std' => '4',
                    'description' => esc_html__('Select the number of grid columns.', 'gogreen'),
                    'dependency' => array(
		                'element' => 'gallery_type',
		                'value' => array('grid', 'grid-space')
		            )
                ),
		        array(
                    'param_name' => 'layout',
			        'type' => 'dropdown',
			        'heading' => esc_html__( 'Masonry Layout', 'gogreen' ),			        
			        'value' => array(
                        esc_html__('GoGreen 1', 'gogreen') => 'masonry-1', 
                        esc_html__('GoGreen 2', 'gogreen') => 'masonry-2',
                        esc_html__('Basic 1', 'gogreen') => '1',
                        esc_html__('Basic 2', 'gogreen') => '2',
			        ),
			        'description' => esc_html__( 'Select masonry layout.', 'gogreen' ),
                    'dependency' => array(
		                'element' => 'gallery_type',
		                'value' => array('masonry')
		            )
		        ),
                array(
                    'param_name' => 'hover_effect',
                    'type' => 'dropdown',
                    'heading' => esc_html__('Hover Effect', 'gogreen'),                                  
                    'value' => array(
                        esc_html__('None', 'gogreen') => '', 
                        esc_html__('Zoom In', 'gogreen') => 'zoomIn', 
                        esc_html__('Zoom Out', 'gogreen') => 'zoomOut',
                        esc_html__('Rotate Zoom In', 'gogreen') => 'rotateZoomIn',
                    ),
                    'description' => esc_html__('Select the hover effect for image.', 'gogreen'),
                    'dependency' => array(
		                'element' => 'gallery_type',
		                'value' => array('grid', 'grid-space', 'masonry')
		            )
                ),
                array(
                    'param_name' => 'visible_items',
                    'type' => 'dropdown',
                    'heading' => esc_html__('Visible Items', 'gogreen'),                    
                    'value' => array('auto', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'),
                    'std' => '3',
                    'description' => esc_html__('The maximum amount of items displayed at a time.', 'gogreen'),
                    'dependency' => array(
                        'element' => 'gallery_type',
                        'value' => array('slider')
                    )
                ),
                array(
                    'param_name' => 'transition',
                    'type' => 'dropdown',
                    'heading' => esc_html__('Transition', 'gogreen'),                    
                    'value' => array(
                        esc_html__('Slide', 'gogreen') => '', 
                        esc_html__('Fade', 'gogreen') => 'fade', 
                    ),
                    'description' => esc_html__('The maximum amount of items displayed at a time.', 'gogreen'),
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
                    'dependency' => array(
	                    'element' => 'gallery_type',
	                    'value' => array('slider')
                    )
                ),
                array(
                    'param_name' => 'show_pagination',
                    'type' => 'checkbox',
                    'heading' => esc_html__('Show Pagination', 'gogreen'),                    
                    'description' => esc_html__('Show pagination.', 'gogreen'),
                    'dependency' => array(
	                    'element' => 'gallery_type',
	                    'value' => array('slider')
                    )
                ),
                array(
                    'param_name' => 'auto_play',
                    'type' => 'checkbox',
                    'heading' => esc_html__('Auto Play', 'gogreen'),                    
                    'description' => esc_html__('Auto play slide.', 'gogreen'),
                    'dependency' => array(
	                    'element' => 'gallery_type',
	                    'value' => array('slider')
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
                    'param_name' => 'loop',
                    'type' => 'checkbox',
                    'heading' => esc_html__('Loop', 'gogreen'),                    
                    'description' => esc_html__('Inifnity loop. Duplicate last and first items to get loop illusion.', 'gogreen'),
                    'dependency' => array(
	                    'element' => 'gallery_type',
	                    'value' => array('slider')
                    )
                ),
                array(
                    'param_name' => 'animation',
                    'type' => 'wyde_animation',
                    'heading' => __('Animation', 'gogreen'),                        
                    'description' => __('Select a CSS3 Animation that applies to this element.', 'gogreen')
                ),
                array(
                    'param_name' => 'animation_delay',
                    'type' => 'textfield',
                    'heading' => __('Animation Delay', 'gogreen'),                        
                    'description' => __('Defines when the animation will start (in seconds). Example: 0.5, 1, 2, ...', 'gogreen'),
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