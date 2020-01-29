<?php
    
if( function_exists('wyde_include_widget') ) {
    wyde_include_widget();
}

if( ! class_exists( 'GoGreen_Widget' ) ) {

    class GoGreen_Widget {

    	function __construct() {    		 
            add_action('wyde_social_icons', 'gogreen_social_icons');
            $this->load_widgets();
    	}

    	function GoGreen_Widget(){
    		$this->__construct();
    	}    	

        /* Find and include all shortcodes within shortcodes folder */
	    public function load_widgets() {

		    $files = glob( get_template_directory(). '/inc/widgets/*.php' );
            
            if( is_array($files) ){
                foreach( $files as $filename ) {
                    include_once( $filename );
                }
            }
		    
	    }	
	    
	}	

	new GoGreen_Widget();

}