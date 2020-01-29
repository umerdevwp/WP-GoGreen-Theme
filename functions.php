<?php

/* Setup Theme */
function gogreen_setup_theme() {
    // Make theme available for translation.
    load_theme_textdomain('gogreen', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // WooCommerce
    add_theme_support('woocommerce');

    // Portfolio
    add_theme_support('wyde-portfolio'); 

    // Testimonial
    add_theme_support('wyde-testimonial'); 

    // Team Member 
    add_theme_support('wyde-team-member'); 

    // Footer
    add_theme_support('wyde-footer');      

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');
    // Square sizes (1:1)
    add_image_size('gogreen-medium', 340, 340, true);
    add_image_size('gogreen-large', 640, 640, true);
    add_image_size('gogreen-xlarge', 960, 960, true);
    // Portrait size (4:3)
    add_image_size('gogreen-portrait-medium', 600, 800, true);
    // Landscape sizes (16:9)
    add_image_size('gogreen-land-medium', 640, 360, true);
    add_image_size('gogreen-land-large', 960, 540, true);
    // Masonry size
    add_image_size('gogreen-masonry', 640, 9999);    
    // Full Width size 
    add_image_size('gogreen-fullwidth', 1280, 9999);

    // Enable support for Post Formats
    add_theme_support('post-formats', array(
        'audio', 'gallery', 'link', 'quote', 'video'
    ));

    // Register navigation locations
    register_nav_menus( array(
        'primary'   => esc_html__('Primary Navigation', 'gogreen'),
        'footer'    => esc_html__('Footer Navigation', 'gogreen'),
        'contact'   => esc_html__('Contact Info', 'gogreen')
    ));

    // Add html editor css styles
    add_editor_style( array( 'css/icons.css', 'css/editor.css' ) );
    
    // This theme uses its own gallery styles.
    add_filter( 'use_default_gallery_style', '__return_false' );

}
add_action('after_setup_theme', 'gogreen_setup_theme');

/* Sets the content width in pixels, based on the theme's design and stylesheet. */
function gogreen_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'gogreen_content_width', 1170 );
}
add_action( 'after_setup_theme', 'gogreen_content_width', 0 );

