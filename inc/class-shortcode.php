<?php

if( function_exists('wyde_include_shortcode') ) {
    wyde_include_shortcode();
}

if( ! class_exists( 'GoGreen_Shortcode' ) ) {

    class GoGreen_Shortcode{

    	function __construct() {

    		if( !class_exists('Wyde_Core') ){
    			/* Remove all filters to remove the Visual Composer errors. */
    			remove_all_filters( 'the_content' );

    			/* Display the error message "Wyde Core plugin is required" */
    			//add_filter( 'the_content', array($this, 'shortcode_error') );

    			/* Remove shortcodes from content, display the plain content instead */
    			add_filter( 'the_content', array($this, 'remove_shortcodes_from_content') );
    			return;
    		}

            add_action('wp_enqueue_scripts', array($this, 'load_scripts' ) );

    		/* Visual Composer hooks */
    		add_action( 'vc_before_init', array($this, 'init_shortcodes') );
            add_filter( 'vc_load_default_templates', array($this, 'load_templates'), 100 );        

            add_filter( 'vc_iconpicker-type-linecons', array($this, 'get_linecons_icons') );
            add_filter( 'vc_iconpicker-type-bigmug_line', array($this, 'get_bigmug_line_icons') );
            add_filter( 'vc_iconpicker-type-simple_line', array($this, 'get_simple_line_icons') );
            add_filter( 'vc_iconpicker-type-farming', array($this, 'get_farming_icons') );

            remove_filter( 'vc_iconpicker-type-typicons', 'vc_iconpicker_type_typicons' );

            /* Wyde Core hooks */
            add_action( 'wyde_load_shortcodes', array($this, 'load_shortcodes') );
    		add_action( 'wyde_update_plugins_shortcodes', array($this, 'update_plugins_shortcodes') );
            add_filter( 'wyde_portfolio_masonry_layout', array($this, 'get_portfolio_masonry_layout') );
            add_filter( 'wyde_gallery_masonry_layout', array($this, 'get_gallery_masonry_layout') );
            add_filter( 'wyde_google_maps_api_key', array($this, 'get_google_maps_api_key') );
            add_filter( 'wyde_iconpicker_options', array($this, 'get_iconpicker_options'), 100 ); 
            
    	}

    	function GoGreen_Shortcode(){
    		$this->__construct();
    	}    	

    	function remove_shortcodes_from_content( $content ){

    		$pattern = get_shortcode_regex();
		    $content = preg_replace_callback("/$pattern/s", 'gogreen_remove_shortcode', $content);
		    $content = str_replace(']]>', ']]&gt;', $content);

    		$content = 	'<div class="w-section"><div class="container"><div class="row"><div class="col col-12">'
			    		.$content
			    		.'</div></div></div></div>';

    		return $content;
    	}

    	function shortcode_error( $content ){
    		$content = '<div class="w-section"><div class="container"><div class="row"><div class="col col-12">'
    		.'<div class="page-error-wrapper">'
    		.'<h4 class="page-error-title">'. esc_html__('Wyde Core plugin is required!', 'gogreen') .'</h4>'
    		.'<h6 class="page-error-text">'. esc_html__('This theme requires Wyde Core plugin for rendering shortcodes and content.', 'gogreen') .'</h6>'
    		.'</div>'
    		.'</div></div></div></div>';
    		return $content;
    	}

        public function load_scripts(){
            // Shortcodes style
            wp_enqueue_style('gogreen-shortcodes', get_template_directory_uri(). '/css/shortcodes.css', null, '1.1.2'); 

            // Shortcodes script
            wp_enqueue_script('gogreen-shortcodes', get_template_directory_uri() . '/js/shortcodes.js', array('wyde-core'), '1.1.2', true);
        }

    	public function load_templates($templates){
    		return $templates;
    	}

    	public function init_shortcodes(){
			//Set Shortcodes Templates Directory
            vc_set_shortcodes_templates_dir( get_template_directory() .'/templates/shortcodes' );
    	}

    	/* Find and include all shortcodes within shortcodes folder */
	    public function load_shortcodes() {

		    $files = glob( get_template_directory(). '/inc/shortcodes/*.php' );
            
            if( is_array($files) ){
    		    foreach( $files as $filename ) {
    			    include_once( $filename );
    		    }
            }

		    $this->update_shortcodes();

	    }

		function update_shortcodes(){	

			
			vc_remove_element('wyde_slide');
			vc_remove_element('wyde_slider');

			vc_remove_element('wyde_instagram');
            vc_remove_element('wyde_twitter');

            /***************************************** 
            /* Row
            /*****************************************/
            vc_map( array(
                'name' => esc_html__( 'Row', 'gogreen' ),
                'base' => 'vc_row',
                'weight'    => 1001,
                'is_container' => true,
                'icon' => 'icon-wpb-row',
                'show_settings_on_create' => false,
                'category' => esc_html__( 'Content', 'gogreen' ),
                'description' => esc_html__( 'Place content elements inside row', 'gogreen' ),
                'params' => array(
                    array(
                        'param_name' => 'row_style',
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Content Width', 'gogreen' ),                      
                        'value' => array(
                            esc_html__( 'Default', 'gogreen' ) => '',
                            esc_html__( 'Full Width', 'gogreen' ) => 'full-width',
                            esc_html__( 'Full Height', 'gogreen' ) => 'full-height',
                            esc_html__( 'Full Screen', 'gogreen' ) => 'full-screen',
                        ),
                        'description' => esc_html__( 'Select row style.', 'gogreen' )
                    ),
                    array(
                        'param_name' => 'overlap',
                        'type' => 'dropdown',
                        'heading' => esc_html__('Overlap', 'gogreen'),                      
                        'value' => array(
                            esc_html__('None', 'gogreen') => '', 
                            esc_html__('Left', 'gogreen') => 'left', 
                            esc_html__('Right', 'gogreen') => 'right', 
                            esc_html__('Top', 'gogreen') => 'top',
                            esc_html__('Bottom', 'gogreen') => 'bottom', 
                        ),
                        'description' => esc_html__('Select the direction of another object that will be overlapped.', 'gogreen')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Overlap Distance', 'gogreen'),
                        'param_name' => 'overlap_distance',
                        'value' => '50px',
                        'description' => esc_html__('Set the distance you want an object to be offset from the current position.', 'gogreen'),
                        'dependency' => array(
                            'element' => 'overlap',
                            'not_empty' => true
                        )
                    ),
                    array(
                        'param_name' => 'overlap_index',
                        'type' => 'dropdown',
                        'heading' => esc_html__('Stack Order', 'gogreen'),                      
                        'value' => array(
                            '',
                            50,
                            100,
                            150,
                            200,
                            250,
                            300,
                            400,
                            450,
                            500,                           
                        ),
                        'description' => esc_html__('Defines a z-index property that specifies the stack order of an element.', 'gogreen'),       
                    ),
                    array(
                        'param_name' => 'text_style',
                        'type' => 'dropdown',                      
                        'heading' => esc_html__('Text Style', 'gogreen'),                       
                        'value' => array(
                            esc_html__('Dark', 'gogreen') => '',
                            esc_html__('Light', 'gogreen') => 'light',
                        ),
                        'description' => esc_html__('Apply text style.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'equal_height',
                        'type' => 'checkbox',                       
                        'description' => esc_html__( 'Columns in this row will be set to equal height.', 'gogreen' ),
                        'value' => array( esc_html__( 'Equal Height', 'gogreen' ) => 'true' )
                    ),
                    array(
                        'param_name' => 'vertical_align',
                        'type' => 'dropdown',                       
                        'heading' => esc_html__('Content Vertical Alignment', 'gogreen'),                       
                        'value' => array(
                            esc_html__('Top', 'gogreen') => '', 
                            esc_html__('Middle', 'gogreen') =>'middle', 
                            esc_html__('Bottom', 'gogreen') => 'bottom', 
                        ),
                        'description' => esc_html__('Select content vertical alignment.', 'gogreen'),                      
                    ),
                    array(
                        'param_name' => 'padding_size',
                        'type' => 'dropdown',                      
                        'heading' => esc_html__('Vertical Padding Size', 'gogreen'),                       
                        'value' => array(
                             esc_html__('Default', 'gogreen') => '', 
                             esc_html__('No Padding', 'gogreen') => 'no-padding', 
                             esc_html__('Small', 'gogreen') => 's-padding', 
                             esc_html__('Medium', 'gogreen') => 'm-padding', 
                             esc_html__('Large', 'gogreen') => 'l-padding', 
                             esc_html__('Extra Large', 'gogreen') => 'xl-padding'
                        ),
                        'description' => esc_html__('Select vertical padding size.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'el_id',
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Row ID', 'gogreen' ),                     
                        'description' => esc_html__( 'Enter row ID (Note: make sure it is unique and valid).', 'gogreen' )
                    ),
                    array(
                        'param_name' => 'el_class',
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Extra CSS Class', 'gogreen' ),                        
                        'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'gogreen' )
                    ),
                    array(
                        'param_name' => 'background_color',
                        'type' => 'colorpicker',
                        'heading' => esc_html__( 'Background Color', 'gogreen' ),                       
                        'description' => esc_html__( 'Select background color.', 'gogreen' ),                       
                        'group' => esc_html__( 'Background', 'gogreen' ),
                    ),
                    array(
                        'param_name' => 'background_image',
                        'type' => 'attach_image',
                        'heading' => esc_html__( 'Background Image', 'gogreen' ),                       
                        'description' => esc_html__( 'Select background image.', 'gogreen' ),
                        'group' => esc_html__( 'Background', 'gogreen' ),
                        'dependency' => array(
                            'callback' => 'wyde_row_background_image_callback',
                        )
                    ),
                    array(
                        'param_name' => 'bg_image_url', 
                        'type' => 'hidden',                                         
                        'group' => esc_html__( 'Background', 'gogreen' ),
                    ),
                    array(
                        'param_name' => 'background_style',
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Background Style', 'gogreen' ),                       
                        'value' => array(
                            esc_html__( 'Default', 'gogreen' ) => '',
                            esc_html__( 'Cover', 'gogreen' ) => 'cover',
                            esc_html__( 'Contain', 'gogreen' ) => 'contain',
                            esc_html__( 'No Repeat', 'gogreen' ) => 'no-repeat',
                            esc_html__( 'Repeat', 'gogreen' ) => 'repeat',
                        ),
                        'description' => esc_html__( 'Select background style.', 'gogreen' ),
                        'dependency' => array(
                            'element' => 'background_image',
                            'not_empty' => true,
                        ),
                        'group' => esc_html__( 'Background', 'gogreen' ),

                    ),
                    array(
                        'param_name' => 'background_position',
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Background Position', 'gogreen' ),                       
                        'value' => array(
                            esc_html__( 'Center Top', 'gogreen' ) => 'center top',
                            esc_html__( 'Center Center', 'gogreen' ) => 'center center',
                            esc_html__( 'Center Bottom', 'gogreen' ) => 'center bottom',
                            esc_html__( 'Left Top', 'gogreen' ) => 'left top',
                            esc_html__( 'Left Center', 'gogreen' ) => 'left center',
                            esc_html__( 'Left Bottom', 'gogreen' ) => 'left bottom',
                            esc_html__( 'Right Top', 'gogreen' ) => 'right top',
                            esc_html__( 'Right Center', 'gogreen' ) => 'right center',
                            esc_html__( 'Right Bottom', 'gogreen' ) => 'right bottom',                            
                        ),
                        'std' => 'center center',
                        'description' => esc_html__( 'Set the starting position of a background image.', 'gogreen' ),                        
                        'group' => esc_html__( 'Background', 'gogreen' ),
                        'dependency' => array(
                            'element' => 'background_image',
                            'not_empty' => true,                            
                        )

                    ),
                    array(
                        'param_name' => 'background_overlay',
                        'type' => 'dropdown',                       
                        'heading' => esc_html__('Background Overlay', 'gogreen'),                       
                        'value' => array(
                            esc_html__('None', 'gogreen') => '',
                            esc_html__('Color Overlay', 'gogreen') => 'color',
                        ),
                        'description' => esc_html__('Apply an overlay to the background.', 'gogreen'),
                        'group' => esc_html__( 'Background', 'gogreen' ),
                        'dependency' => array(
                            'element' => 'background_image',
                            'not_empty' => true,
                        ),
                        
                    ),
                    array(
                        'param_name' => 'overlay_color',
                        'type' => 'colorpicker',
                        'heading' => esc_html__( 'Background Overlay Color', 'gogreen' ),                       
                        'description' => esc_html__( 'Select background overlay color.', 'gogreen' ),
                        'value' => '#211F1E',
                        'group' => esc_html__( 'Background', 'gogreen' ),
                        'dependency' => array(
                            'element' => 'background_overlay',
                            'not_empty' => true
                        ),
                        
                    ),
                    array(
                        'param_name' => 'overlay_opacity',
                        'type' => 'dropdown',
                        'heading' => esc_html__('Background Overlay Opacity', 'gogreen'),                       
                        'value' => array(
                            esc_html__('Default', 'gogreen') => '', 
                            '0.1' => '0.1', 
                            '0.2' => '0.2', 
                            '0.3' => '0.3', 
                            '0.4' => '0.4', 
                            '0.5' => '0.5', 
                            '0.6' => '0.6', 
                            '0.7' => '0.7', 
                            '0.8' => '0.8', 
                            '0.9' => '0.9', 
                        ),
                        'description' => esc_html__('Select background overlay opacity.', 'gogreen'),
                        'group' => esc_html__( 'Background', 'gogreen' ),
                        'dependency' => array(
                            'element' => 'background_overlay',
                            'not_empty' => true
                        ),
                        
                    ),
                    array(
                        'param_name' => 'parallax',
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Parallax', 'gogreen' ),                       
                        'value' => array(
                            esc_html__( 'None', 'gogreen' ) => '',
                            esc_html__( 'Simple Parallax', 'gogreen' ) => 'parallax',
                            esc_html__( 'Reverse Parallax', 'gogreen' ) => 'reverse',
                        ),
                        'description' => esc_html__( 'Select parallax background type.', 'gogreen' ),
                        'group' => esc_html__( 'Background', 'gogreen' ),
                        'dependency' => array(
                            'element' => 'background_image',
                            'not_empty' => true,
                        ),
                        

                    ),
                    array(
                        'param_name' => 'css',
                        'type' => 'css_editor',
                        'heading' => esc_html__( 'CSS', 'gogreen' ),                        
                        'group' => esc_html__( 'Design Options', 'gogreen' )
                    )
                ),
                'js_view' => 'WydeRowView'
            ) );


            /***************************************** 
            /* Row Inner
            /*****************************************/
            vc_map( array(
                'name' => esc_html__( 'Row', 'gogreen' ), //Inner Row
                'base' => 'vc_row_inner',
                'content_element' => false,
                'is_container' => true,
                'icon' => 'icon-wpb-row',
                'weight' => 1000,
                'show_settings_on_create' => false,
                'description' => esc_html__( 'Place content elements inside the row', 'gogreen' ),
                'params' => array(
                    array(
                        'param_name' => 'overlap',
                        'type' => 'dropdown',
                        'heading' => esc_html__('Overlap', 'gogreen'),                      
                        'value' => array(
                            esc_html__('None', 'gogreen') => '', 
                            esc_html__('Left', 'gogreen') => 'left', 
                            esc_html__('Right', 'gogreen') => 'right', 
                            esc_html__('Top', 'gogreen') => 'top',
                            esc_html__('Bottom', 'gogreen') => 'bottom', 
                        ),
                        'description' => esc_html__('Select the direction of another object that will be overlapped.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'overlap_distance',
                        'type' => 'textfield',
                        'heading' => esc_html__('Overlap Distance', 'gogreen'),                     
                        'value' => '50px',
                        'description' => esc_html__('Set the distance you want an object to be offset from the current position.', 'gogreen'),
                        'dependency' => array(
                            'element' => 'overlap',
                            'not_empty' => true
                        )
                    ),
                    array(
                        'param_name' => 'overlap_index',
                        'type' => 'dropdown',
                        'heading' => esc_html__('Stack Order', 'gogreen'),                      
                        'value' => array(
                            '',
                            50,
                            100,
                            150,
                            200,
                            250,
                            300,
                            400,
                            450,
                            500,                           
                        ),
                        'description' => esc_html__('Defines a z-index property that specifies the stack order of an element.', 'gogreen'),        
                    ),
                    array(
                        'param_name' => 'text_style',
                        'type' => 'dropdown',
                        'heading' => esc_html__('Text Style', 'gogreen'),                        
                        'value' => array(
                            esc_html__('Dark', 'gogreen') => '',
                            esc_html__('Light', 'gogreen') => 'light',
                        ),
                        'description' => esc_html__('Apply text style.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'equal_height',
                        'type' => 'checkbox',                       
                        'description' => esc_html__( 'Columns in this row will be set to equal height.', 'gogreen' ),
                        'value' => array( esc_html__( 'Equal Height', 'gogreen' ) => 'true' )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Content Vertical Alignment', 'gogreen'),
                        'param_name' => 'vertical_align',
                        'value' => array(
                            esc_html__('Top', 'gogreen') => '', 
                            esc_html__('Middle', 'gogreen') =>'middle', 
                            esc_html__('Bottom', 'gogreen') => 'bottom', 
                        ),
                        'description' => esc_html__('Select content vertical alignment.', 'gogreen'),                       
                    ),
                    array(
                        'param_name' => 'padding_size',
                        'type' => 'dropdown',                        
                        'heading' => esc_html__('Vertical Padding Size', 'gogreen'),                        
                        'value' => array(
                             esc_html__('Default', 'gogreen') => '', 
                             esc_html__('No Padding', 'gogreen') => 'no-padding', 
                             esc_html__('Small', 'gogreen') => 's-padding', 
                             esc_html__('Medium', 'gogreen') => 'm-padding', 
                             esc_html__('Large', 'gogreen') => 'l-padding', 
                             esc_html__('Extra Large', 'gogreen') => 'xl-padding'
                        ),
                        'description' => esc_html__('Select vertical padding size.', 'gogreen')
                    ),
                    array(
                        'param_name' => 'el_id',
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Row ID', 'gogreen' ),                     
                        'description' => sprintf( __( 'Enter row ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">W3C specification</a>).', 'gogreen' ), 'http://www.w3schools.com/tags/att_global_id.asp' )
                    ),
                    array(
                        'param_name' => 'disable_element',
                        'type' => 'checkbox',                       
                        'description' => esc_html__( 'Hide the row on the public side of your website. You can switch it back any time.', 'gogreen' ),
                        'value' => array( esc_html__( 'Disable Row', 'gogreen' ) => 'yes' ),
                    ),
                    array(
                        'param_name' => 'el_class',
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Extra CSS Class', 'gogreen' ),                        
                        'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'gogreen' )
                    ),
                    array(
                        'param_name' => 'background_color',
                        'type' => 'colorpicker',
                        'heading' => esc_html__( 'Background Color', 'gogreen' ),                       
                        'description' => esc_html__( 'Select background color.', 'gogreen' ),                       
                        'group' => esc_html__( 'Background', 'gogreen' ),
                    ),
                    array(
                        'param_name' => 'background_image',
                        'type' => 'attach_image',
                        'heading' => esc_html__( 'Background Image', 'gogreen' ),                       
                        'description' => esc_html__( 'Select background image.', 'gogreen' ),
                        'group' => esc_html__( 'Background', 'gogreen' ),
                        'dependency' => array(
                            'callback' => 'wyde_row_background_image_callback',
                        )
                    ),
                    array(
                        'param_name' => 'bg_image_url', 
                        'type' => 'hidden',                                         
                        'group' => esc_html__( 'Background', 'gogreen' ),
                    ),
                    array(
                        'param_name' => 'background_style',
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Background Style', 'gogreen' ),                       
                        'value' => array(
                            esc_html__( 'Default', 'gogreen' ) => '',
                            esc_html__( 'Cover', 'gogreen' ) => 'cover',
                            esc_html__( 'Contain', 'gogreen' ) => 'contain',
                            esc_html__( 'No Repeat', 'gogreen' ) => 'no-repeat',
                            esc_html__( 'Repeat', 'gogreen' ) => 'repeat',
                        ),
                        'description' => esc_html__( 'Select background style.', 'gogreen' ),
                        'dependency' => array(
                            'element' => 'background_image',
                            'not_empty' => true,
                        ),
                        'group' => esc_html__( 'Background', 'gogreen' ),

                    ),
                    array(
                        'param_name' => 'background_position',
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Background Position', 'gogreen' ),                       
                        'value' => array(
                            esc_html__( 'Center Top', 'gogreen' ) => 'center top',
                            esc_html__( 'Center Center', 'gogreen' ) => 'center center',
                            esc_html__( 'Center Bottom', 'gogreen' ) => 'center bottom',
                            esc_html__( 'Left Top', 'gogreen' ) => 'left top',
                            esc_html__( 'Left Center', 'gogreen' ) => 'left center',
                            esc_html__( 'Left Bottom', 'gogreen' ) => 'left bottom',
                            esc_html__( 'Right Top', 'gogreen' ) => 'right top',
                            esc_html__( 'Right Center', 'gogreen' ) => 'right center',
                            esc_html__( 'Right Bottom', 'gogreen' ) => 'right bottom',                            
                        ),
                        'std' => 'center center',
                        'description' => esc_html__( 'Set the starting position of a background image.', 'gogreen' ),                        
                        'group' => esc_html__( 'Background', 'gogreen' ),
                        'dependency' => array(
                            'element' => 'background_image',
                            'not_empty' => true,                            
                        )

                    ),
                    array(
                        'param_name' => 'background_overlay',
                        'type' => 'dropdown',                       
                        'heading' => esc_html__('Background Overlay', 'gogreen'),                       
                        'value' => array(
                            esc_html__('None', 'gogreen') => '',
                            esc_html__('Color Overlay', 'gogreen') => 'color',
                        ),
                        'description' => esc_html__('Apply an overlay to the background.', 'gogreen'),
                        'group' => esc_html__( 'Background', 'gogreen' ),
                        'dependency' => array(
                            'element' => 'background_image',
                            'not_empty' => true,
                        ),
                        
                    ),
                    array(
                        'param_name' => 'overlay_color',
                        'type' => 'colorpicker',
                        'heading' => esc_html__( 'Background Overlay Color', 'gogreen' ),                       
                        'description' => esc_html__( 'Select background overlay color.', 'gogreen' ),
                        'value' => '#211F1E',
                        'group' => esc_html__( 'Background', 'gogreen' ),
                        'dependency' => array(
                            'element' => 'background_overlay',
                            'not_empty' => true
                        ),
                        
                    ),
                    array(
                        'param_name' => 'overlay_opacity',
                        'type' => 'dropdown',
                        'heading' => esc_html__('Background Overlay Opacity', 'gogreen'),                       
                        'value' => array(
                            esc_html__('Default', 'gogreen') => '', 
                            '0.1' => '0.1', 
                            '0.2' => '0.2', 
                            '0.3' => '0.3', 
                            '0.4' => '0.4', 
                            '0.5' => '0.5', 
                            '0.6' => '0.6', 
                            '0.7' => '0.7', 
                            '0.8' => '0.8', 
                            '0.9' => '0.9', 
                        ),
                        'description' => esc_html__('Select background overlay opacity.', 'gogreen'),
                        'group' => esc_html__( 'Background', 'gogreen' ),
                        'dependency' => array(
                            'element' => 'background_overlay',
                            'not_empty' => true
                        ),
                        
                    ),
                    array(
                        'param_name' => 'css',
                        'type' => 'css_editor',
                        'heading' => esc_html__( 'CSS', 'gogreen' ),                        
                        'group' => esc_html__( 'Design Options', 'gogreen' )
                    )
                ),
                'js_view' => 'WydeRowView'
            ) );

 	
 			/***************************************** 
            /* SLIDER REVOLUTION
            /*****************************************/
            vc_add_param( 'rev_slider_vc', array(
                'type' => 'dropdown',
                'heading' => __('Scroll Button', 'gogreen'),
                'param_name' => 'button_style',
                'weight'    => 10,
                'value' => array(
                    __('Hide', 'gogreen' ) => '',
                    __('Mouse Wheel', 'gogreen' ) => '1',
                    __('Arrow Down', 'gogreen' ) => '2',
                ),
                'description' => __('Select a scroll button at the bottom of slider.', 'gogreen'),
            ) );

            vc_add_param( 'rev_slider_vc', array(
                'type' => 'colorpicker',
                'heading' => __( 'Button Color', 'gogreen' ),
                'param_name' => 'color',
                'weight'    => 10,
                'description' => __( 'Select a button color.', 'gogreen' ),
                'dependency' => array(
                    'element' => 'button_style',
                    'not_empty' => true
                )
            ) );   
            

	        /***************************************** 
	        /* SINGLE IMAGE
	        /*****************************************/
	        vc_map( array(
	            'name' => esc_html__( 'Single Image', 'gogreen' ),
	            'base' => 'vc_single_image',
	            'icon' => 'wyde-icon image-icon',
	            'weight'    => 998,
	            'category' => esc_html__( 'Content', 'gogreen' ),
	            'description' => esc_html__( 'Insert an image', 'gogreen' ),
	            'params' => array(
	                array(
	                	'param_name' => 'image',
			            'type' => 'attach_image',
			            'heading' => esc_html__( 'Image', 'gogreen' ),			            
			            'description' => esc_html__( 'Select an image from media library.', 'gogreen' )
		            ),
		            array(
		            	'param_name' => 'img_size',
			            'type' => 'dropdown',
			            'heading' => esc_html__( 'Image Size', 'gogreen' ),			            
			            'value' => array(
				            esc_html__('Thumbnail (150x150)', 'gogreen' ) => 'thumbnail',
				            esc_html__('Medium (340x340)', 'gogreen' ) => 'gogreen-medium',
				            esc_html__('Large (640x640)', 'gogreen' ) => 'gogreen-large',
				            esc_html__('Extra Large (960x960)', 'gogreen' ) => 'gogreen-xlarge',
	                        esc_html__('Full Width (min-width: 1280px)', 'gogreen' ) => 'gogreen-fullwidth',
	                        esc_html__('Original', 'gogreen' ) => 'full',
			            ),
	                    'std'   => 'full',
			            'description' => esc_html__( 'Select image size.', 'gogreen' )
		            ),
		            array(
		            	'param_name' => 'style',
			            'type' => 'dropdown',
			            'heading' => esc_html__( 'Image Style', 'gogreen' ),			            
	                    'admin_label' => true,
			            'value' => array(
		                    esc_html__('Default', 'gogreen' ) => '',
		                    esc_html__('Border', 'gogreen' ) => 'border',
		                    esc_html__('Outline', 'gogreen' ) => 'outline',
		                    esc_html__('Shadow', 'gogreen' ) => 'shadow',
		                    esc_html__('Round', 'gogreen' ) => 'round',
		                    esc_html__('Round Border', 'gogreen' ) => 'round-border',
		                    esc_html__('Round Outline', 'gogreen' ) => 'round-outline', 
		                    esc_html__('Round Shadow', 'gogreen' ) => 'round-shadow', 
		                    esc_html__('Circle', 'gogreen' ) => 'circle', 
		                    esc_html__('Circle Border', 'gogreen' ) => 'circle-border', 
		                    esc_html__('Circle Outline', 'gogreen' ) => 'circle-outline',
		                    esc_html__('Circle Shadow', 'gogreen' ) => 'circle-shadow',
	                    ),
			            'description' => esc_html__( 'Select image alignment.', 'gogreen' )
		            ),
		            array(
		            	'param_name' => 'border_color',
			            'type' => 'colorpicker',
			            'heading' => esc_html__( 'Border Color', 'gogreen' ),			            
			            'description' => esc_html__( 'Select image border color.', 'gogreen' ),
			            'dependency' => array(
				            'element' => 'style',
				            'value' => array( 'border', 'outline', 'round-border', 'round-outline', 'circle-border', 'circle-outline' )
			            )
		            ),
		            array(
		            	'param_name' => 'alignment',
			            'type' => 'dropdown',
			            'heading' => esc_html__( 'Image Alignment', 'gogreen' ),			            
			            'value' => array(
				            esc_html__( 'Align Left', 'gogreen' ) => 'left',
				            esc_html__( 'Align Center', 'gogreen' ) => 'center',
	                        esc_html__( 'Align Right', 'gogreen' ) => 'right',
			            ),
			            'description' => esc_html__( 'Select image alignment.', 'gogreen' )
		            ),
					array(
						'param_name' => 'onclick',
						'type' => 'dropdown',
						'heading' => esc_html__( 'On Click Action', 'gogreen' ),						
						'value' => array(
							esc_html__( 'None', 'gogreen' ) => '',
							esc_html__( 'Link to large image', 'gogreen' ) => 'img_link_large',
							esc_html__( 'Open prettyPhoto', 'gogreen' ) => 'link_image',
							esc_html__( 'Open custom link', 'gogreen' ) => 'custom_link',
						),
						'description' => esc_html__( 'Select action for click action.', 'gogreen' ),
						'std' => '',
					),
					array(
						'param_name' => 'link',
						'type' => 'href',
						'heading' => esc_html__( 'Image Link', 'gogreen' ),						
						'description' => esc_html__( 'Set an image link.', 'gogreen' ),
						'dependency' => array(
							'element' => 'onclick',
							'value' => 'custom_link',
						),
					),
		            array(
		            	'param_name' => 'link_target',
			            'type' => 'dropdown',
			            'heading' => esc_html__( 'Link Target', 'gogreen' ),			            
			            'value' => array(
	                        esc_html__( 'Same window', 'gogreen' ) => '_self',
	                        esc_html__( 'New window', 'gogreen' ) => "_blank",
	                    ),
	                    'dependency' => array(
				            'element' => 'onclick',
				            'value' =>  array( 'custom_link', 'img_link_large' )
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
			            'heading' => esc_html__( 'Css', 'gogreen' ),			            
			            'group' => esc_html__( 'Design Options', 'gogreen' )
	                ) 
	            )
	        ) );    

	        
	        /***************************************** 
	        /* MESSAGE BOX
	        /*****************************************/
            $icon_picker_options = apply_filters('wyde_iconpicker_options', array());
            
	        vc_map( array(
	            'name' => esc_html__( 'Message Box', 'gogreen' ),
	            'base' => 'vc_message',
	            'icon' => 'icon-wpb-information-white',
	            'category' => esc_html__( 'Content', 'gogreen' ),
	            'description' => esc_html__( 'Notification box', 'gogreen' ),
	            'params' => array(
	                array(
	                    'type' => 'dropdown',
	                    'heading' => esc_html__( 'Style', 'gogreen' ),
	                    'param_name' => 'message_box_style',
	                    'value' => array(
	                        esc_html__('Standard', 'gogreen' ) => 'standard',
	                        esc_html__('Solid', 'gogreen' ) => 'solid',
	                        esc_html__('Solid icon', 'gogreen' ) => 'solid-icon',
	                        esc_html__('Outline', 'gogreen' ) => 'outline',
	                        esc_html__('3D', 'gogreen' ) => '3d',
	                    ),
	                    'description' => esc_html__( 'Select message box design style.', 'gogreen' )
	                ),
	                array(
	                    'type' => 'dropdown',
	                    'heading' => esc_html__( 'Shape', 'gogreen' ),
	                    'param_name' => 'style', // due to backward compatibility message_box_shape
	                    'std' => 'rounded',
	                    'value' => array(
	                        esc_html__( 'Square', 'gogreen' ) => 'square',
	                        esc_html__( 'Rounded', 'gogreen' ) => 'rounded',
	                        esc_html__( 'Round', 'gogreen' ) => 'round',
	                    ),
	                    'description' => esc_html__( 'Select message box shape.', 'gogreen' ),
	                ),
	                array(
	                    'type' => 'dropdown',
	                    'heading' => esc_html__( 'Color', 'gogreen' ),
	                    'param_name' => 'message_box_color',
	                    'value' => array(
	                        esc_html__( 'Informational', 'gogreen' ) => 'info',
	                        esc_html__( 'Warning', 'gogreen' ) => 'warning',
	                        esc_html__( 'Success', 'gogreen' ) => 'success',
	                        esc_html__( 'Error', 'gogreen' ) => "danger",
	                        esc_html__( 'Informational Classic', 'gogreen' ) => 'alert-info',
	                        esc_html__( 'Warning Classic', 'gogreen' ) => 'alert-warning',
	                        esc_html__( 'Success Classic', 'gogreen' ) => 'alert-success',
	                        esc_html__( 'Error Classic', 'gogreen' ) => "alert-danger",
	                        esc_html__( 'Custom', 'gogreen' ) => "cutom",
	                    ),
	                    'description' => esc_html__( 'Select message box color.', 'gogreen' ),
	                    'param_holder_class' => 'vc_message-type vc_colored-dropdown',
	                ),
	                array(
	                    'type' => 'colorpicker',
	                    'heading' => esc_html__( 'Custom Color', 'gogreen' ),
	                    'param_name' => 'color',
	                    'description' => esc_html__( 'Select message box color.', 'gogreen' ),
	                    'dependency' => array(
	                        'element' => 'message_box_color',
	                        'value' => array('custom')
	                    )
	                ),
	                $icon_picker_options[0],
	                $icon_picker_options[1],
	                $icon_picker_options[2],
	                $icon_picker_options[3],
	                $icon_picker_options[4],
	                $icon_picker_options[5],
	                array(
	                    'type' => 'textarea_html',
	                    'holder' => 'div',
	                    'class' => 'messagebox_text',
	                    'heading' => esc_html__( 'Message text', 'gogreen' ),
	                    'param_name' => 'content',
	                    'value' => esc_html__( '<p>I am message box. Click edit button to change this text.</p>', 'gogreen' )
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
	                    'type' => 'textfield',
	                    'heading' => esc_html__( 'Extra CSS Class', 'gogreen' ),
	                    'param_name' => 'el_class',
	                    'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'gogreen' )
	                ),
	                array(
	                    'type' => 'css_editor',
	                    'heading' => esc_html__( 'CSS', 'gogreen' ),
	                    'param_name' => 'css',
	                    'group' => esc_html__( 'Design Options', 'gogreen' )
	                ),
	            ),
	            'js_view' => 'VcMessageView_Backend'
	        ) );
	        
		}

		public function update_plugins_shortcodes(){            
             // Update plugins
        }

        public function get_google_maps_api_key(){
        	return gogreen_get_option('google_maps_api_key');
        }

        public function get_iconpicker_options( $options ){
        	$options = array(
	            array(
	                'type' => 'dropdown',
	                'heading' => esc_html__( 'Icon Set', 'gogreen' ),
	                'param_name' => 'icon_set',
	                'value' => array(
		                'Font Awesome' => '',
		                'Linecons' => 'linecons',
	                    'Big Mug Line' => 'bigmug_line',
	                    'Simple Line' => 'simple_line',
	                    'Farming' => 'farming',
	                ),	                
	                'description' => esc_html__('Select an icon set.', 'gogreen')
	            ),
	            array(
	                'type' => 'iconpicker',
	                'heading' => esc_html__( 'Icon', 'gogreen' ),
	                'param_name' => 'icon',
	                'value' => '', 
	                'settings' => array(
		                'emptyIcon' => true, 
		                'iconsPerPage' => 4000, 
	                ),
	                'description' => esc_html__('Select an icon.', 'gogreen'),
	                'dependency' => array(
		                'element' => 'icon_set',
		                'is_empty' => true,
	                ),
	            ),
	            array(
	                'type' => 'iconpicker',
	                'heading' => esc_html__( 'Icon', 'gogreen' ),
	                'param_name' => 'icon_linecons',
	                'value' => '',
	                'settings' => array(
	                    'emptyIcon' => true, 
	                    'type' => 'linecons',
	                    'iconsPerPage' => 4000,
	                ),
	                'description' => esc_html__('Select an icon.', 'gogreen'),
	                'dependency' => array(
	                    'element' => 'icon_set',
	                    'value' => 'linecons',
	                ),
	            ),
	            array(
	                'type' => 'iconpicker',
	                'heading' => esc_html__( 'Icon', 'gogreen' ),
	                'param_name' => 'icon_bigmug_line',
	                'value' => '',
	                'settings' => array(
	                    'emptyIcon' => true, 
	                    'type' => 'bigmug_line',
	                    'iconsPerPage' => 4000,
	                ),
	                'description' => esc_html__('Select an icon.', 'gogreen'),
	                'dependency' => array(
	                    'element' => 'icon_set',
	                    'value' => 'bigmug_line',
	                ),
	            ),
	            array(
	                'type' => 'iconpicker',
	                'heading' => esc_html__( 'Icon', 'gogreen' ),
	                'param_name' => 'icon_simple_line',
	                'value' => '',
	                'settings' => array(
	                    'emptyIcon' => true, 
	                    'type' => 'simple_line',
	                    'iconsPerPage' => 4000,
	                ),
	                'description' => esc_html__('Select an icon.', 'gogreen'),
	                'dependency' => array(
	                    'element' => 'icon_set',
	                    'value' => 'simple_line',
	                ),
	            ),
	            array(
	                'type' => 'iconpicker',
	                'heading' => esc_html__( 'Icon', 'gogreen' ),
	                'param_name' => 'icon_farming',
	                'value' => '',
	                'settings' => array(
	                    'emptyIcon' => true, 
	                    'type' => 'farming',
	                    'iconsPerPage' => 4000,
	                ),
	                'description' => esc_html__('Select an icon.', 'gogreen'),
	                'dependency' => array(
	                    'element' => 'icon_set',
	                    'value' => 'farming',
	                ),
	            )
                        

            );

			return $options;
        }

        public function get_linecons_icons( $icons ){
        
            $icons = array(
		        array( "linecons-heart" => "Heart" ),
		        array( "linecons-cloud" => "Cloud" ),
		        array( "linecons-star" => "Star" ),
		        array( "linecons-tv" => "Tv" ),
		        array( "linecons-sound" => "Sound" ),
		        array( "linecons-video" => "Video" ),
		        array( "linecons-trash" => "Trash" ),
		        array( "linecons-user" => "User" ),
		        array( "linecons-key" => "Key" ),
		        array( "linecons-search" => "Search" ),
		        array( "linecons-settings" => "Settings" ),
		        array( "linecons-camera" => "Camera" ),
		        array( "linecons-tag" => "Tag" ),
		        array( "linecons-lock" => "Lock" ),
		        array( "linecons-bulb" => "Bulb" ),
		        array( "linecons-pen" => "Pen" ),
		        array( "linecons-diamond" => "Diamond" ),
		        array( "linecons-display" => "Display" ),
		        array( "linecons-location" => "Location" ),
		        array( "linecons-eye" => "Eye" ),
		        array( "linecons-bubble" => "Bubble" ),
		        array( "linecons-stack" => "Stack" ),
		        array( "linecons-cup" => "Cup" ),
		        array( "linecons-phone" => "Phone" ),
		        array( "linecons-news" => "News" ),
		        array( "linecons-mail" => "Mail" ),
		        array( "linecons-like" => "Like" ),
		        array( "linecons-photo" => "Photo" ),
		        array( "linecons-note" => "Note" ),
		        array( "linecons-clock" => "Clock" ),
		        array( "linecons-paperplane" => "Paperplane" ),
		        array( "linecons-params" => "Params" ),
		        array( "linecons-banknote" => "Banknote" ),
		        array( "linecons-data" => "Data" ),
		        array( "linecons-music" => "Music" ),
		        array( "linecons-megaphone" => "Megaphone" ),
		        array( "linecons-study" => "Study" ),
		        array( "linecons-lab" => "Lab" ),
		        array( "linecons-food" => "Food" ),
		        array( "linecons-t-shirt" => "T Shirt" ),
		        array( "linecons-fire" => "Fire" ),
		        array( "linecons-clip" => "Clip" ),
		        array( "linecons-shop" => "Shop" ),
		        array( "linecons-calendar" => "Calendar" ),
		        array( "linecons-wallet" => "Wallet" ),
		        array( "linecons-vynil" => "Vynil" ),
		        array( "linecons-truck" => "Truck" ),
		        array( "linecons-world" => "World" ),
	        );

            return $icons;
        }

        public function get_bigmug_line_icons( $icons ){
            $icons = array(
		        array( "bigmug-line-plus" => "Plus" ),
                array( "bigmug-line-plus-circle" => "Plus-circle" ),
                array( "bigmug-line-plus-square" => "Plus-square" ),
                array( "bigmug-line-airplane" => "airplane" ),
                array( "bigmug-line-alarm" => "Alarm" ),
                array( "bigmug-line-collapse1" => "Collapse1" ),
                array( "bigmug-line-attach1" => "Attach1" ),
                array( "bigmug-line-attach2" => "Attach2" ),
                array( "bigmug-line-volumn-off" => "Volumn-off" ),
                array( "bigmug-line-arrow-circle-left" => "Arrow-circle-left" ),
                array( "bigmug-line-arrow-square-left" => "Arrow-square-square" ),
                array( "bigmug-line-mappin" => "Map-pin" ),
                array( "bigmug-line-book" => "Book" ),
                array( "bigmug-line-bookmark" => "Bookmark" ),
                array( "bigmug-line-bottle" => "Bottle" ),
                array( "bigmug-line-th" => "Thumbnails" ),
                array( "bigmug-line-gamepad" => "Gamepad" ),
                array( "bigmug-line-tablet" => "Tablet" ),
                array( "bigmug-line-mobile" => "Mobile" ),
                array( "bigmug-line-align-center" => "Align-center" ),
                array( "bigmug-line-chat1" => "Chat1" ),
                array( "bigmug-line-chat2" => "Chat2" ),
                array( "bigmug-line-checkmark" => "Checkmark" ),
                array( "bigmug-line-checkmark-square" => "Checkmark-square" ),
                array( "bigmug-line-checkmark-circle" => "Checkmark-circle" ),
                array( "bigmug-line-certificate" => "Certificate" ),
                array( "bigmug-line-target" => "Target" ),
                array( "bigmug-line-pie-chart" => "Pie-chart" ),
                array( "bigmug-line-refresh" => "Refresh" ),
                array( "bigmug-line-clipboard" => "Clipboard" ),
                array( "bigmug-line-cross-circle" => "Cross-circle" ),
                array( "bigmug-line-cloud" => "Cloud" ),
                array( "bigmug-line-cloud-rain" => "Cloud-rain" ),
                array( "bigmug-line-glass" => "Glass" ),
                array( "bigmug-line-code" => "Code" ),
                array( "bigmug-line-collapse2" => "Collapse2" ),
                array( "bigmug-line-comment" => "Comment" ),
                array( "bigmug-line-compass" => "Compass" ),
                array( "bigmug-line-collapse-square" => "Collapse-square" ),
                array( "bigmug-line-copy" => "Copy" ),
                array( "bigmug-line-crescent" => "Crescent" ),
                array( "bigmug-line-cropping" => "Cropping" ),
                array( "bigmug-line-cross" => "Cross" ),
                array( "bigmug-line-cross-square" => "Cross-square" ),
                array( "bigmug-line-layer" => "Layer" ),
                array( "bigmug-line-arrow-v" => "Arrow-v" ),
                array( "bigmug-line-chavron-double-right" => "Arrow-double-right" ),
                array( "bigmug-line-arrow-h" => "Arrow-h" ),
                array( "bigmug-line-arrow-circle-down" => "Arrow-circle-down" ),
                array( "bigmug-line-arrow-square-down" => "Arrow-square-down" ),
                array( "bigmug-line-download1" => "Download1" ),
                array( "bigmug-line-chevron-square-down" => "Chevron-square-down" ),
                array( "bigmug-line-chevron-down" => "Chevron-down" ),
                array( "bigmug-line-download2" => "Download2" ),
                array( "bigmug-line-download3" => "Download3" ),
                array( "bigmug-line-download4" => "Download4" ),
                array( "bigmug-line-download5" => "Download5" ),
                array( "bigmug-line-arrow-circle-down" => "Arrow-circle-down" ),
                array( "bigmug-line-electrical" => "Electrical" ),
                array( "bigmug-line-electronic" => "Electronic" ),
                array( "bigmug-line-email1" => "Email1" ),
                array( "bigmug-line-email2" => "Email2" ),
                array( "bigmug-line-equalizar1" => "Equalizar1" ),
                array( "bigmug-line-equalizar2" => "Equalizar2" ),
                array( "bigmug-line-event" => "Event" ),
                array( "bigmug-line-expand-square" => "Expand-square" ),
                array( "bigmug-line-expand" => "Expand" ),
                array( "bigmug-line-forward" => "Forward" ),
                array( "bigmug-line-star" => "Star" ),
                array( "bigmug-line-file1" => "File1" ),
                array( "bigmug-line-file2" => "File2" ),
                array( "bigmug-line-film" => "Film" ),
                array( "bigmug-line-flag" => "Flag" ),
                array( "bigmug-line-foggy-moon" => "Foggy-moon" ),
                array( "bigmug-line-foggy-sun" => "Foggy-sun" ),
                array( "bigmug-line-folder" => "Folder" ),
                array( "bigmug-line-fork" => "Fork" ),
                array( "bigmug-line-th-large" => "Th-large" ),
                array( "bigmug-line-full" => "Full" ),
                array( "bigmug-line-gameboy" => "Gameboy" ),
                array( "bigmug-line-gear" => "Gear" ),
                array( "bigmug-line-giftbox" => "Giftbox" ),
                array( "bigmug-line-graphical" => "Graphical" ),
                array( "bigmug-line-headphones" => "Headphones" ),
                array( "bigmug-line-fire" => "Fire" ),
                array( "bigmug-line-images" => "Images" ),
                array( "bigmug-line-ink" => "Ink" ),
                array( "bigmug-line-tag1" => "Tag1" ),
                array( "bigmug-line-tag2" => "Tag2" ),
                array( "bigmug-line-tag3" => "Tag3" ),
                array( "bigmug-line-left-square" => "Left-square" ),
                array( "bigmug-line-chevron-left" => "Chevron-left" ),
                array( "bigmug-line-chevron-circle-left" => "Chevron-circle-left" ),
                array( "bigmug-line-chevron-square-left" => "Chevron-square-left" ),
                array( "bigmug-line-align-left" => "Align-left" ),
                array( "bigmug-line-undo" => "Undo" ),
                array( "bigmug-line-heart" => "Heart" ),
                array( "bigmug-line-link" => "Icon-googleplus" ),
                array( "bigmug-line-list1" => "List1" ),
                array( "bigmug-line-list2" => "List2" ),
                array( "bigmug-line-lock" => "Lock" ),
                array( "bigmug-line-login1" => "Login1" ),
                array( "bigmug-line-login2" => "Login2" ),
                array( "bigmug-line-map" => "Map" ),
                array( "bigmug-line-megaphone" => "Megaphone" ),
                array( "bigmug-line-menu-bar1" => "Menu-bar1" ),
                array( "bigmug-line-menu-bar2" => "Menu-bar2" ),
                array( "bigmug-line-menu-bar2" => "Menu-bar3" ),
                array( "bigmug-line-microphone1" => "Microphone1" ),
                array( "bigmug-line-microphone2" => "Microphone2" ),
                array( "bigmug-line-minus-circle" => "Minus-circle" ),
                array( "bigmug-line-minus-square" => "Minus-square" ),
                array( "bigmug-line-zoom-out" => "Zoom-out" ),
                array( "bigmug-line-minus" => "Minus" ),
                array( "bigmug-line-monitor" => "Monitor" ),
                array( "bigmug-line-music1" => "Music1" ),
                array( "bigmug-line-music2" => "Music2" ),
                array( "bigmug-line-music3" => "Music3" ),
                array( "bigmug-line-music4" => "Music4" ),
                array( "bigmug-line-music5" => "Music5" ),
                array( "bigmug-line-mute1" => "Mute1" ),
                array( "bigmug-line-mute2" => "Mute2" ),
                array( "bigmug-line-clock" => "Clock" ),
                array( "bigmug-line-edit" => "Edit" ),
                array( "bigmug-line-notebook" => "Notebook" ),
                array( "bigmug-line-notification1" => "Notification1" ),
                array( "bigmug-line-notification2" => "Notification2" ),
                array( "bigmug-line-email4" => "Email4" ),
                array( "bigmug-line-comment2" => "Comment2" ),
                array( "bigmug-line-brush" => "brush" ),
                array( "bigmug-line-paper-plane" => "Paper-plane" ),
                array( "bigmug-line-pause" => "Pause" ),
                array( "bigmug-line-pencil" => "Pencil" ),
                array( "bigmug-line-phone" => "Phone" ),
                array( "bigmug-line-camera" => "Camera" ),
                array( "bigmug-line-pin" => "Pin" ),
                array( "bigmug-line-planet" => "Planet" ),
                array( "bigmug-line-play" => "Play" ),
                array( "bigmug-line-portfolio" => "Portfolio" ),
                array( "bigmug-line-print" => "Print" ),
                array( "bigmug-line-radio" => "Radio" ),
                array( "bigmug-line-cloud-rain2" => "Cloud-rain2" ),
                array( "bigmug-line-comment3" => "Comment3" ),
                array( "bigmug-line-trash" => "Trash" ),
                array( "bigmug-line-rewind" => "Rewind" ),
                array( "bigmug-line-arrow-circle-righ" => "Circle-righ" ),
                array( "bigmug-line-map-signs" => "Map-signs" ),
                array( "bigmug-line-arrow-square-right" => "Arrow-square-right" ),
                array( "bigmug-line-right-square" => "Right-square" ),
                array( "bigmug-line-chevron-circle-right" => "Chevron-circle-right" ),
                array( "bigmug-line-redo" => "Redo" ),
                array( "bigmug-line-chevron-right" => "Chevron-right" ),
                array( "bigmug-line-chevron-square-right" => "Chevron-square-right" ),
                array( "bigmug-line-mouse" => "Mouse" ),
                array( "bigmug-line-hourglass" => "Hourglass" ),
                array( "bigmug-line-save" => "Save" ),
                array( "bigmug-line-search" => "Search" ),
                array( "bigmug-line-pin2" => "Pin2" ),
                array( "bigmug-line-share" => "share" ),
                array( "bigmug-line-shopping-bag" => "Shopping-bag" ),
                array( "bigmug-line-shopping-basket" => "Shopping-basket" ),
                array( "bigmug-line-shopping-cart1" => "Shopping-cart1" ),
                array( "bigmug-line-shopping-cart2" => "Shopping-cart2" ),
                array( "bigmug-line-shuffle" => "Shuffle" ),
                array( "bigmug-line-sort-up" => "Sort-up" ),
                array( "bigmug-line-sort-down" => "Sort-down" ),
                array( "bigmug-line-speaker" => "Speaker" ),
                array( "bigmug-line-speaker2" => "Speaker2" ),
                array( "bigmug-line-speaker3" => "Speaker3" ),
                array( "bigmug-line-volumn-up" => "Volumn-up" ),
                array( "bigmug-line-volumn-down" => "Volumn-down" ),
                array( "bigmug-line-speech" => "Speech" ),
                array( "bigmug-line-target-square" => "Target-square" ),
                array( "bigmug-line-square" => "Square" ),
                array( "bigmug-line-point" => "Point" ),
                array( "bigmug-line-store" => "Store" ),
                array( "bigmug-line-sun" => "Sun" ),
                array( "bigmug-line-sunrise" => "Sunrise" ),
                array( "bigmug-line-switch1" => "Switch1" ),
                array( "bigmug-line-switch2" => "Switch2" ),
                array( "bigmug-line-tag4" => "Tag4" ),
                array( "bigmug-line-television" => "Television" ),
                array( "bigmug-line-align-left" => "Align-left" ),
                array( "bigmug-line-text" => "Text" ),
                array( "bigmug-line-chart" => "Chart" ),
                array( "bigmug-line-timer" => "Timer" ),
                array( "bigmug-line-tool" => "Tool" ),
                array( "bigmug-line-triangle" => "Triangle" ),
                array( "bigmug-line-trophy" => "Trophy" ),
                array( "bigmug-line-refrash2" => "Refrash2" ),
                array( "bigmug-line-refrash3" => "Refrash3" ),
                array( "bigmug-line-tint" => "Tint" ),
                array( "bigmug-line-chevron-double-left" => "Chevron-double-left" ),
                array( "bigmug-line-clone" => "Clone" ),
                array( "bigmug-line-unlocked" => "Unlocked" ),
                array( "bigmug-line-chevron-circle-up" => "chevron-circle-u" ),
                array( "bigmug-line-spoon" => "Spoon" ),
                array( "bigmug-line-arrow-square-up" => "Arrow-square-up" ),
                array( "bigmug-line-upload" => "Upload" ),
                array( "bigmug-line-chevron-square-up" => "Chevron-square-up" ),
                array( "bigmug-line-home" => "Home" ),
                array( "bigmug-line-chevron-up" => "Chevron-up" ),
                array( "bigmug-line-up-square" => "Up-square" ),
                array( "bigmug-line-arrow-circle-up" => "Arrow-circle-up" ),
                array( "bigmug-line-up-square2" => "Up-square2" ),
                array( "bigmug-line-upload2" => "Upload2" ),
                array( "bigmug-line-upload3" => "Upload3" ),
                array( "bigmug-line-expand2" => "Expand2" ),
                array( "bigmug-line-user1" => "User1" ),
                array( "bigmug-line-user2" => "User2" ),
                array( "bigmug-line-video" => "Video" ),
                array( "bigmug-line-wallet" => "Wallet" ),
                array( "bigmug-line-weather" => "Weather" ),
                array( "bigmug-line-calendar1" => "Calendar1" ),
                array( "bigmug-line-calendar2" => "Calendar2" ),
                array( "bigmug-line-wind" => "Wind" ),
                array( "bigmug-line-window" => "Window" ),
                array( "bigmug-line-winds" => "Winds" ),
                array( "bigmug-line-wrench" => "Wrench" ),
                array( "bigmug-line-zoom-in" => "Zoom-in" )

	        );
            return $icons;
        }

        public function get_simple_line_icons( $icons ){
            $icons = array(
            	array( "sl-user-female" => "Female" ),
                array( "sl-user-follow" => "Follow" ),
                array( "sl-user-following" => "Following" ),
                array( "sl-user-unfollow" => "Unfollow" ),
                array( "sl-trophy" => "Trophy" ),
                array( "sl-screen-smartphone" => "Smartphone" ),
                array( "sl-screen-desktop" => "Desktop" ),
                array( "sl-plane" => "Plane" ),
                array( "sl-notebook" => "Notebook" ),
                array( "sl-moustache" => "Moustache" ),
                array( "sl-mouse" => "Mouse" ),
                array( "sl-magnet" => "Magnet" ),
                array( "sl-energy" => "Energy" ),
                array( "sl-emoticon-smile" => "Emoticon-smile" ),
                array( "sl-disc" => "Disc" ),
                array( "sl-cursor-move" => "Cursor-move" ),
                array( "sl-crop" => "Crop" ),
                array( "sl-credit-card" => "Credit-card" ),
                array( "sl-chemistry" => "Chemistry" ),
                array( "sl-user" => "User" ),
                array( "sl-speedometer" => "Speedometer" ),
                array( "sl-social-youtube" => "Youtube" ),
                array( "sl-social-twitter" => "Twitter" ),
                array( "sl-social-tumblr" => "Tumblr" ),
                array( "sl-social-facebook" => "Facebook" ),
                array( "sl-social-dropbox" => "Dropbox" ),
                array( "sl-social-dribbble" => "Dribbble" ),
                array( "sl-shield" => "Shield" ),
                array( "sl-screen-tablet" => "Tablet" ),
                array( "sl-magic-wand" => "Magic-wand" ),
                array( "sl-hourglass" => "Hourglass" ),
                array( "sl-graduation" => "Graduation" ),
                array( "sl-ghost" => "Ghost" ),
                array( "sl-game-controller" => "Game-controller" ),
                array( "sl-fire" => "Fire" ),
                array( "sl-eyeglasses" => "Eyeglasses" ),
                array( "sl-envelope-open" => "Envelope-open" ),
                array( "sl-envelope-letter" => "Envelope-letter" ),
                array( "sl-bell" => "Bell" ),
                array( "sl-badge" => "Badge" ),
                array( "sl-anchor" => "Anchor" ),
                array( "sl-wallet" => "Wallet" ),
                array( "sl-vector" => "Vector" ),
                array( "sl-speech" => "Speech" ),
                array( "sl-puzzle" => "Puzzle" ),
                array( "sl-printer" => "Printer" ),
                array( "sl-present" => "Present" ),
                array( "sl-playlist" => "Playlist" ),
                array( "sl-pin" => "Pin" ),
                array( "sl-picture" => "Picture" ),
                array( "sl-map" => "Map" ),
                array( "sl-layers" => "Layers" ),
                array( "sl-handbag" => "Handbag" ),
                array( "sl-globe-alt" => "Globe-alt" ),
                array( "sl-globe" => "Globe" ),
                array( "sl-frame" => "Frame" ),
                array( "sl-folder-alt" => "Folder-alt" ),
                array( "sl-film" => "Film" ),
                array( "sl-feed" => "Feed" ),
                array( "sl-earphones-alt" => "Earphones-alt" ),
                array( "sl-earphones" => "Earphones" ),
                array( "sl-drop" => "Drop" ),
                array( "sl-drawer" => "Drawer" ),
                array( "sl-docs" => "Docs" ),
                array( "sl-directions" => "Directions" ),
                array( "sl-direction" => "Direction" ),
                array( "sl-diamond" => "Diamond" ),
                array( "sl-cup" => "Cup" ),
                array( "sl-compass" => "Compress" ),
                array( "sl-call-out" => "Call-out" ),
                array( "sl-call-in" => "Call-in" ),
                array( "sl-call-end" => "Call-end" ),
                array( "sl-calculator" => "Calculator" ),
                array( "sl-bubbles" => "Bubbles" ),
                array( "sl-briefcase" => "Briefcase" ),
                array( "sl-book-open" => "Book-open" ),
                array( "sl-basket-loaded" => "Basket-loaded" ),
                array( "sl-basket" => "Basket" ),
                array( "sl-bag" => "Bag" ),
                array( "sl-action-undo" => "Action-undo" ),
                array( "sl-action-redo" => "Action-redo" ),
                array( "sl-wrench" => "Wrench" ),
                array( "sl-umbrella" => "Umbrella" ),
                array( "sl-trash" => "Trash" ),
                array( "sl-tag" => "Tag" ),
                array( "sl-support" => "Support" ),
                array( "sl-size-fullscreen" => "Size-fullscreen" ),
                array( "sl-size-actual" => "Size-actual" ),
                array( "sl-shuffle" => "Shuffle" ),
                array( "sl-share-alt" => "Share-alt" ),
                array( "sl-share" => "Share" ),
                array( "sl-rocket" => "Rocket" ),
                array( "sl-question" => "Question" ),
                array( "sl-pie-chart" => "Pie-chart" ),
                array( "sl-pencil" => "Pencil" ),
                array( "sl-note" => "Note" ),
                array( "sl-music-tone-alt" => "Music-tone-alt" ),
                array( "sl-music-tone" => "Music-tone" ),
                array( "sl-microphone" => "Microphone" ),
                array( "sl-loop" => "Loop" ),
                array( "sl-logout" => "Logout" ),
                array( "sl-login" => "Login" ),
                array( "sl-list" => "List" ),
                array( "sl-like" => "Like" ),
                array( "sl-home" => "Home" ),
                array( "sl-grid" => "Grid" ),
                array( "sl-graph" => "Graph" ),
                array( "sl-equalizer" => "Equalizer" ),
                array( "sl-dislike" => "Dislike" ),
                array( "sl-cursor" => "Cursor" ),
                array( "sl-control-start" => "Control-start" ),
                array( "sl-control-rewind" => "Control-rewind" ),
                array( "sl-control-play" => "Control-play" ),
                array( "sl-control-pause" => "Control-pause" ),
                array( "sl-control-forward" => "Control-forward" ),
                array( "sl-control-end" => "Control-end" ),
                array( "sl-calendar" => "Calendar" ),
                array( "sl-bulb" => "Bulb" ),
                array( "sl-bar-chart" => "Bar-chart" ),
                array( "sl-arrow-up" => "Arrow-up" ),
                array( "sl-arrow-right" => "Arrow-right" ),
                array( "sl-arrow-left" => "Arrow-left" ),
                array( "sl-arrow-down" => "Arrow-down" ),
                array( "sl-ban" => "Ban" ),
                array( "sl-bubble" => "Bubble" ),
                array( "sl-camcorder" => "Camcorder" ),
                array( "sl-camera" => "Camera" ),
                array( "sl-check" => "Check" ),
                array( "sl-clock" => "Clock" ),
                array( "sl-close" => "Close" ),
                array( "sl-cloud-download" => "Cloud-download" ),
                array( "sl-cloud-upload" => "Cloud-upload" ),
                array( "sl-doc" => "Doc" ),
                array( "sl-envelope" => "Envelope" ),
                array( "sl-eye" => "Eye" ),
                array( "sl-flag" => "Flag" ),
                array( "sl-folder" => "Folder" ),
                array( "sl-heart" => "Heart" ),
                array( "sl-info" => "Info" ),
                array( "sl-key" => "Key" ),
                array( "sl-link" => "Link" ),
                array( "sl-lock" => "Lock" ),
                array( "sl-lock-open" => "Lock-open" ),
                array( "sl-magnifier" => "Magnifier" ),
                array( "sl-magnifier-add" => "Magnifier-add" ),
                array( "sl-magnifier-remove" => "Magnifier-remove" ),
                array( "sl-paper-clip" => "Paper-clip" ),
                array( "sl-paper-plane" => "Paper-plane" ),
                array( "sl-plus" => "Plus" ),
                array( "sl-pointer" => "Pointer" ),
                array( "sl-power" => "Power" ),
                array( "sl-refresh" => "Refresh" ),
                array( "sl-reload" => "Reload" ),
                array( "sl-settings" => "Settings" ),
                array( "sl-star" => "Star" ),
                array( "sl-symbol-female" => "Symbol-female" ),
                array( "sl-symbol-male" => "Symbol-male" ),
                array( "sl-target" => "Target" ),
                array( "sl-volume-1" => "Volume-1" ),
                array( "sl-volume-2" => "Volume-2" ),
                array( "sl-volume-off" => "Volume-off" ),
                array( "sl-users" => "Users" ),
	        );
            return $icons;
        }

        public function get_farming_icons( $icons ){

            $icons = array(
            	array( "fm-bee" => "bee" ),
            	array( "fm-bird-house" => "bird-house" ),
            	array( "fm-bonsai" => "bonsai" ),
            	array( "fm-butterfly" => "butterfly" ),
                array( "fm-cactus-1" => "cactus-1" ),
                array( "fm-cactus" => "cactus" ),
                array( "fm-cart" => "cart" ),
            	array( "fm-dungarees" => "dungarees" ),
            	array( "fm-fence2" => "fence2" ),
            	array( "fm-flower-1" => "flower-1" ),
                array( "fm-flower-2" => "flower-2" ),
                array( "fm-flower-in-a-pot" => "flower-in-a-pot" ),
                array( "fm-flower3" => "flower3" ),
            	array( "fm-flowers-in-a-pot-1" => "flowers-in-a-pot-1" ),
            	array( "fm-flowers-in-a-pot" => "flowers-in-a-pot" ),
            	array( "fm-fountain" => "fountain" ),
                array( "fm-gnome" => "gnome" ),
                array( "fm-grass" => "grass" ),
                array( "fm-hanging-plant" => "hanging-plant" ),
            	array( "fm-hose3" => "hose3" ),
            	array( "fm-ladybug" => "ladybug" ),
            	array( "fm-lamppost" => "lamppost" ),
                array( "fm-leaves" => "leaves" ),
                array( "fm-mower" => "mower" ),
                array( "fm-pinwheel" => "pinwheel" ),
            	array( "fm-plant-1" => "plant-1" ),
            	array( "fm-plant2" => "plant2" ),
            	array( "fm-plants" => "plants" ),
                array( "fm-rose" => "rose" ),
                array( "fm-seeds3" => "seeds3" ),
                array( "fm-shed" => "shed" ),
            	array( "fm-tree4" => "tree4" ),
            	array( "fm-trowel2" => "trowel2" ),
            	array( "fm-water-sprayer" => "water-sprayer" ),
                array( "fm-watering-can-1" => "watering-can-1" ),
                array( "fm-watering-can3" => "watering-can3" ),
            	array( "fm-calendar1" => "Calendar1" ),
            	array( "fm-calendar2" => "Calendar2" ),
            	array( "fm-transport" => "Transport" ),
            	array( "fm-cabbage2" => "Cabbage2" ),
                array( "fm-cupcake" => "Cake" ),
                array( "fm-plate" => "Plate" ),
                array( "fm-baked-muffin" => "Baked-muffin" ),
                array( "fm-baked-waffle" => "Baked-waffle" ),
                array( "fm-bakery-shop" => "Bakery-shop" ),
                array( "fm-barista" => "Barista" ),
                array( "fm-berries-bowl" => "Berries-bowl" ),
                array( "fm-big-cup-of-coffee" => "Big-cup-of-coffee" ),
                array( "fm-big-egg" => "Big-egg" ),
                array( "fm-blender-with-cover" => "Blender-with-cover" ),
                array( "fm-boiling-breakfast" => "Boiling-breakfast" ),
                array( "fm-booiled-egg" => "Booiled-egg" ),
                array( "fm-box-of-juice" => "Box-of-juice" ),
                array( "fm-breakfast-delivery-service" => "Breakfast-delivery-service" ),
                array( "fm-breakfast-in-bed" => "Breakfast-in-bed" ),
                array( "fm-breakfast-in-cafe" => "Breakfast-in-cafe" ),
                array( "fm-breakfast-menu" => "Breakfast-menu" ),
                array( "fm-breakfast-products" => "Breakfast-products" ),
                array( "fm-breakfast-ready" => "Breakfast-ready" ),
                array( "fm-breakfast-set" => "Breakfast-set" ),
                array( "fm-breakfast-tv-show" => "Breakfast-tv-show" ),
                array( "fm-cafe-sign" => "Cafe-sign" ),
                array( "fm-casserole-on-burner" => "Casserole-on-burner" ),
                array( "fm-cereals-bowl" => "Cereals-bowl" ),
                array( "fm-cheese-slice-with-holes" => "Cheese-slice-with-holes" ),
                array( "fm-chef-cooking" => "Chef-cooking" ),
                array( "fm-chef-hat-with-spoons" => "Chef-hat-with-spoons" ),
                array( "fm-chocolate-bar" => "Chocolate-bar" ),
                array( "fm-chocolate-cookie" => "Chocolate-cookie" ),
                array( "fm-coffe-vending-machine" => "Coffe-vending-machine" ),
                array( "fm-coffee-bean" => "Coffee-bean" ),
                array( "fm-coffee-brew" => "Coffee-brew" ),
                array( "fm-coffee-machine" => "Coffee-machine" ),
                array( "fm-coffee-mill" => "Coffee-mill" ),
                array( "fm-coffee-pack" => "Coffee-pack" ),
                array( "fm-coffee-shop" => "Coffee-shop" ),
                array( "fm-coffee-with-cream" => "Coffee-with-cream" ),
                array( "fm-cook-apron" => "Cook-apron" ),
                array( "fm-cooking-blog" => "Cooking-blog" ),
                array( "fm-cooking" => "Cooking" ),
                array( "fm-cornflakes-open-box" => "Cornflakes-open-box" ),
                array( "fm-cow-milk" => "Cow-milk" ),
                array( "fm-cream-cheese" => "Cream-cheese" ),
                array( "fm-cream-jar" => "Cream-jar" ),
                array( "fm-croissant-for-breakfast" => "Croissant-for-breakfast" ),
                array( "fm-cup-of-hot-coffee" => "Cup-of-hot-coffee" ),
                array( "fm-cup-of-hot-tea" => "Cup-of-hot-tea" ),
                array( "fm-cutlery-set" => "Cutlery-set" ),
                array( "fm-donut" => "Donut" ),
                array( "fm-dough-making" => "Dough-making" ),
                array( "fm-eating-breakfast" => "Eating-breakfast" ),
                array( "fm-espresso-coffee" => "Espresso-coffee" ),
                array( "fm-fixing-breakfast" => "Fixing-breakfast" ),
                array( "fm-french-press-coffee" => "French-press-coffee" ),
                array( "fm-fresh-bread" => "Fresh-bread" ),
                array( "fm-fresh-juice-with-citrus-slice" => "Fresh-juice-with-citrus-slice" ),
                array( "fm-freshly-cook-meal" => "Freshly-cook-meal" ),
                array( "fm-fried-egg-on-frying-pan" => "Fried-egg-on-frying-pan" ),
                array( "fm-full-tea-leaf" => "Full-tea-leaf" ),
                array( "fm-glass-of-water" => "Glass-of-water" ),
                array( "fm-healthy-breakfast" => "Healthy-breakfast" ),
                array( "fm-honey-jar" => "Honey-jar" ),
                array( "fm-hot-cacao-cup" => "Hot-cacao-cup" ),
                array( "fm-hot-kettle" => "Hot-kettle" ),
                array( "fm-hot-pancakes" => "Hot-pancakes" ),
                array( "fm-hungry-and-thristy" => "Hungry-and-thristy" ),
                array( "fm-ice-coffee" => "Ice-coffee" ),
                array( "fm-jug-of-coffee" => "Jug-of-coffee" ),
                array( "fm-juice-squeezing" => "Juice-squeezing" ),
                array( "fm-knife-and-butter" => "Knife-and-butter" ),
                array( "fm-latte-coffee" => "Latte-coffee" ),
                array( "fm-maple-syrup" => "Maple-syrup" ),
                array( "fm-microwave-oven" => "Microwave-oven" ),
                array( "fm-milkshake-with-straw" => "Milkshake-with-straw" ),
                array( "fm-morning-news" => "Morning-news" ),
                array( "fm-morning-newspaper-and-coffee" => "Morning-newspaper-and-coffee" ),
                array( "fm-muesli-jar" => "Muesli-jar" ),
                array( "fm-nuts-bowl" => "Nuts-bowl" ),
                array( "fm-pack-of-flour" => "Pack-of-flour" ),
                array( "fm-pack-of-oats" => "Pack-of-oats" ),
                array( "fm-piece-of-pie" => "Piece-of-pie" ),
                array( "fm-porridge-bowl" => "Porridge-bowl" ),
                array( "fm-recipes-book" => "Recipes-book" ),
                array( "fm-salad-bowl" => "Salad-bowl" ),
                array( "fm-slice-toasted" => "Slice-toasted" ),
                array( "fm-sparkling-water" => "Sparkling-water" ),
                array( "fm-strawberry-jam" => "Strawberry-jam" ),
                array( "fm-sugar-package" => "Sugar-package" ),
                array( "fm-take-away-breakfast" => "Take-away-breakfast" ),
                array( "fm-take-away-coffee" => "Take-away-coffee" ),
                array( "fm-tea-bag" => "Tea-bag" ),
                array( "fm-toaster-with-bread" => "Toaster-with-bread" ),
                array( "fm-tools-for-baking" => "Tools-for-baking" ),
                array( "fm-turkish-coffee" => "Turkish-coffee" ),
                array( "fm-two-bacoon-slices" => "Two-bacoon-slices" ),
                array( "fm-two-coffee-filters" => "Two-coffee-filters" ),
                array( "fm-two-flour-stacks" => "Two-flour-stacks" ),
                array( "fm-two-fruits" => "Two-fruits" ),
                array( "fm-two-sausages" => "Two-sausages" ),
                array( "fm-two-vegetables" => "Two-vegetables" ),
                array( "fm-vegetable-sandwich" => "Vegetable-sandwich" ),
                array( "fm-yogurt-with-spoon" => "Yogurt-with-spoon" ),
            	array( "fm-axe" => "Axe" ),
                array( "fm-bale-of-hay" => "Bale-of-hay" ),
                array( "fm-barn" => "Barn" ),
                array( "fm-barrell" => "Barrell" ),
                array( "fm-bees" => "Bees" ),
                array( "fm-billhook" => "Billhook" ),
                array( "fm-boot" => "Boot" ),
                array( "fm-bucket" => "Backet" ),
                array( "fm-chainsaw" => "Chainsaw" ),
                array( "fm-composter" => "Composter" ),
                array( "fm-cow" => "Cow" ),
                array( "fm-digging-bar" => "Digging-bar" ),
                array( "fm-duck" => "Duck" ),
                array( "fm-eggs" => "Eggs" ),
                array( "fm-farmer" => "Farmer" ),
                array( "fm-field" => "Field" ),
                array( "fm-fruit" => "Fruit" ),
                array( "fm-glove" => "Glove" ),
                array( "fm-greenhouse" => "Greenhouse" ),
                array( "fm-growing-plant" => "Growing-plant" ),
                array( "fm-hen" => "Hen" ),
                array( "fm-hoe" => "Hoe" ),
                array( "fm-honey" => "Honey" ),
                array( "fm-horseshoe" => "Horseshoe" ),
                array( "fm-hose" => "Hose" ),
                array( "fm-milk" => "Milk" ),
                array( "fm-pig" => "Pig" ),
                array( "fm-plant" => "Plant" ),
                array( "fm-rabbit" => "Rabbit" ),
                array( "fm-riddle-tool" => "Riddle-tool" ),
                array( "fm-roak" => "Soak" ),
                array( "fm-sack" => "Sack" ),
                array( "fm-scythe" => "Scythe" ),
                array( "fm-shears" => "Shears" ),
                array( "fm-sheep" => "Sheep" ),
                array( "fm-shovel" => "Shovel" ),
                array( "fm-shovel-1" => "Shovel-1" ),
                array( "fm-silo" => "Silo" ),
                array( "fm-tractor" => "Tractor" ),
                array( "fm-trailer" => "Trailer" ),
                array( "fm-tree" => "Tree" ),
                array( "fm-trowel" => "Trowel" ),
                array( "fm-truck" => "Truck" ),
                array( "fm-vegetables" => "Vegetables" ),
                array( "fm-watering-can" => "Watering-can" ),
                array( "fm-well" => "Well" ),
                array( "fm-wheat" => "Wheat" ),
                array( "fm-wheelbarrow" => "wheelbarrow" ),
                array( "fm-wind-mill" => "Wind-mill" ),
                array( "fm-wind-mill2" => "wind-mill2" ),
                array( "fm-chicken" => "Chicken" ),
                array( "fm-cow2" => "Cow2" ),
                array( "fm-eggs2" => "Eggs2" ),
                array( "fm-farm-tools" => "Farm-tools" ),
                array( "fm-farm" => "Farm" ),
                array( "fm-farmer2" => "Farmer2" ),
                array( "fm-field2" => "Field2" ),
                array( "fm-greenhouse2" => "Greenhouse2" ),
                array( "fm-harvest" => "Harvest" ),
                array( "fm-hay-roll" => "Hay-roll" ),
                array( "fm-honey2" => "Honey2" ),
                array( "fm-meat" => "Meat" ),
                array( "fm-milk-products" => "Milk-products" ),
                array( "fm-pig2" => "Pig2" ),
                array( "fm-rye" => "Rye" ),
                array( "fm-sheep2" => "Sheep2" ),
                array( "fm-tractor2" => "Tractor2" ),
                array( "fm-tree2" => "Tree2" ),
                array( "fm-vegetables2" => "Vegetables2" ),
                array( "fm-vegetable-basket" => "Vegetable-basket" ),
                array( "fm-apple" => "Apple" ),
                array( "fm-barn2" => "Barn2" ),
                array( "fm-barrow" => "Barrow" ),
                array( "fm-basket" => "Basket" ),
                array( "fm-bench" => "Bench" ),
                array( "fm-birdhouse" => "Birdhouse" ),
                array( "fm-boot2" => "Boot2" ),
                array( "fm-bucket2" => "Bucket2" ),
                array( "fm-cabbage" => "Cabbage" ),
                array( "fm-carrot" => "Carrot" ),
                array( "fm-cultivator" => "Cultivator" ),
                array( "fm-fence" => "Fence" ),
                array( "fm-flower" => "Flower" ),
                array( "fm-flower2" => "Flower2" ),
                array( "fm-flowers" => "Flowers" ),
                array( "fm-garden" => "Garden" ),
                array( "fm-gardener" => "Gardener" ),
                array( "fm-gardener2" => "Gardener2" ),
                array( "fm-glove2" => "Glove2" ),
                array( "fm-hat" => "Hat" ),
                array( "fm-hose2" => "Hose2" ),
                array( "fm-ladder" => "Ladder" ),
                array( "fm-lawn-mower" => "Lawn-mower" ),
                array( "fm-leaf" => "Leaf" ),
                array( "fm-onion" => "Onion" ),
                array( "fm-pear" => "Pear" ),
                array( "fm-pitchfork" => "Pitchfork" ),
                array( "fm-pot" => "Pot" ),
                array( "fm-pruning-shears" => "Pruning-shears" ),
                array( "fm-pruning-shears2" => "Pruning-shears2" ),
                array( "fm-radish" => "Radish" ),
                array( "fm-rain" => "Rain" ),
                array( "fm-rake-1" => "Rake" ),
                array( "fm-rake2" => "Rake2" ),
                array( "fm-rake3" => "Rake3" ),
                array( "fm-saw" => "Saw" ),
                array( "fm-scissors" => "Scissors" ),
                array( "fm-seeds" => "Seeds" ),
                array( "fm-seeds2" => "Seeds2" ),
                array( "fm-shovel3" => "Shovel3" ),
                array( "fm-shovel4" => "Shovel4" ),
                array( "fm-shovel5" => "Shovel5" ),
                array( "fm-shovel6" => "Shovel6" ),
                array( "fm-spray" => "Spray" ),
                array( "fm-sprout" => "Sprout" ),
                array( "fm-sprout2" => "Sprout2" ),
                array( "fm-sun" => "Sun" ),
                array( "fm-tree3" => "Tree3" ),
                array( "fm-veranda" => "Veranda" ),
                array( "fm-watering-can2" => "Watering-can2" ),
                array( "fm-amusement-park" => "Amusement-park" ),
                array( "fm-autumn" => "Autumn" ),
                array( "fm-castle" => "Castle" ),
                array( "fm-circus" => "Circus" ),
                array( "fm-city" => "City" ),
                array( "fm-desert" => "Desert" ),
                array( "fm-dunes" => "Dunes" ),
                array( "fm-factory" => "Factory" ),
                array( "fm-field3" => "Field3" ),
                array( "fm-field4" => "Field4" ),
                array( "fm-field-and-forest" => "Field-and-forest" ),
                array( "fm-field-and-windmill" => "Field-and-windmill" ),
                array( "fm-forest" => "Forest" ),
                array( "fm-grove" => "Grove" ),
                array( "fm-hay-rolls" => "Hay-rolls" ),
                array( "fm-island" => "Island" ),
                array( "fm-lake" => "Lake" ),
                array( "fm-mountains" => "Mountains" ),
                array( "fm-mountains" => "Mountains2" ),
                array( "fm-rain2" => "Rain2" ),
                array( "fm-river" => "River" ),
                array( "fm-sea-shore" => "Sea-shore" ),
                array( "fm-spring" => "Spring" ),
                array( "fm-suburb" => "Suburb" ),
                array( "fm-summer" => "Summer" ),
                array( "fm-sunset-at-sea" => "Sunset-at-sea" ),
                array( "fm-tree-alone" => "Tree-alone" ),
                array( "fm-valley" => "Valley" ),
                array( "fm-waterfall" => "Waterfall" ),
                array( "fm-winter" => "Winter" ),       
	        );
            return $icons;
        }

        public function get_portfolio_masonry_layout( $layout = '' ){
     	
     		$masonry_layout = array();

	     	switch( $layout ){
		        case 'masonry-1':
			        $masonry_layout = array('w-item w-w2 w-h2', 'w-item', 'w-item', 'w-item w-w2 w-h2', 'w-item', 'w-item');
			        break;
		        case 'masonry-2':
			        $masonry_layout = array('w-item', 'w-item w-h2', 'w-item w-w2', 'w-item w-h2', 'w-item w-w2 w-h2', 'w-item');
			        break;			        
		        default:
		        	$masonry_layout = array('w-item', 'w-item w-h2');			        
			        break;
		    }

		    return $masonry_layout;
		}

		public function get_gallery_masonry_layout( $layout = '' ){
			
			$masonry_layout = array();
	        
	        switch( $layout ){
	            case '1':
		            $masonry_layout = array('w-item', 'w-item w-h2', 'w-item', 'w-item w-h2', 'w-item w-h2', 'w-item w-h2', 'w-item', 'w-item');
		            break;
	            case '2':
		            $masonry_layout = array('w-item w-h2', 'w-item', 'w-item w-h2', 'w-item', 'w-item', 'w-item w-h2', 'w-item w-h2', 'w-item w-h2', 'w-item w-h2', 'w-item', 'w-item');
		            break;
	            case 'masonry-1':
		            $masonry_layout = $this->get_portfolio_masonry_layout( 'masonry-1' );
		            break;
	            case 'masonry-2':
		            $masonry_layout = $this->get_portfolio_masonry_layout( 'masonry-2' );
		            break;
	        }

	        return $masonry_layout;
		}

	}

	new GoGreen_Shortcode();

}