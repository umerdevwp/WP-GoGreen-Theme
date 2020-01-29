<?php

if( !class_exists('GoGreen_MetaBox') ){
    
    class GoGreen_MetaBox{
        
        function __construct(){

            global $pagenow;           

            if ( is_admin() && ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) ) { 

                if( function_exists('wyde_include_metabox') ) {
                    wyde_include_metabox();
                }          

                if( class_exists('Wyde_MetaBox') ){

                    add_action( 'admin_enqueue_scripts', array($this, 'load_metaboxes_scripts'), 100);

                    $this->init_metaboxes();      
                    
                }                          

            }
            
        }

        function GoGreen_MetaBox(){
            $this->__construct();
        }    

        public function init_metaboxes(){

            $wyde_metabox = new Wyde_MetaBox();

            $wyde_metabox->id = 'gogreen_options';
            $wyde_metabox->title = esc_html__('GoGreen Options', 'gogreen');
            $wyde_metabox->post_types = array('post', 'page', 'wyde_portfolio', 'wyde_team_member', 'wyde_testimonial');

            foreach ($wyde_metabox->post_types as $post_type ) {               
                if( $post_type ) add_filter( 'wyde_metabox_'.$post_type, array( $this, 'get_options_file') );
            }  

        }

        public function get_options_file( $post_type = '' ){
            return  get_template_directory() .'/inc/metaboxes/'. $post_type .'-options.php';
        }

        /** Load Options Scripts **/
        public function load_metaboxes_scripts($hook) {             
        
            wp_enqueue_style( 'gogreen-metabox-style', get_template_directory_uri() .'/inc/metaboxes/css/custom.css',  null, null);
   
            wp_enqueue_script( 'jquery-cookie', get_template_directory_uri() .'/inc/metaboxes/js/jquery.cookie.js', array('jquery'), null, true );
            wp_enqueue_script( 'gogreen-metabox', get_template_directory_uri() .'/inc/metaboxes/js/options.js', array('jquery-cookie'), null, true );

        }

    }

    new GoGreen_MetaBox();

}