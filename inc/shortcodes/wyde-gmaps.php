<?php
/***************************************** 
/* GOOGLE MAPS
/*****************************************/
vc_map( array(
    'name' => __('Google Maps', 'gogreen'),
    'description' => __('Google Maps block.', 'gogreen'),
    'base' => 'wyde_gmaps',
    'controls' => 'full',
    'icon' =>  'wyde-icon gmaps-icon', 
    'weight'    => 900,
    'category' => __('Wyde', 'gogreen'),
    'params' => array(
		array(
			'param_name' => 'values',
			'type' => 'param_group',
			'heading' => __( 'Addresses', 'gogreen' ),
			'description' => __( 'Enter addresses for map.', 'gogreen' ),
			'params' => array(
				array(
					'param_name' => 'address',
					'type' => 'textarea',
					'heading' => __( 'Address', 'gogreen' ),					
					'description' => __( 'Enter text to display in the Info Window.', 'gogreen' ),		                    
				),
				array(
					'param_name' => 'location',
					'type' => 'textfield',
					'heading' => __( 'Coordinates (optional)', 'gogreen' ),					
					'description' => __( 'If you have the Google Maps coordinates, put it here to set the position of the marker on the map.', 'gogreen' ),		                    
				)
			),
			'callbacks' => array(
				'after_add' => 'wyde_gmaps_addresses_added',
				'after_delete' => 'wyde_gmaps_addresses_deleted',
			)
        ),
        array(
        	'param_name' => 'gmaps',
	        'type' => 'wyde_gmaps',
	        'heading' => 'Maps',			        
	        'description' => __('Drag & drop markers to set your locations, map type and zoom level settings will also be used.', 'gogreen')
        ),
        array(
        	'param_name' => 'height',
	        'type' => 'textfield',
	        'heading' => __( 'Map Height', 'gogreen' ),			        
	        'admin_label' => true,
            'value' => '300',
	        'description' => __( 'Enter map height in pixels. Example: 300.', 'gogreen' )
        ),
        array( 
			'param_name' => 'color', 
        	'type' => 'colorpicker',
            'heading' => __('Map Color', 'gogreen'),                    
            'description' => __('Select map background color.', 'gogreen'),
        ),
        array(
        	'param_name' => 'icon',
	        'type' => 'attach_image',
	        'heading' => __( 'Marker Icon', 'gogreen' ),			        
	        'description' => __( 'To use your own marker icon, select image from media library.', 'gogreen' )
        ),
        array(
            'param_name' => 'show_info',
            'type' => 'checkbox',
            'heading' => __('Show Info Window', 'gogreen'),              
            'description' => __('Automatically show the info window immediately after the map has loaded.', 'gogreen')                
        ),
        array(
        	'param_name' => 'el_class',
	        'type' => 'textfield',
	        'heading' => __( 'Extra CSS Class', 'gogreen' ),			        
	        'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'gogreen' )
        ),
    )
));