/* Initialize Widgets */
function gogreen_widgets_init(){

    /* Register sidebar locations */
    // Default widget area on blog page
    register_sidebar(array(
        'name'          => esc_html__('Blog Sidebar', 'gogreen'),
        'id'            => 'blog',
        'description'   => esc_html__( 'Appears at the left or right of the content on blog pages and blog posts.', 'gogreen' ),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
    
    // Widget area for page (1)
    register_sidebar(array(
        'name'          => esc_html__('Page Sidebar 1', 'gogreen'),
        'id'            => 'page1',
        'description'   => esc_html__( 'Appears at the left or right of the content on the pages with sidebar.', 'gogreen' ),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));

    // Widget area for page (2)
    register_sidebar(array(
        'name'          => esc_html__('Page Sidebar 2', 'gogreen'),
        'id'            => 'page2',
        'description'   => esc_html__( 'Appears at the left or right of the content on the pages with sidebar.', 'gogreen' ),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));    

    // Default widget area on shop page
    register_sidebar(array(
        'name'          => esc_html__('Shop Sidebar', 'gogreen'),
        'id'            => 'shop',
        'description'   => esc_html__( 'Appears at the left or right of the content on the shop page.', 'gogreen' ),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));

    // Sliding bar widget area at the right of the pages
    register_sidebar(array(
        'name'          => esc_html__('Sliding Bar', 'gogreen'),
        'id'            => 'slidingbar',
        'description'   => esc_html__( 'Appears at the right of the pages when the Slidingbar in Theme Options -> Navigation is enabled.', 'gogreen' ),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));

}
add_action( 'widgets_init', 'gogreen_widgets_init' );

/* Register and enqueue styles */
function gogreen_load_styles(){

    // Add theme stylesheet file
    wp_enqueue_style('gogreen', get_stylesheet_uri(), null, '1.1');

    // Add main stylesheet
    wp_enqueue_style('gogreen-main', get_template_directory_uri() . '/css/main.css', array('gogreen'), '1.1');
    
    // Register font icons
    wp_enqueue_style('gogreen-icons', get_template_directory_uri() . '/css/icons.css', null, '1.1');   

}
add_action('wp_enqueue_scripts', 'gogreen_load_styles');

/* Register and enqueue scripts */
function gogreen_load_scripts(){
       
    // jQuery scripts.
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-effects-core');    

    // jQuery plugins
    wp_enqueue_script('gogreen-plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery'), '1.1', true);

    // Main scripts
    wp_enqueue_script('gogreen-main', get_template_directory_uri() . '/js/main.js', array('gogreen-plugins'), '1.1', true);

    $wyde_page_settings = array();
    $wyde_page_settings['siteURL'] = get_home_url();
    if( gogreen_get_option('preload_images') ){
        $wyde_page_settings['isPreload'] = true;
    }

    if( gogreen_get_option('lightbox_title') ){
        $wyde_page_settings['lightbox_title'] = true;
    }

    if( gogreen_get_option('mobile_animation') ){
        $wyde_page_settings['mobile_animation'] = true;
    }

    $wyde_page_settings['ajaxURL'] = admin_url( 'admin-ajax.php' );

    // Ajax Search
    if( gogreen_get_option('ajax_search') ){
        $wyde_page_settings['ajax_search'] = true;
        if( gogreen_get_option('search_show_image') ) $wyde_page_settings['ajax_search_image'] = true;
        if( gogreen_get_option('search_show_author') ) $wyde_page_settings['ajax_search_author'] = true;
        if( gogreen_get_option('search_show_date') ) $wyde_page_settings['ajax_search_date'] = true;
    }

    // Ajax Page Transition enabled
    if( gogreen_get_option('ajax_page') ){

        $ajax_page_settings = array();
        $ajax_page_settings['transition'] =  gogreen_get_option('ajax_page_transition');
        if( is_array( gogreen_get_option('ajax_page_exclude_urls') ) ){
            $ajax_page_settings['excludeURLs'] = gogreen_get_option('ajax_page_exclude_urls');
        }

        $wyde_page_settings['ajax_page'] = true;
        $wyde_page_settings['ajax_page_settings'] = $ajax_page_settings;

        wp_enqueue_script('comment-reply');
        wp_enqueue_script('wp-mediaelement');
        wp_enqueue_script('googlemaps');             

    }else{
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }

    // Smooth Scroll
    if( gogreen_get_option('smooth_scroll') ){
        $wyde_page_settings['smooth_scroll'] = true;
    }

    wp_localize_script('gogreen-main', 'wyde_page_settings', $wyde_page_settings);

    wp_enqueue_script('smoothscroll', get_template_directory_uri() .'/js/smoothscroll.js', null, '1.1', true);   

}
add_action('wp_enqueue_scripts', 'gogreen_load_scripts');

/* Register and enqueue admin scripts */
function gogreen_load_admin_styles(){   
    
    // Register font icons
    wp_register_style('theme-icons', get_template_directory_uri() .'/css/icons.css', null, null);
    wp_enqueue_style('theme-icons');
    do_action( 'gogreen_enqueue_icon_font' );

}
add_action( 'admin_enqueue_scripts', 'gogreen_load_admin_styles');

/* Theme activation - update WooCommerce image sizes */
function gogreen_theme_activation()
{
    global $pagenow;
    if(is_admin() && 'themes.php' == $pagenow && isset($_GET['activated']))
    {   
        //update WooCommerce thumbnail sizes after theme activation
        update_option('shop_thumbnail_image_size', array('width' => 180, 'height' => 180, 'crop'    =>  true));
        update_option('shop_catalog_image_size', array('width' => 340, 'height' => 340, 'crop'  =>    true));
        update_option('shop_single_image_size', array('width' => 640, 'height' => 640, 'crop'   => true));
    }
}
add_action('admin_init','gogreen_theme_activation');

/* Register default function when plugin not activated */
function gogreen_register_functions() {
    if( !function_exists('is_woocommerce') ) {
        function is_woocommerce() { return false; }
    }
}
add_action('wp_head', 'gogreen_register_functions', 5);

/* Update post views */
function gogreen_track_post_views ($post_id) {
    if ( !is_single() ){
        return;
    }
    if ( empty ( $post_id ) ) {
        global $post;
        $post_id = $post->ID;   
    }
    gogreen_set_post_views($post_id);
}
add_action( 'wp_head', 'gogreen_track_post_views');

/* Advanced scripts from Theme Options */
function gogreen_custom_head_script(){   
    ob_start();
    include_once( get_template_directory() .'/css/custom-css.php' );
    $head_content = ob_get_clean();
    echo '<style type="text/css" data-name="gogreen-color-scheme">' .$head_content.'</style>';

    if( gogreen_get_option('head_script') ){
        /**
        *Extra HTML/JavaScript/Stylesheet from theme options > advanced - head content
        */
        echo apply_filters('gogreen_head_content', gogreen_get_option('head_script') );       
    } 
}
add_action('wp_head', 'gogreen_custom_head_script', 200);

/* Get body classes */
function gogreen_get_body_class( $classes ){
                        
        if( gogreen_get_option('onepage') ) $classes[] = 'onepage';

        $classes[] = gogreen_get_nav_layout() .'-nav';
        
        if( !gogreen_has_header() ){            
            $classes[] = 'no-header';
        }                 

        if( gogreen_has_top_bar() ){
            $classes[] = 'top-bar';
        }

        if( !gogreen_has_title_area() ){
            $classes[] = 'no-title';
        }

        return $classes;
}
add_filter( 'body_class', 'gogreen_get_body_class' );

/* Footer scripts/styles */
function gogreen_footer_content(){
    if( gogreen_get_option('footer_script') ){
        /**
        *Extra HTML/JavaScript/Stylesheet from theme options > advanced - body content
        */        
        echo apply_filters('gogreen_footer_content', gogreen_get_option('footer_script') );
    }
}
add_action('wp_footer', 'gogreen_footer_content');

/* Get viewport meta content */
function gogreen_get_viewport(){
    $output = 'width=device-width, initial-scale=1.0';
    if( !gogreen_get_option('mobile_zoom') ){
        $output .= ', maximum-scale=1.0, user-scalable=no';
    }   
    return apply_filters('gogreen_get_viewport', $output);
}

/* Custom favicon */
function gogreen_custom_favicon(){
    $output = '';
    if( gogreen_get_option('favicon_image') ) :
        $favicon_image = gogreen_get_option('favicon_image');
        $output .= '<link rel="icon" href="'. esc_url( $favicon_image['url'] ) .'" type="image/png" />';
    endif;

    if( gogreen_get_option('favicon') ):
        $favicon = gogreen_get_option('favicon');
        $output .= '<link rel="shortcut icon" href="'. esc_url( $favicon['url'] ) .'" type="image/x-icon" />';
    endif;

    if( gogreen_get_option('favicon_iphone') ):
        $favicon_iphone = gogreen_get_option('favicon_iphone');
        $output .= '<link rel="apple-touch-icon-precomposed" href="'. esc_url( $favicon_iphone['url'] ) .'" />';
    endif;

    if( gogreen_get_option('favicon_iphone_retina') ):
        $favicon_iphone_retina = gogreen_get_option('favicon_iphone_retina');
        $output .= '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="'. esc_url( $favicon_iphone_retina['url'] ) .'" />';
    endif;

    if( gogreen_get_option('favicon_ipad') ):
        $favicon_ipad = gogreen_get_option('favicon_ipad');
        $output .= '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="'. esc_url( $favicon_ipad['url'] ) .'" />';
    endif;

    if( gogreen_get_option('favicon_ipad_retina') ):
        $favicon_ipad_retina = gogreen_get_option('favicon_ipad_retina');
        $output .= '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="'. esc_url( $favicon_ipad_retina['url'] ) .'" />';
    endif;
    
    echo apply_filters('gogreen_custom_favicon', $output);
}

/* Page loader */
function gogreen_page_loader(){
    $output = '';
    if( gogreen_get_option('page_loader') && gogreen_get_option('page_loader') != 'none' ){
        $output = '<div id="preloader">'. gogreen_get_page_loader( gogreen_get_option('page_loader') ) .'</div>';
    }
    echo apply_filters('gogreen_page_loader', $output);
}

/* Navigation and Live search */
function gogreen_nav(){
    get_template_part( 'templates/navigation/side-nav' );
    get_template_part( 'templates/navigation/header-nav' );     
    get_template_part( 'templates/navigation/slidingbar' ); 
    echo '<div id="page-overlay"></div>';
    get_template_part( 'templates/navigation/live-search' );
}

/* Footer content */
function gogreen_footer(){

    $footer_content = gogreen_show_footer_content();
    $footer_bar = gogreen_show_footer_bar();

    ?>
    <footer id="footer">
    <?php

        $footer_page_id = gogreen_get_option('footer_page');

        if( $footer_content && !empty($footer_page_id) ){     

            if( function_exists('icl_object_id') ){
                $footer_page_id = icl_object_id($footer_page_id, 'page', true);
            }   
            
            $footer_page = get_post( $footer_page_id );

            if( $footer_page ) :

                $post_custom_css = get_post_meta( $footer_page_id, '_wpb_post_custom_css', true );
                if ( ! empty( $post_custom_css ) ) {
                    echo '<style type="text/css" data-type="vc_custom-css" scoped>'.$post_custom_css.'</style>';
                }

                $shortcodes_custom_css = get_post_meta( $footer_page_id, '_wpb_shortcodes_custom_css', true );
                if ( ! empty( $shortcodes_custom_css ) ) {
                    echo '<style type="text/css" data-type="vc_shortcodes-custom-css" scoped>'.$shortcodes_custom_css.'</style>';
                }        
                    
        ?>
        <div id="footer-content">
            <?php echo do_shortcode($footer_page->post_content); ?>
        </div>
        <?php
            endif;          
        }     

        if( $footer_bar ){
            get_template_part( 'templates/footers/footer', 'v'. intval( gogreen_get_option('footer_layout') ) );
        } 
        ?>
    </footer>
    <?php 
    
    if( gogreen_get_option('totop_button') ) : ?>
    <a id="toplink-button" href="#">
        <span class="border">
            <i class="gg-up"></i>
        </span>
    </a>
    <?php 
    endif;

}
add_action('wp_footer', 'gogreen_footer');

/* Walker Nav */
require_once( get_template_directory() .'/inc/class-walker-nav.php' );

/* Custom Functions */
require_once( get_template_directory() .'/inc/custom-functions.php' );

/* Theme Options */
require_once( get_template_directory() .'/admin/class-theme-options.php' );

/* Update portfolio slug */
function gogreen_update_portfolio_slug(){
    return gogreen_get_option('portfolio_single_slug');
}
add_filter('wyde_portfolio_slug', 'gogreen_update_portfolio_slug');

/* Metaboxes */
require_once( get_template_directory() .'/inc/class-metabox.php' );

/* Shortcodes */
require_once( get_template_directory() .'/inc/class-shortcode.php' );

/* Widgets */
require_once( get_template_directory() .'/inc/class-widget.php' );

if( is_admin() && function_exists('wyde_include_ajax_search') ){
    wyde_include_ajax_search();
}

if( class_exists('WooCommerce') ){
    /* WooCommerce Template class */
    require_once( get_template_directory() .'/inc/class-woocommerce-template.php' );
}

/* TGM Plugin Activation */
require_once( get_template_directory() .'/inc/class-tgm-plugin-activation.php' );

/* Register the required plugins for this theme. */
function gogreen_register_required_plugins() {
    //Bundled plugins.
    $plugins = array(
        array(
            'name'                  => 'Wyde Core', 
            'slug'                  => 'wyde-core', 
            'source'                => get_template_directory() .'/inc/plugins/wyde-core.zip',
            'required'              => true, 
            'version'               => '3.5.5', 
            'force_activation'      => false,
            'force_deactivation'    => false, 
            'external_url'          => '', 
        ),
        array(
            'name'                  => 'WPBakery Visual Composer', 
            'slug'                  => 'js_composer', 
            'source'                => get_template_directory() .'/inc/plugins/js_composer.zip',
            'required'              => false, 
            'version'               => '5.1.1', 
            'force_activation'      => false,
            'force_deactivation'    => false, 
            'external_url'          => '', 
        ),
        array(
            'name'                  => 'Slider Revolution', 
            'slug'                  => 'revslider', 
            'source'                => get_template_directory() .'/inc/plugins/revslider.zip',
            'required'              => false, 
            'version'               => '5.4.5.1',
            'force_activation'      => false, 
            'force_deactivation'    => false, 
            'external_url'          => '',
        ),
        array(
            'name'                  => 'Contact Form 7',
            'slug'                  => 'contact-form-7',
            'required'              => false,
            'version'               => '4.3.1',
            'force_activation'      => false,
            'force_deactivation'    => false
        )
    );
    
    // Configuration settings.
    $config = array(
        'id'           => 'gogreen',               // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'install-bundled-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings' => array(
                'page_title'  => esc_html__( 'Install Bundled Plugins', 'gogreen' )
        ),  
        
    );

    tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'gogreen_register_required_plugins' );