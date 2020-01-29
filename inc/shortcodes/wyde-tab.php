<?php
/***************************************** 
/* TAB
/*****************************************/
$icon_picker_options = apply_filters('wyde_iconpicker_options', array());

vc_map( array(
	'name' => esc_html__( 'Tab', 'gogreen' ),
	'base' => 'wyde_tab',
	'allowed_container_element' => 'vc_row',
	'is_container' => true,
	'content_element' => false,
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
		    'heading' => esc_html__( 'Title', 'gogreen' ),			    
		    'description' => esc_html__( 'Tab title.', 'gogreen' ),
	    ),
	    array(
	    	'param_name' => "tab_id",
		    'type' => 'tab_id',
		    'heading' => esc_html__( 'Tab ID', 'gogreen' ),			   
	    ),

	),
	'js_view' => 'WydeTabView'
) );