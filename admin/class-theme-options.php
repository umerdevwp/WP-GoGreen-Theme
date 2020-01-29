<?php
    
if( function_exists('wyde_include_theme_options') ) {
    wyde_include_theme_options();
}

/** Theme Options **/
if (!class_exists('GoGreen_Theme_Options')) {

    class GoGreen_Theme_Options {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if ( !class_exists('ReduxFramework') ) {
                return;
            }

            $this->initSettings();
            add_action( "redux/options/{$this->args['opt_name']}/saved", array($this, 'settings_saved'), 10, 2 );
            add_action('init', array($this, 'update_slug'), 10);           

        }        

        public function initSettings() {

            $this->theme = wp_get_theme();

            $this->setArguments();

            $this->setSections();

            if (!isset($this->args['opt_name'])) {
                return;
            }

            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        public function settings_saved($options, $changes){
            if( array_key_exists('portfolio_slug', $changes) ){
                echo '<script type="text/javascript">window.location.href=window.location.pathname+"?page=theme-options&slug-updated=true";</script>';
            }
        }

        public function update_slug(){
            global $pagenow;
            $slug_updated = isset( $_GET['slug-updated'] )? $_GET['slug-updated']:'';
            if( $slug_updated == 'true' ){
                flush_rewrite_rules();
                wp_redirect( admin_url( $pagenow.'?page=theme-options&settings-updated=true' ) );
            }
        }

        function remove_demo() {
            if ( class_exists('ReduxFrameworkPlugin') ) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }
        
        public function setSections() {

            $allowed_html = array(
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'target' => array()
                ),
                'br' => array(),
                'em' => array(),
                'strong' => array(),
            );

            /***************************** 
            * Home
            ******************************/
            $import_fields = array(
                array(
                    'id'        => 'section_import_content',
                    'type'      => 'section',
                    'title'     => esc_html__('Import Demo Content', 'gogreen'),
                    'subtitle'  => esc_html__('Please make sure you have required plugins installed and activated to receive that portion of the content. This is recommended to do on fresh installs.', 'gogreen'),
                    'indent'    => true
                ),
                array(
                    'id'        => 'notice-warning',
                    'type'      => 'info',
                    'notice'    => true,
                    'style'     => 'warning',
                    'icon'      => 'el el-warning-sign',
                    'title'     => esc_html__('WARNING:', 'gogreen'),
                    'desc'      => wp_kses( __('Import demo content requires <strong>GoGreen Demo Content</strong> plugin. Please make sure you have this plugin installed and activated. See more details in our documentation.', 'gogreen'), $allowed_html )
                    ),
            );


            if( class_exists('GoGreen_Demo_Content') ){

                $gogreen_importer = new GoGreen_Demo_Content();

                ob_start();
                $gogreen_importer->load_screen();
                $import_content_html = ob_get_clean();

            
                $import_fields = array(
                        array(
                            'id'        => 'section_import_content',
                            'type'      => 'section',
                            'title'     => esc_html__('Import Demo Content', 'gogreen'),
                            'subtitle'  => esc_html__('Please make sure you have required plugins installed and activated to receive that portion of the content. This is recommended to do on fresh installs.', 'gogreen'),
                            'indent'    => true
                        ),
                        array(
                            'id'        => 'notice-warning',
                            'type'      => 'info',
                            'notice'    => true,
                            'style'     => 'warning',
                            'icon'      => 'el el-warning-sign',
                            'title'     => esc_html__('WARNING:', 'gogreen'),
                            'desc'      => wp_kses( __('1. The Importing will append your current <strong>Pages, Posts and other content types</strong>, you should import them only once.
                                    <br />2. You can use <a href="https://wordpress.org/plugins/wordpress-reset/" target="_blank">WordPress Reset</a> plugin to remove all existing data before importing.', 'gogreen'), $allowed_html )
                        ),
                        array(
                            'id'        => 'raw_import_content',
                            'type'      => 'raw',
                            'content'   => $import_content_html,
                        ),
                );

            }

            $imported = isset( $_GET['imported'] )? $_GET['imported']:'';
            
            if($imported == 'success' ){
                
                 array_unshift($import_fields, array(
                        'id'        => 'notice-success',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'success',
                        'icon'      => 'el el-info-circle',
                        'title'     => esc_html__('Success!', 'gogreen'),
                        'desc'      => esc_html__('The demo content has been successfully imported.', 'gogreen')
                ));

            }else if($imported == 'error' ){
                
                array_unshift($import_fields, array(
                        'id'        => 'notice-fail',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'el el-info-circle',
                        'title'     => esc_html__('ERROR!', 'gogreen'),
                        'desc'      => esc_html__('An error occurred while importing demo data, please try again later.', 'gogreen')
                ));

            }
            
            $this->sections['home'] = array(
                'title'     => esc_html__('Home', 'gogreen'),
                'heading'   => false,
                'icon'      => 'el-icon-home',
                'fields'    => $import_fields
            );



            /***************************** 
            * General
            ******************************/
            $predefined_colors = array();
            for($i = 1; $i <= 10; $i ++){
                $predefined_colors[strval($i)] = array('alt' => '',  'img' => get_template_directory_uri() . '/images/colors/'.$i.'.png');
            }

            $this->sections['general'] = array(
                'icon'      => 'el el-adjust-alt',
                'title'     => esc_html__('General', 'gogreen'),
                'heading'   => false,
                'fields'    => array(
                   array(
                        'id'        => 'predefined_color',
                        'type'      => 'image_select',
                        'title'     => esc_html__('Color Scheme', 'gogreen'),
                        'subtitle'  => esc_html__('Select your website color scheme from predefined colors.', 'gogreen'),
                        'options'   => $predefined_colors,
                        'default'   => '1'
                   ),
                   array(
                        'id'        => 'custom_color',
                        'type'      => 'switch',
                        'title'     => esc_html__('Custom Color Scheme', 'gogreen'),
                        'subtitle'  => esc_html__('Use custom color from color picker.', 'gogreen'),
                        'default'   => false
                   ),
                   array(
                        'id'        => 'color_scheme',
                        'type'      => 'color',
                        'title'     => esc_html__('Color Scheme', 'gogreen'),
                        'subtitle'  => esc_html__('Choose your own color scheme.', 'gogreen'),
                        'required'  => array('custom_color', '=', true),
                        'transparent'   => false,
                        'default'   => '#8accff'
                    ),
                    array(
                        'id'        => 'smooth_scroll',
                        'type'      => 'switch',
                        'title'     => esc_html__('Smooth Scrolling', 'gogreen'),
                        'subtitle'  => esc_html__('Enable the smooth scrolling.', 'gogreen'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'lightbox_title',
                        'type'      => 'switch',
                        'title'     => esc_html__('Lightbox Title', 'gogreen'),
                        'subtitle'  => esc_html__('Display the lightbox title.', 'gogreen'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'preload_images',
                        'type'      => 'switch',
                        'title'     => esc_html__('Preload Images', 'gogreen'),
                        'subtitle'  => esc_html__('Preloading images definitely helps users enjoy a better experience when viewing your content.', 'gogreen'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'page_loader',
                        'type'      => 'image_select',
                        'title'     => esc_html__('Loader', 'gogreen'),
                        'subtitle'  => esc_html__('Select a loader animation.', 'gogreen'),
                        'options'   => array(
                            'none' => array('alt' => '', 'img' => get_template_directory_uri() . '/images/loaders/0.jpg'),
                            '1' => array('alt' => '', 'img' => get_template_directory_uri() . '/images/loaders/1.jpg'),
                            '2' => array('alt' => '',  'img' => get_template_directory_uri() . '/images/loaders/2.jpg'),
                            '3' => array('alt' => '', 'img' => get_template_directory_uri() . '/images/loaders/3.jpg'),
                        ),
                        'default'   => '1',
                    ),
                    array(
                        'id'        => 'page_loader_image',
                        'type'      => 'media',
                        'title'     => esc_html__('Loader Icon', 'gogreen'),
                        'required'  => array('page_loader', '=', '3'),
                        'height'    => '45px',
                        'subtitle'  => esc_html__('Loader image to display at the center of the loader animation.', 'gogreen'),
                        'desc'      => esc_html__('Maximum height: 70px.', 'gogreen'),
                        'default'   => array(        
                                    'url'=> get_template_directory_uri() .'/images/favicon.png'
                        )
                    ),
                    array(
                        'id'        => 'totop_button',
                        'type'      => 'switch',
                        'title'     => esc_html__('Back To Top Button', 'gogreen'),
                        'subtitle'  => esc_html__('Enable a back to top button.', 'gogreen'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'mobile_animation',
                        'type'      => 'switch',
                        'title'     => esc_html__('Animation on Mobile', 'gogreen'),
                        'subtitle'  => esc_html__('Enable animated elements on mobile devices.', 'gogreen'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'mobile_zoom',
                        'type'      => 'switch',
                        'title'     => esc_html__('Page Zooming on Mobile', 'gogreen'),
                        'subtitle'  => esc_html__('Allow users to zoom in and out on website.', 'gogreen'),
                        'default'   => false,
                    ),
                 )
            );

            /***************************** 
            * Favicon
            ******************************/
            // If it is older than WordPress 4.3
            if ( ! ( function_exists( 'wp_site_icon' ) ) ) {

                $this->sections['favicon'] = array(
                    'icon'      => 'el-icon-star',
                    'title'     => esc_html__('Favicon', 'gogreen'),
                    'heading'   => false,
                    'fields'    => array(
                        array(
                            'id'        => 'section_favicon',
                            'type'      => 'section',
                            'title'     => esc_html__('Favicon', 'gogreen'),
                            'subtitle'  => esc_html__('Customize a favicon for your site.', 'gogreen'),
                            'indent'    => true
                        ),
                        array(
                            'id'        => 'favicon_image',
                            'type'      => 'media',
                            'title'     => esc_html__('Favicon Image (.PNG)', 'gogreen'),
                            'subtitle'  => esc_html__('Upload a favicon image for your site, or you can specify an image URL directly.', 'gogreen'),
                            'desc'      => esc_html__('Icon dimension:', 'gogreen').' 16px * 16px or 32px * 32px',
                            'default'   => array(        
                                                'url'=> get_template_directory_uri() .'/images/favicon.png'
                            ),
                        ),
                        array(
                            'id'        => 'favicon',
                            'type'      => 'media',
                            'title'     => esc_html__('Favicon (.ICO)', 'gogreen'),
                            'subtitle'  => esc_html__('Upload a favicon for your site, or you can specify an icon URL directly.', 'gogreen'),
                            'desc'      => esc_html__('Icon dimension:', 'gogreen').' 16px * 16px',

                        ),
                        array(
                            'id'        => 'favicon_iphone',
                            'type'      => 'media',
                            'title'     => esc_html__('Apple iPhone Icon', 'gogreen'),
                            'height'    => '57px',
                            'subtitle'  => esc_html__('Favicon for Apple iPhone.', 'gogreen'),
                            'desc'      => esc_html__('Icon dimension:', 'gogreen').' 57px * 57px',
                        ),
                        array(
                            'id'        => 'favicon_iphone_retina',
                            'type'      => 'media',
                            'title'     => esc_html__('Apple iPhone Icon (Retina Version)', 'gogreen'),
                            'height'    => '57px',
                            'subtitle'  => esc_html__('Favicon for Apple iPhone Retina Version.', 'gogreen'),
                            'desc'      => esc_html__('Icon dimension:', 'gogreen').' 114px  * 114px',
                        ),
                        array(
                            'id'        => 'favicon_ipad',
                            'type'      => 'media',
                            'title'     => esc_html__('Apple iPad Icon', 'gogreen'),
                            'height'    => '72px',
                            'subtitle'  => esc_html__('Favicon for Apple iPad.', 'gogreen'),
                            'desc'      => esc_html__('Icon dimension:', 'gogreen').' 72px * 72px',
                        ),
                        array(
                            'id'        => 'favicon_ipad_retina',
                            'type'      => 'media',
                            'title'     => esc_html__('Apple iPad Icon (Retina Version)', 'gogreen'),
                            'height'    => '57px',
                            'subtitle'  => esc_html__('Favicon for Apple iPad Retina Version.', 'gogreen'),
                            'desc'      => esc_html__('Icon dimension:', 'gogreen').' 144px  * 144px',
                        )
                ));
            }

            /***************************** 
            * Navigation
            ******************************/
            $this->sections['nav'] = array(
                'icon'      => 'el-icon-lines',
                'title'     => esc_html__('Navigation', 'gogreen'),
                'heading'   => false,
                'fields'    => array(
                    array(
                        'id'        => 'section_nav',
                        'type'      => 'section',
                        'title'     => esc_html__('Navigation', 'gogreen'),
                        'subtitle'  => esc_html__('Customize the primary navigation.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'nav_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Layout', 'gogreen'),
                        'subtitle'  => esc_html__('Select a navigation layout.', 'gogreen'),
                        'options'   => array(
                            'classic'   => esc_html__('Classic', 'gogreen'),
                            'center'      => esc_html__('Center', 'gogreen'),
                        ),
                        'default'   => 'classic'
                    ),
                    array(
                        'id'        => 'menu_shop_cart',
                        'type'      => 'switch',
                        'title'     => esc_html__('Shopping Cart Icon', 'gogreen'),
                        'subtitle'  => esc_html__('Turn on to display the shopping cart icon.', 'gogreen'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'menu_search_icon',
                        'type'      => 'switch',
                        'title'     => esc_html__('Search Icon', 'gogreen'),
                        'subtitle'  => esc_html__('Turn on to display the search icon.', 'gogreen'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'slidingbar',
                        'type'      => 'switch',
                        'title'     => esc_html__('Sliding Bar', 'gogreen'),
                        'subtitle'  => esc_html__('Turn on to display a sliding widget area.', 'gogreen'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'menu_contact',
                        'type'      => 'switch',
                        'title'     => esc_html__('Contact Info', 'gogreen'),
                        'subtitle'  => esc_html__('Display contact info in sliding widget area and mobile menu.', 'gogreen'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'menu_social_icon',
                        'type'      => 'switch',
                        'title'     => esc_html__('Social Media Icons', 'gogreen'),
                        'subtitle'  => esc_html__('Display social media icons in sliding widget area and mobile menu.', 'gogreen'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'section_header',
                        'type'      => 'section',
                        'title'     => esc_html__('Top Navigation', 'gogreen'),
                        'subtitle'  => esc_html__('Customize the page header and top menu.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'header_top',
                        'type'      => 'switch',
                        'title'     => esc_html__('Top Bar Menu', 'gogreen'),
                        'subtitle'  => esc_html__('Display top bar menu.', 'gogreen'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'header_top_left',
                        'type'      => 'select',
                        'required'  => array('header_top', '=', 1),
                        'title'     => esc_html__('Left Side', 'gogreen'),
                        'subtitle'  => esc_html__('Select top bar left menu.', 'gogreen'),
                        'options'   => array(
                            'none' => esc_html__('None', 'gogreen'),
                            'contact'  => esc_html__('Contact Info', 'gogreen'),                            
                            'social'  => esc_html__('Social Media Icons', 'gogreen'),
                        ),
                        'default'   => 'contact'
                    ),
                    array(
                        'id'        => 'header_top_right',
                        'type'      => 'select',
                        'required'  => array('header_top', '=', 1),
                        'title'     => esc_html__('Right Side', 'gogreen'),
                        'subtitle'  => esc_html__('Select top bar right menu.', 'gogreen'),
                        'options'   => array(
                            'none' => esc_html__('None', 'gogreen'),
                            'contact'  => esc_html__('Contact Info', 'gogreen'),                            
                            'social'  => esc_html__('Social Media Icons', 'gogreen'),
                        ),
                        'default'   => 'social'
                    ),
                    array(
                        'id'        => 'header_sticky',
                        'type'      => 'switch',
                        'title'     => esc_html__('Sticky Header', 'gogreen'),
                        'subtitle'  => esc_html__('Enable sticky header.', 'gogreen'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'header_fullwidth',
                        'type'      => 'switch',
                        'title'     => esc_html__('Full Width', 'gogreen'),
                        'subtitle'  => esc_html__('Turn on to use full width header or off to use fixed header width.', 'gogreen'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'header_style',
                        'type'      => 'select',
                        'title'     => esc_html__('Header Background', 'gogreen'),
                        'subtitle'  => esc_html__('Select a header navigation background style.', 'gogreen'),
                        'options'   => array(
                            'light' => esc_html__('Light', 'gogreen'),
                            'dark'  => esc_html__('Dark', 'gogreen'),
                        ),
                        'default'   => 'light'
                    ),
                    array(
                        'id'        => 'header_logo',
                        'type'      => 'switch',
                        'title'     => esc_html__('Header Logo', 'gogreen'),
                        'subtitle'  => esc_html__('Turn on to display logo in the top navigation.', 'gogreen'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'header_logo_dark',
                        'type'      => 'media',
                        'required'  => array('header_logo', '=', 1),
                        'title'     => esc_html__('Dark Logo', 'gogreen'),
                        'height'    => '45px',
                        'subtitle'  => esc_html__('Dark color of logo for light header.', 'gogreen'),
                        'desc'      => esc_html__('Recommended height: 88px or larger, and max width: 320px.', 'gogreen'),
                        'default'   => array(        
                                    'url'=> get_template_directory_uri() .'/images/logo/logo.png'
                        )
                    ),
                    array(
                        'id'        => 'header_logo_dark_sticky',
                        'type'      => 'media',
                        'required'  => array('header_logo', '=', 1),
                        'title'     => esc_html__('Dark Sticky Logo', 'gogreen'),
                        'height'    => '45px',
                        'subtitle'  => esc_html__('Dark color of sticky header logo for light header.', 'gogreen'),
                        'desc'      => esc_html__('Recommended height: 70px or larger, and max width: 320px.', 'gogreen'),
                        'default'   => array(        
                                    'url'=> get_template_directory_uri() .'/images/logo/logo-sticky.png'
                        ),
                    ),
                    array(
                        'id'        => 'header_logo_light',
                        'type'      => 'media',
                        'required'  => array('header_logo', '=', 1),
                        'title'     => esc_html__('Light Logo', 'gogreen'),
                        'height'    => '45px',
                        'subtitle'  => esc_html__('Light color of logo for dark header.', 'gogreen'),
                        'desc'      => esc_html__('Recommended height: 88px or larger, and max width: 320px.', 'gogreen'),
                        'default'   => array(        
                                    'url'=> get_template_directory_uri() .'/images/logo/logo-light.png'
                        ),
                    ),
                    array(
                        'id'        => 'header_logo_light_sticky',
                        'type'      => 'media',
                        'required'  => array('header_logo', '=', 1),
                        'title'     => esc_html__('Light Sticky Logo', 'gogreen'),
                        'height'    => '45px',
                        'subtitle'  => esc_html__('Light color of sticky logo for dark header.', 'gogreen'),
                        'desc'      => esc_html__('Recommended height: 70px or larger, and max width: 320px.', 'gogreen'),
                        'default'   => array(        
                                    'url'=> get_template_directory_uri() .'/images/logo/logo-light-sticky.png'
                        ),
                    ),
                    array(
                        'id'        => 'section_sidenav',
                        'type'      => 'section',
                        'title'     => esc_html__('Mobile Navigation', 'gogreen'),
                        'subtitle'  => esc_html__('Customize the mobile navigation.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'side_nav_text_style',
                        'type'      => 'select',
                        'title'     => esc_html__('Text Style', 'gogreen'),
                        'subtitle'  => esc_html__('Select navigation text style.', 'gogreen'),
                        'options'   => array(
                            'dark'  => esc_html__('Dark', 'gogreen'),
                            'light' => esc_html__('Light', 'gogreen'),
                            'custom'=> esc_html__('Custom', 'gogreen'),
                        ),
                        'default'   => 'light'
                    ),
                    array(
                        'id'        => 'side_nav_color',
                        'type'      => 'color',
                        'required'  => array('side_nav_text_style', '=', 'custom'),
                        'title'     => esc_html__('Text Color', 'gogreen'),
                        'subtitle'  => esc_html__('Set navigation text color.', 'gogreen'),
                        'transparent' => false,
                        'output'    => array('#side-nav'),
                        'default'   => '#fff',
                    ),
                    array(
                        'id'        => 'side_nav_background',
                        'type'      => 'background',
                        'title'     => esc_html__('Background', 'gogreen'),
                        'subtitle'  => esc_html__('Set a side nav background.', 'gogreen'),
                        'output'    => array('#side-nav'),
                        'background-repeat' => false,
                        'background-attachment' =>false,
                        'default'   => array(
                            'background-color'   => '#211F1E',
                            'background-size'   => 'cover',
                            'background-position'   => 'center bottom'
                        ),
                    ),
                    array(
                        'id'        => 'side_nav_overlay_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Background Overlay Color', 'gogreen'),
                        'subtitle'  => esc_html__('Select background overlay color.', 'gogreen'),
                        'default'  => '',
                        'validate' => 'color',
                    ),
                    array(
                        'id'        => 'side_nav_overlay_opacity',
                        'type'      => 'select',
                        'title'     => esc_html__('Background Overlay Opacity', 'gogreen'),
                        'subtitle'  => esc_html__('Select background overlay opacity.', 'gogreen'),
                        'options'   => array(
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
                        'default'  => '0.8',
                    )
                 )
            );


            /***************************** 
            * Footer
            ******************************/
            $this->sections['footer'] = array(
                'icon'      => 'el-icon-th-large',
                'title'     => esc_html__('Footer', 'gogreen'),
                'heading'   => false,
                'fields'    => array(
                    array(
                        'id'        => 'section_footer_content',
                        'type'      => 'section',
                        'title'     => esc_html__('Footer Content', 'gogreen'),
                        'subtitle'  => esc_html__('Customize the footer content.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'footer_content',
                        'type'      => 'switch',
                        'title'     => esc_html__('Footer Content', 'gogreen'),
                        'subtitle'  => esc_html__('Display footer content area.', 'gogreen'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'footer_page',
                        'type'      => 'select',
                        'required'  => array('footer_content', '=', 1),
                        'title'     => esc_html__('Page', 'gogreen'),
                        'subtitle'  => esc_html__('Select a page to display in the footer content area.', 'gogreen'),          
                        'data'      => 'pages',
                        'args' => array(
                            'post_status' => array('publish', 'private')
                        )
                    ),
                    array(
                        'id'        => 'section_footer_bottom',
                        'type'      => 'section',
                        'title'     => esc_html__('Footer Bar', 'gogreen'),
                        'subtitle'  => esc_html__('Customize the footer bar.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'footer_bar',
                        'type'      => 'switch',
                        'title'     => esc_html__('Footer Bar', 'gogreen'),
                        'subtitle'  => esc_html__('Display a footer bar at the bottom of the page.', 'gogreen'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'footer_bar_full',
                        'type'      => 'switch',
                        'required'  => array('footer_bar', '=', 1),
                        'title'     => esc_html__('Full Width', 'gogreen'),
                        'subtitle'  => esc_html__('Display a footer bar as full width.', 'gogreen'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'footer_bar_color',
                        'type'      => 'color',
                        'required'  => array('footer_bar', '=', 1),
                        'title'     => esc_html__('Text Color', 'gogreen'),
                        'subtitle'  => esc_html__('Set a footer bar text color.', 'gogreen'),
                        'transparent' => false,
                        'output'    => array('#footer-bottom'),
                        'default'   => '',
                    ),
                    array(
                        'id'        => 'footer_bar_background',
                        'type'      => 'background',
                        'required'  => array('footer_bar', '=', 1), 
                        'title'     => esc_html__('Background', 'gogreen'),
                        'subtitle'  => esc_html__('Set a footer bar background.', 'gogreen'),
                        'output'    => array('#footer-bottom'),
                        'background-repeat' => false,
                        'background-attachment' =>false,
                        'default'   => array(
                            'background-color'  => '#000',
                            'background-size'   => 'cover',
                            'background-position'   => 'center bottom'
                        ),
                    ),
                    array(
                        'id'        => 'footer_layout',
                        'type'      => 'image_select',
                        'required'  => array('footer_bar', '=', 1),
                        'title'     => esc_html__('Layout', 'gogreen'),
                        'subtitle'  => esc_html__('Select footer bar layout.', 'gogreen'),
                        'options'   => array(
                            '1' => array('alt' => 'Center', 'img' => get_template_directory_uri() . '/images/footers/1.jpg'),
                            '2' => array('alt' => 'Small', 'img' => get_template_directory_uri() . '/images/footers/2.jpg'),
                            '3' => array('alt' => 'Medium', 'img' => get_template_directory_uri() . '/images/footers/3.jpg'),
                        ),
                        'default'   => '2'
                    ),
                    array(
                        'id'        => 'footer_logo',
                        'type'      => 'switch',
                        'required'  => array('footer_bar', '=', 1),
                        'title'     => esc_html__('Footer Logo', 'gogreen'),
                        'subtitle'  => esc_html__('Display footer logo.', 'gogreen'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'footer_logo_image',
                        'type'      => 'media',
                        'required'  => array('footer_logo', '=', 1),
                        'title'     => esc_html__('Footer Logo Image', 'gogreen'),
                        'height'    => '45px',
                        'subtitle'  => esc_html__('Upload a footer logo image.', 'gogreen'),
                        'default'   => array(        
                                            'url'=> get_template_directory_uri() .'/images/logo/footer-logo.png'
                        ),
                    ),
                    array(
                        'id'        => 'footer_menu',
                        'type'      => 'switch',
                        'required'  => array('footer_bar', '=', 1),
                        'title'     => esc_html__('Footer Menu', 'gogreen'),
                        'subtitle'  => esc_html__('Display footer menu.', 'gogreen'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'footer_social',
                        'type'      => 'switch',
                        'required'  => array('footer_bar', '=', 1),
                        'title'     => esc_html__('Social Icons', 'gogreen'),
                        'subtitle'  => esc_html__('Display social icons.', 'gogreen'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'footer_text',
                        'type'      => 'switch',
                        'required'  => array('footer_bar', '=', 1),
                        'title'     => esc_html__('Footer Text', 'gogreen'),
                        'subtitle'  => esc_html__('Display footer text.', 'gogreen'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'footer_text_content',
                        'type'      => 'editor',
                        'required'  => array('footer_text', '=', 1),
                        'args'   => array(
                            'teeny'            => false,
                            'textarea_rows'    => 3
                        ),
                        'default'   => '&copy;'. date('Y') .' GoGreen - Premium WordPress Theme. Powered by <a href="https://wordpress.org/" target="_blank">WordPress</a>.',
                    )
                )
            );

            
            /***************************** 
            * Title Area
            ******************************/
            $this->sections['title_area'] = array(
                'icon'      => 'el-icon-photo',
                'title'     => esc_html__('Title Area', 'gogreen'),
                'heading'     => false,
                'fields'    => array(
                    array(
                        'id'        => 'section_page_title',
                        'type'      => 'section',
                        'title'     => esc_html__('Title Area', 'gogreen'),
                        'subtitle'  => esc_html__('Default settings for title area.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'title_size',
                        'type'      => 'select',
                        'title'     => esc_html__('Size', 'gogreen'),
                        'subtitle'  => esc_html__('Select the title size.', 'gogreen'),
                        'options'   => array(
                            's' => esc_html__('Small', 'gogreen'),
                            'm' => esc_html__('Medium', 'gogreen'),
                            'l'=> esc_html__('Large', 'gogreen'),
                            'full'=> esc_html__('Full Screen', 'gogreen')
                        ),
                        'default'   => 's',
                    ),
                    array(
                        'id'        => 'title_scroll_effect',
                        'type'      => 'select',
                        'title'     => esc_html__('Scrolling Effect', 'gogreen'),
                        'subtitle'  => esc_html__('Select a scrolling animation for title text and subtitle.', 'gogreen'),
                        'options'   => array(
                            'none' => esc_html__('None', 'gogreen'), 
                            'split' => esc_html__('Split', 'gogreen'),
                            'fadeOut' => esc_html__('Fade Out', 'gogreen'), 
                            'fadeOutUp' => esc_html__('Fade Out Up', 'gogreen'), 
                            'fadeOutDown' => esc_html__('Fade Out Down', 'gogreen'), 
                            'zoomIn' => esc_html__('Zoom In', 'gogreen'), 
                            'zoomInUp' => esc_html__('Zoom In Up', 'gogreen'), 
                            'zoomInDown' => esc_html__('Zoom In Down', 'gogreen'), 
                            'zoomOut' => esc_html__('Zoom Out', 'gogreen'), 
                            'zoomOutUp' => esc_html__('Zoom Out Up', 'gogreen'), 
                            'zoomOutDown' => esc_html__('Zoom Out Down', 'gogreen'), 
                        ),
                        'default' => 'fadeOut',
                    ),
                    array(
                        'id'       => 'title_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Text Color', 'gogreen'), 
                        'subtitle' => esc_html__( 'Select the title text color.', 'gogreen' ),
                        'transparent'   => false,
                        'default'  => '',
                        'validate' => 'color',
                    ),
                    array(
                        'id'        => 'title_align',
                        'type'      => 'select',
                        'title'     => esc_html__('Alignment', 'gogreen'),
                        'subtitle'  => esc_html__('Select the title alignment.', 'gogreen'),
                        'options'   => array(
                            'none'  => esc_html__('Not Set', 'gogreen'),
                            'left'  => esc_html__('Left', 'gogreen'),
                            'center' => esc_html__('Center', 'gogreen'),
                            'right' => esc_html__('Right', 'gogreen')
                        ),
                        'default'   => 'none',
                    ),
                    array(
                        'id'        => 'title_background_mode',
                        'type'      => 'select',
                        'title'     => esc_html__('Background', 'gogreen'),
                        'subtitle'  => esc_html__('Select background type.', 'gogreen'),
                        'options'   => array(
                            'none' => esc_html__('None', 'gogreen'),
                            'color' => esc_html__('Color', 'gogreen'),
                            'image' => esc_html__('Image', 'gogreen'),
                            'video'=> esc_html__('Video', 'gogreen')
                        ),
                        'default'   => 'color',
                    ),
                    array(
                        'id'        => 'title_background_image',
                        'type'      => 'background',
                        'required'  =>  array(
                                            array('title_background_mode', '!=', 'none'),
                                            array('title_background_mode', '!=', 'color')
                                    ),
                        'title'     => esc_html__('Background Image', 'gogreen'),
                        'background-color' => false,
                        'background-attachment' => false,
                        'background-repeat' => false,
                        'background-position' => false,
                        'subtitle'  => esc_html__('Customize background image.', 'gogreen'),
                        'default'   => array(
                            'background-size' => 'cover',
                        )
                    ),
                    array(
                        'id'        => 'title_background_video',
                        'type'      => 'media',
                        'required'  => array('title_background_mode', '=', 'video'),
                        'title'     => esc_html__('Background Video', 'gogreen'),
                        'subtitle'  => esc_html__('Select an MP4 video to display as title background.', 'gogreen'),
                        'mode'      => false,
                    ),
                    array(
                        'id'        => 'title_background_color',
                        'type'      => 'color',
                        'required'  => array('title_background_mode', '!=', 'none'),
                        'title'     => esc_html__('Background Color', 'gogreen'),
                        'subtitle'  => esc_html__('Select a background color.', 'gogreen'),
                        'default'   => '',
                    ),
                    array(
                        'id'       => 'title_overlay_color',
                        'type'     => 'color',
                        'required'  =>  array(
                                            array('title_background_mode', '!=', 'none'),
                                            array('title_background_mode', '!=', 'color')
                                    ),
                        'title'    => esc_html__('Background Overlay Color', 'gogreen'), 
                        'subtitle' => esc_html__( 'Select background overlay color.', 'gogreen' ),
                        'default'  => '#211F1E',
                        'validate' => 'color',
                    ),
                    array(
                        'id'        => 'title_overlay_opacity',
                        'type'      => 'select',
                        'required'  =>  array(
                                            array('title_background_mode', '!=', 'none'),
                                            array('title_background_mode', '!=', 'color')
                                    ),
                        'title'     => esc_html__('Background Overlay Opacity', 'gogreen'),
                        'subtitle'  => esc_html__('Select background overlay opacity.', 'gogreen'),
                        'options'   => array(
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
                        'default' => '0.8',
                    ),
                    array(
                        'id'        => 'title_background_effect',
                        'type'      => 'select',
                        'required'  =>  array(
                                            array('title_background_mode', '!=', 'none'),
                                            array('title_background_mode', '!=', 'color')
                                    ),
                        'title'     => esc_html__('Background Effect', 'gogreen'),
                        'subtitle'  => esc_html__('Select background scrolling effect.', 'gogreen'),
                        'options'   => array(
                            'none' => esc_html__('None', 'gogreen'),                             
                            'fadeOut' => esc_html__('Fade Out', 'gogreen'),          
                            'parallax' => esc_html__('Parallax', 'gogreen'),                   
                        ),
                        'default' => 'parallax',
                    ),

            ) );

            /***************************** 
            * Page
            ******************************/
            $this->sections['page'] = array(
                'icon'      => 'el-icon-website',
                'title'     => esc_html__('Page', 'gogreen'),
                'heading'     => false,
                'fields'    => array(
                    array(
                        'id'        => 'section_page_options',
                        'type'      => 'section',
                        'title'     => esc_html__('Page Options', 'gogreen'),
                        'subtitle'  => esc_html__('Choose default options for page.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'onepage',
                        'type'      => 'switch',
                        'title'     => esc_html__('One Page Website', 'gogreen'),
                        'subtitle'  => esc_html__('Create One Page website, your frontpage will retrieve page content from primary menu automatically.', 'gogreen'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'page_comments',
                        'type'      => 'switch',
                        'title'     => esc_html__('Comments', 'gogreen'),
                        'subtitle'  => esc_html__('Allow comments on Regular WordPress pages (Boxed Layout).', 'gogreen'),
                        'default'   => true,
                    )

                )
            );


            /***************************** 
            * Blog
            ******************************/
            $this->sections['blog'] = array(
                'icon'      => 'el-icon-edit',
                'title'     => esc_html__('Blog', 'gogreen'),
                'heading'   => false,
                'fields'    => array(
                    array(
                        'id'        => 'section_blog',
                        'type'      => 'section',
                        'title'     => esc_html__('Blog', 'gogreen'),
                        'subtitle'  => esc_html__('Customize Posts page that displays your latest posts.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'blog_page_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Page Layout', 'gogreen'),
                        'subtitle'  => esc_html__('Select a page layout, choose \'Boxed\' to create a Regular WordPress page, Wide for creating a Full Width page.', 'gogreen'),
                        'options'   => array(                            
                            'boxed' => esc_html__('Boxed', 'gogreen'),
                            'wide' => esc_html__('Wide', 'gogreen'),
                        ),
                        'default'   => 'boxed'

                    ),
                    array(
                        'id'        => 'blog_sidebar',
                        'type'      => 'image_select',
                        'title'     => esc_html__('Sidebar', 'gogreen'),
                        'subtitle'  => esc_html__('Select sidebar position.', 'gogreen'),
                        'options'   => array(
                            '1' => array('alt' => 'No Sidebar', 'img' => get_template_directory_uri() . '/images/columns/1.png'),
                            '2' => array('alt' => 'One Left', 'img' => get_template_directory_uri() . '/images/columns/2.png'),
                            '3' => array('alt' => 'One Right', 'img' => get_template_directory_uri() . '/images/columns/3.png'),
                        ),
                        'default'   => '3'
                    ),
                    array(
                        'id'        => 'blog_sidebar_style',
                        'type'      => 'select',
                        'required'  => array('blog_sidebar', '!=', '1'),
                        'title'     => esc_html__('Sidebar Style', 'gogreen'),
                        'subtitle'  => esc_html__('Select a sidebar background style.', 'gogreen'),
                        'options'   => array(                            
                            'dark' => esc_html__('Dark', 'gogreen'),
                            'light' => esc_html__('Light', 'gogreen'),
                        ),
                        'default'   => 'dark'

                    ),
                    array(
                        'id'        => 'blog_layout',
                        'type'      => 'image_select',
                        'title'     => esc_html__('Layout', 'gogreen'),
                        'subtitle'  => esc_html__('Select blog posts view.', 'gogreen'),
                        'options'   => array(
                            'large' => array('alt' => 'Large', 'img' => get_template_directory_uri() . '/images/blog/standard.jpg'),
                            'list' => array('alt' => 'List',  'img' => get_template_directory_uri() . '/images/blog/list.jpg'),
                            'masonry' => array('alt' => 'Masonry', 'img' => get_template_directory_uri() . '/images/blog/masonry.jpg'),
                        ),
                        'default'   => 'large'
                    ),
                    array(
                        'id'        => 'blog_columns',
                        'type'      => 'select',
                        'required'  => array('blog_layout', '=', 'masonry'),
                        'title'     => esc_html__('Columns', 'gogreen'),
                        'subtitle'  => esc_html__('Select the number of grid columns.', 'gogreen'),
                        'options'   => array(                            
                            2 => 2,
                            3 => 3,
                            4 => 4
                        ),
                        'default'   => 3

                    ),
                    array(
                        'id'        => 'blog_excerpt',
                        'type'      => 'select',
                        'title'     => esc_html__('Excerpt', 'gogreen'),
                        'subtitle'  => esc_html__('Choose to display an excerpt or full content on blog posts view.', 'gogreen'),
                        'options'   => array(                            
                            0 => esc_html__('Full Content', 'gogreen'),
                            1 => esc_html__('Excerpt', 'gogreen'),
                        ),
                        'default'   => 0

                    ),
                    array(
                        'id'        => 'blog_excerpt_base',
                        'type'      => 'select',
                        'required'  => array('blog_excerpt', '=', '1'),
                        'title'     => esc_html__('Limit By', 'gogreen'),
                        'subtitle'  => esc_html__('Limit the post excerpt length by using number of words or characters.', 'gogreen'),
                        'options'   => array(                            
                            0 => esc_html__('Words', 'gogreen'),
                            1 => esc_html__('Characters', 'gogreen'),
                        ),
                        'default'   => 0

                    ),    
                    array(
                        'id'        => 'blog_excerpt_length',
                        'required'  => array('blog_excerpt', '=', '1'),
                        'type'      => 'text',
                        'title'     => esc_html__('Excerpt Length', 'gogreen'),
                        'subtitle'  => esc_html__('Enter the limit of post excerpt length.', 'gogreen'),
                        'default'   => '55'
                    ),
                    array(
                        'id'        => 'blog_excerpt_more',
                        'type'      => 'select',
                        'required'  => array('blog_excerpt', '=', '1'),
                        'title'     => esc_html__('Read More', 'gogreen'),
                        'subtitle'  => esc_html__('Select read more style to display after the excerpt.', 'gogreen'),
                        'options'   => array(                            
                            0 => esc_html__('[...]', 'gogreen'),
                            1 => esc_html__('Link to Full Post', 'gogreen'),
                        ),
                        'default'   => 0

                    ),
                    array(
                        'id'        => 'blog_pagination',
                        'type'      => 'select',
                        'title'     => esc_html__('Pagination Type', 'gogreen'),
                        'subtitle'  => esc_html__('Select the pagination type for blog page.', 'gogreen'),
                        'options'   => array(
                            '1' => esc_html__('Numeric Pagination', 'gogreen'),
                            '2' => esc_html__('Infinite Scroll', 'gogreen'),
                            '3' => esc_html__('Next and Previous', 'gogreen'),
                        ),
                        'default'   => '3'
                    ),
                    array(
                        'id'        => 'blog_placeholder_image',
                        'type'      => 'media',
                        'title'     => esc_html__('Placeholder Image', 'gogreen'),
                        'height'     => '540px',
                        'subtitle'  => esc_html__('Select a cover image placeholder.', 'gogreen'),
                        'desc'      => esc_html__('Recommended size: 960x540 px or larger.', 'gogreen'),
                        'default'  => array(        
                                'url'=> get_template_directory_uri() .'/images/blog/placeholder.jpg',
                                'width' => '960',
                                'height' => '540px',
                        )
                    ),
                    array(
                        'id'        => 'section_blog_single',
                        'type'      => 'section',
                        'title'     => esc_html__('Blog Single Post', 'gogreen'),
                        'subtitle'  => esc_html__('Customize blog single post.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'blog_single_sidebar',
                        'type'      => 'image_select',
                        'title'     => esc_html__('Sidebar', 'gogreen'),
                        'subtitle'  => esc_html__('Select sidebar position.', 'gogreen'),
                        'options'   => array(
                            '1' => array('alt' => 'No Sidebar', 'img' => get_template_directory_uri() . '/images/columns/1.png'),
                            '2' => array('alt' => 'One Left', 'img' => get_template_directory_uri() . '/images/columns/2.png'),
                            '3' => array('alt' => 'One Right', 'img' => get_template_directory_uri() . '/images/columns/3.png'),
                        ),
                        'default'   => '1'
                    ),    
                    array(
                        'id'        => 'blog_single_image_size',
                        'type'      => 'select',
                        'title'     => esc_html__('Featured Image Size', 'gogreen'),
                        'subtitle'  => esc_html__('Select blog single post featured image size.', 'gogreen'),
                        'options'   => array(
                            'hide' => esc_html__('Hide Featured Image', 'gogreen'),
                            'gogreen-land-large' => esc_html__('Large (960x540)', 'gogreen'),
                            'gogreen-fullwidth' => esc_html__('Full Width', 'gogreen'),
                            'full' => esc_html__('Original', 'gogreen'),
                        ),
                        'default'   => 'full'
                    ),    
                    array(
                        'id'        => 'blog_single_lightbox_size',
                        'type'      => 'select',
                        'title'     => esc_html__('Lightbox Image Size', 'gogreen'),
                        'subtitle'  => esc_html__('Select lightbox image size.', 'gogreen'),
                        'options'   => array(
                            'gogreen-land-large' => esc_html__('Large (960x540)', 'gogreen'),
                            'gogreen-fullwidth' => esc_html__('Full Width', 'gogreen'),
                            'full' => esc_html__('Original', 'gogreen'),
                        ),
                        'default'   => 'full'
                    ),
                    array(
                        'id'        => 'blog_single_tags',
                        'type'      => 'switch',
                        'title'     => esc_html__('Post Tags', 'gogreen'),
                        'subtitle'  => esc_html__('Display post tags.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'blog_single_author',
                        'type'      => 'switch',
                        'title'     => esc_html__('Author Box', 'gogreen'),
                        'subtitle'  => esc_html__('Display author description box.', 'gogreen'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'blog_single_share',
                        'type'      => 'switch',
                        'title'     => esc_html__('Social Share Buttons', 'gogreen'),
                        'subtitle'  => esc_html__('Display social media share buttons on the blog single post.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'blog_single_nav',
                        'type'      => 'switch',
                        'title'     => esc_html__('Post Navigation', 'gogreen'),
                        'subtitle'  => esc_html__('Display next and previous posts.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'blog_home',
                        'type'      => 'switch',
                        'required'  => array('blog_single_nav', '=', 1),
                        'title'     => esc_html__('Home Button', 'gogreen'),
                        'subtitle'  => esc_html__('Display a "Home" button on blog single post.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'blog_home_page',
                        'type'      => 'select',
                        'required'  => array('blog_home', '=', 1),
                        'title'     => esc_html__('Blog Home Page', 'gogreen'),
                        'subtitle'  => esc_html__('Select a blog home page.', 'gogreen'),
                        'options'   => array(
                            'default' => esc_html__('Default - Assigned Posts Page', 'gogreen'),
                            'custom' => esc_html__('Custom', 'gogreen'),                           
                        ),
                        'default'   => 'default'
                    ),
                    array(
                        'id'        => 'blog_home_url',
                        'type'      => 'text',
                        'required'  => array('blog_home_page', '=', 'custom'),
                        'title'     => esc_html__('Blog Home Page URL', 'gogreen'),
                        'subtitle'  => esc_html__('Home page URL for the "Home" button on blog single post.', 'gogreen'),
                        'default'   =>  esc_url( home_url() ). '/blog',
                    ),
                    array(
                        'id'        => 'blog_single_comment',
                        'type'      => 'switch',
                        'title'     => esc_html__('Comments', 'gogreen'),
                        'subtitle'  => esc_html__('Display comments box.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'blog_single_related',
                        'type'      => 'switch',
                        'title'     => esc_html__('Related Posts', 'gogreen'),
                        'subtitle'  => esc_html__('Display related posts.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'blog_single_related_posts',
                        'type'      => 'select',
                        'required'  => array('blog_single_related', '=', 1),
                        'title'     => esc_html__('Number of related posts', 'gogreen'),
                        'subtitle'  => esc_html__('Select the number of posts to show in related posts.', 'gogreen'),
                        'options'   => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                        ),
                        'default'   => '5'

                    ),
                    array(
                        'id'        => 'section_blog_meta',
                        'type'      => 'section',
                        'title'     => esc_html__('Blog Meta', 'gogreen'),
                        'subtitle'  => esc_html__('Customize blog meta data options.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'blog_meta_date',
                        'type'      => 'switch',
                        'title'     => esc_html__('Post Date', 'gogreen'),
                        'subtitle'  => esc_html__('Display blog post date.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'blog_meta_author',
                        'type'      => 'switch',
                        'title'     => esc_html__('Author Name', 'gogreen'),
                        'subtitle'  => esc_html__('Display blog author meta data.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'blog_meta_category',
                        'type'      => 'switch',
                        'title'     => esc_html__('Category', 'gogreen'),
                        'subtitle'  => esc_html__('Display blog meta category.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'blog_meta_comment',
                        'type'      => 'switch',
                        'title'     => esc_html__('Comment', 'gogreen'),
                        'subtitle'  => esc_html__('Display blog meta comment.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'blog_meta_share',
                        'type'      => 'switch',
                        'title'     => esc_html__('Social Share Buttons', 'gogreen'),
                        'subtitle'  => esc_html__('Display social media share buttons on the blog posts list.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'section_blog_archive',
                        'type'      => 'section',
                        'title'     => esc_html__('Blog Archive/Category', 'gogreen'),
                        'subtitle'  => esc_html__('Customize blog archive/category page and author page.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'blog_archive_page_title',
                        'type'      => 'switch',
                        'title'     => esc_html__('Title Area', 'gogreen'),
                        'subtitle'  => esc_html__('Turn on to show the page title area on archive page.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'blog_archive_page_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Page Layout', 'gogreen'),
                        'subtitle'  => esc_html__('Select a page layout, choose \'Boxed\' to create a Regular WordPress page, Wide for creating a Full Width page.', 'gogreen'),
                        'options'   => array(                            
                            'boxed' => esc_html__('Boxed', 'gogreen'),
                            'wide' => esc_html__('Wide', 'gogreen'),
                        ),
                        'default'   => 'boxed'

                    ),
                    array(
                        'id'        => 'blog_archive_sidebar',
                        'type'      => 'image_select',
                        'title'     => esc_html__('Sidebar', 'gogreen'),
                        'subtitle'  => esc_html__('Select sidebar position.', 'gogreen'),
                        'options'   => array(
                            '1' => array('alt' => 'No Sidebar', 'img' => get_template_directory_uri() . '/images/columns/1.png'),
                            '2' => array('alt' => 'One Left', 'img' => get_template_directory_uri() . '/images/columns/2.png'),
                            '3' => array('alt' => 'One Right', 'img' => get_template_directory_uri() . '/images/columns/3.png'),
                        ),
                        'default'   => '3'
                    ),
                    array(
                        'id'        => 'blog_archive_sidebar_style',
                        'type'      => 'select',
                        'required'  => array('blog_archive_sidebar', '!=', '1'),
                        'title'     => esc_html__('Sidebar Style', 'gogreen'),
                        'subtitle'  => esc_html__('Select a sidebar background style.', 'gogreen'),
                        'options'   => array(                            
                            'dark' => esc_html__('Dark', 'gogreen'),
                            'light' => esc_html__('Light', 'gogreen'),
                        ),
                        'default'   => 'dark'

                    ),
                    array(
                        'id'        => 'blog_archive_background',
                        'type'      => 'background',
                        'title'     => esc_html__('Page Background', 'gogreen'),
                        'subtitle'  => esc_html__('Set blog archive page background.', 'gogreen'),
                        'output'    => array('.archive.category .main-content, .archive.author .main-content, .archive.date .main-content'),
                        'background-repeat' => false,
                        'background-attachment' =>false,
                        'default'   => array(
                            'background-size'   => 'cover',
                            'background-position'   => 'center center'
                        ),
                    ),
                    array(
                        'id'        => 'blog_archive_layout',
                        'type'      => 'image_select',
                        'title'     => esc_html__('Layout', 'gogreen'),
                        'subtitle'  => esc_html__('Select blog posts view.', 'gogreen'),
                        'options'   => array(
                            'large' => array('alt' => 'Large', 'img' => get_template_directory_uri() . '/images/blog/standard.jpg'),
                            'list' => array('alt' => 'List',  'img' => get_template_directory_uri() . '/images/blog/list.jpg'),
                            'masonry' => array('alt' => 'Masonry', 'img' => get_template_directory_uri() . '/images/blog/masonry.jpg'),
                        ),
                        'default'   => 'large'
                    ),
                    array(
                        'id'        => 'blog_archive_columns',
                        'type'      => 'select',
                        'required'  => array('blog_archive_layout', '=', 'masonry'),
                        'title'     => esc_html__('Columns', 'gogreen'),
                        'subtitle'  => esc_html__('Select the number of grid columns.', 'gogreen'),
                        'options'   => array(                            
                            2 => 2,
                            3 => 3,
                            4 => 4
                        ),
                        'default'   => 3

                    ),
                    array(
                        'id'        => 'blog_archive_pagination',
                        'type'      => 'select',
                        'title'     => esc_html__('Pagination Type', 'gogreen'),
                        'subtitle'  => esc_html__('Select the pagination type for blog page.', 'gogreen'),
                        'options'   => array(
                            '1' => esc_html__('Numeric Pagination', 'gogreen'),
                            '2' => esc_html__('Infinite Scroll', 'gogreen'),
                            '3' => esc_html__('Next and Previous', 'gogreen'),
                        ),
                        'default'   => '1'
                    )


                )
            );

            /***************************** 
            * Portfolio
            ******************************/
            $this->sections['portfolio'] = array(
                'icon'      => 'el el-folder-open',
                'title'     => esc_html__('Portfolio', 'gogreen'),
                'heading'   => false,
                'fields'    => array(
                    array(
                        'id'        => 'section_portfolio',
                        'type'      => 'section',
                        'title'     => esc_html__('Portfolio Options', 'gogreen'),
                        'subtitle'  => esc_html__('Customize the portfolio options.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'portfolio_placeholder_image',
                        'type'      => 'media',
                        'title'     => esc_html__('Placeholder Image', 'gogreen'),
                        'subtitle'  => esc_html__('Select a cover image placeholder.', 'gogreen'),
                        'desc'      => esc_html__('Recommended size: 640x640 px or larger.', 'gogreen'),
                        'default'  => array(        
                                'url' => get_template_directory_uri() .'/images/portfolio/placeholder.jpg',
                                'width' => '640px',
                                'height' => '640px',
                        )
                    ),
                    array(
                        'id'        => 'section_portfolio_single',
                        'type'      => 'section',
                        'title'     => esc_html__('Portfolio Single Post', 'gogreen'),
                        'subtitle'  => esc_html__('Customize the portfolio single post.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'portfolio_single_slug',
                        'type'      => 'text',
                        'title'     => esc_html__('Portfolio Slug', 'gogreen'),
                        'subtitle'  => esc_html__('Change/Rewrite the permalink when you use the permalink type as %postname%.', 'gogreen'),
                        'default'   => 'portfolio-item'
                    ),    
                    array(
                        'id'        => 'portfolio_single_featured_image',
                        'type'      => 'switch',
                        'title'     => esc_html__('Display Featured Image', 'gogreen'),
                        'subtitle'  => esc_html__('Turn on to display featured image on portfolio single post.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'portfolio_single_lightbox_size',
                        'type'      => 'select',
                        'title'     => esc_html__('Lightbox Image Size', 'gogreen'),
                        'subtitle'  => esc_html__('Select portfolio lightbox image size.', 'gogreen'),
                        'options'   => array(
                            'gogreen-land-large' => esc_html__('Large (960x540)', 'gogreen'),
                            'gogreen-fullwidth' => esc_html__('Full Width', 'gogreen'),
                            'full' => esc_html__('Original', 'gogreen'),
                        ),
                        'default'   => 'full'
                    ),
                    array(
                        'id'        => 'portfolio_single_date',
                        'type'      => 'switch',
                        'title'     => esc_html__('Publish Date', 'gogreen'),
                        'subtitle'  => esc_html__('Display portfolio publish date.', 'gogreen'),                        
                        'default'   => true
                    ),
                    array(
                        'id'        => 'portfolio_single_share',
                        'type'      => 'switch',
                        'title'     => esc_html__('Social Share Buttons', 'gogreen'),
                        'subtitle'  => esc_html__('Display social media share buttons on the portfolio single post.', 'gogreen'),                        
                        'default'   => true
                    ),
                    array(
                        'id'        => 'portfolio_single_nav',
                        'type'      => 'switch',
                        'title'     => esc_html__('Post Navigation', 'gogreen'),
                        'subtitle'  => esc_html__('Display next and previous posts.', 'gogreen'),                        
                        'default'   => true
                    ),
                    array(
                        'id'        => 'portfolio_single_home',
                        'type'      => 'switch',
                        'required'  => array('portfolio_single_nav', '=', 1),
                        'title'     => esc_html__('Home Button', 'gogreen'),
                        'subtitle'  => esc_html__('Display a "Home" button on portfolio single post.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'portfolio_single_home_url',
                        'type'      => 'text',
                        'required'  => array('portfolio_single_home', '=', 1),
                        'title'     => esc_html__('Portfolio Home Page', 'gogreen'),
                        'subtitle'  => esc_html__('Home page URL for the "Home" button on portfolio single post.', 'gogreen'),
                        'default'   =>  esc_url( home_url() ). '/portfolio',
                    ),
                    array(
                        'id'        => 'portfolio_single_related',
                        'type'      => 'switch',
                        'title'     => esc_html__('Related Posts', 'gogreen'),
                        'subtitle'  => esc_html__('Display related posts.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'portfolio_single_related_posts',
                        'type'      => 'select',
                        'required'  => array('portfolio_single_related', '=', 1),
                        'title'     => esc_html__('Number of related posts', 'gogreen'),
                        'subtitle'  => esc_html__('Select the number of posts to show in related posts.', 'gogreen'),
                        'options'   => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                        ),
                        'default'   => '6'

                    ),
                    array(
                        'id'        => 'section_portfolio_archive',
                        'type'      => 'section',
                        'title'     => esc_html__('Portfolio Archive', 'gogreen'),
                        'subtitle'  => esc_html__('Customize the portfolio archive pages (Category, Skill and Tag).', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'portfolio_archive_page_title',
                        'type'      => 'switch',
                        'title'     => esc_html__('Title Area', 'gogreen'),
                        'subtitle'  => esc_html__('Turn on to show the page title area on archive page.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'portfolio_archive_page_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Page Layout', 'gogreen'),
                        'subtitle'  => esc_html__('Select a page layout, choose \'Boxed\' to create a Regular WordPress page, Wide for creating a Full Width page.', 'gogreen'),
                        'options'   => array(                            
                            'boxed' => esc_html__('Boxed', 'gogreen'),
                            'wide' => esc_html__('Wide', 'gogreen'),
                        ),
                        'default'   => 'boxed'

                    ),
                    array(
                        'id'        => 'portfolio_archive_background',
                        'type'      => 'background',
                        'title'     => esc_html__('Page Background', 'gogreen'),
                        'subtitle'  => esc_html__('Set portfolio archive page background.', 'gogreen'),
                        'output'    => array('.archive.tax-portfolio_category .main-content, .archive.tax-portfolio_skill .main-content, .archive.tax-portfolio_tag .main-content'),
                        'background-repeat' => false,
                        'background-attachment' =>false,
                        'default'   => array(
                        ),
                    ),
                    array(
                        'id'        => 'portfolio_archive_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Layout', 'gogreen'),
                        'subtitle'  => esc_html__('Select a portfolio layout for archive pages.', 'gogreen'),
                        'options'   => array(
                            'grid'  =>  esc_html__('Grid (Without Space)', 'gogreen'), 
                            'grid-space' => esc_html__('Grid (With Space)', 'gogreen'),
                            'photoset' => esc_html__('Photoset', 'gogreen'),
                            'masonry-1'   => esc_html__('Masonry 1', 'gogreen'),
                            'masonry-2' => esc_html__('Masonry 2', 'gogreen'),
                        ),
                        'default'   => 'photoset'
                    ),
                    array(
                        'id'        => 'portfolio_archive_grid_columns',
                        'type'      => 'select',
                        'required'  => array(
                                        array('portfolio_archive_layout', '!=', 'masonry-1'),
                                        array('portfolio_archive_layout', '!=', 'masonry-2')
                                    ),
                        'title'     => esc_html__('Columns', 'gogreen'),
                        'subtitle'  => esc_html__('Select the number of grid columns.', 'gogreen'),
                        'options'   => array(
                            '2' => esc_html__('2 Columns', 'gogreen'),
                            '3' => esc_html__('3 Columns', 'gogreen'),
                            '4' => esc_html__('4 Columns', 'gogreen')
                        ),
                        'default'   => '3'

                    ),
                    array(
                        'id'        => 'portfolio_archive_pagination',
                        'type'      => 'select',
                        'title'     => esc_html__('Pagination Type', 'gogreen'),
                        'subtitle'  => esc_html__('Select the pagination type for portfolio archive pages.', 'gogreen'),
                        'options'   => array(
                            '1' => esc_html__('Infinite Scroll', 'gogreen'),
                            '2' => esc_html__('Show More Button', 'gogreen'),
                            'hide' => esc_html__('Hide', 'gogreen'),
                        ),
                        'default'   => '1'
                    )
                )
            );

            /***************************** 
            * WooCommerce
            ******************************/
            $this->sections['woocommerce'] = array(
                'icon'      => 'el-icon-shopping-cart',
                'title'     => esc_html__('WooCommerce', 'gogreen'),
                'heading'   => false,
                'fields'    => array(
                    array(
                        'id'        => 'section_shop',
                        'type'      => 'section',
                        'title'     => esc_html__('Shop Page', 'gogreen'),
                        'subtitle'  => esc_html__('Customize shop page.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'shop_product_items',
                        'type'      => 'text',
                        'title'     => esc_html__('Number of Products per Page', 'gogreen'),
                        'subtitle'  => esc_html__('Enter the number of products per page.', 'gogreen'),
                        'validate'  => 'numeric',
                        'default'   => 12
                        
                    ),
                    array(
                        'id'        => 'shop_product_columns',
                        'type'      => 'select',
                        'title'     => esc_html__('Number of Columns', 'gogreen'),
                        'subtitle'  => esc_html__('Select the number of columns.', 'gogreen'),
                        'options'   => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                        ),
                        'default'   => '4'
                    ),                    
                    array(
                        'id'        => 'shop_pagination',
                        'type'      => 'select',
                        'title'     => esc_html__('Pagination Type', 'gogreen'),
                        'subtitle'  => esc_html__('Select the pagination type for shop page.', 'gogreen'),
                        'options'   => array(
                            '1' => esc_html__('Numeric Pagination', 'gogreen'),
                            '2' => esc_html__('Infinite Scroll', 'gogreen'),
                            '3' => esc_html__('Next and Previous', 'gogreen'),
                        ),
                        'default'   => '1'
                    ),
                    array(
                        'id'        => 'section_shop_single',
                        'type'      => 'section',
                        'title'     => esc_html__('Single Product', 'gogreen'),
                        'subtitle'  => esc_html__('Customize shop single product.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'shop_single_sidebar',
                        'type'      => 'image_select',
                        'title'     => esc_html__('Shop Single Sidebar', 'gogreen'),
                        'subtitle'  => esc_html__('Select shop single product sidebar position.', 'gogreen'),
                        'options'   => array(
                            '1' => array('alt' => 'No Sidebar', 'img' => get_template_directory_uri() . '/images/columns/1.png'),
                            '2' => array('alt' => 'One Left', 'img' => get_template_directory_uri() . '/images/columns/2.png'),
                            '3' => array('alt' => 'One Right', 'img' => get_template_directory_uri() . '/images/columns/3.png'),
                        ),
                        'default'   => '1'
                    ),
                    array(
                        'id'        => 'related_product_items',
                        'type'      => 'select',
                        'title'     => esc_html__('Number of Related Products', 'gogreen'),
                        'subtitle'  => esc_html__('Select the number of related products.', 'gogreen'),
                        'options'   => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                            '7' => '7',
                            '8' => '8',
                            '9' => '9',
                            '10' => '10',
                        ),
                        'default'   => '4'
                    ),
                    array(
                        'id'        => 'related_product_columns',
                        'type'      => 'select',
                        'title'     => esc_html__('Number of Columns', 'gogreen'),
                        'subtitle'  => esc_html__('Select the number of columns for the related products.', 'gogreen'),
                        'options'   => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                        ),
                        'default'   => '4'
                    )
                  )
            );

            /***************************** 
            * Search
            ******************************/
            $this->sections['search'] = array(
                'icon'      => 'el-icon-search',
                'title'     => esc_html__('Search', 'gogreen'),
                'heading'   => false,
                'fields'    => array(
                    array(
                        'id'        => 'search_page_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Page Layout', 'gogreen'),
                        'subtitle'  => esc_html__('Select a page layout, choose \'Boxed\' to create a Regular WordPress page, Wide for creating a Full Width page.', 'gogreen'),
                        'options'   => array(                            
                            'boxed' => esc_html__('Boxed', 'gogreen'),
                            'wide' => esc_html__('Wide', 'gogreen'),
                        ),
                        'default'   => 'boxed'

                    ),
                    array(
                        'id'        => 'search_sidebar',
                        'type'      => 'image_select',
                        'title'     => esc_html__('Sidebar', 'gogreen'),
                        'subtitle'  => esc_html__('Select sidebar position.', 'gogreen'),
                        'options'   => array(
                            '1' => array('alt' => 'No Sidebar', 'img' => get_template_directory_uri() . '/images/columns/1.png'),
                            '2' => array('alt' => 'One Left', 'img' => get_template_directory_uri() . '/images/columns/2.png'),
                            '3' => array('alt' => 'One Right', 'img' => get_template_directory_uri() . '/images/columns/3.png'),
                        ),
                        'default'   => '1'
                    ),
                    array(
                        'id'        => 'search_sidebar_style',
                        'type'      => 'select',
                        'required'  => array('search_sidebar', '!=', '1'),
                        'title'     => esc_html__('Sidebar Style', 'gogreen'),
                        'subtitle'  => esc_html__('Select a sidebar background style.', 'gogreen'),
                        'options'   => array(                            
                            'dark' => esc_html__('Dark', 'gogreen'),
                            'light' => esc_html__('Light', 'gogreen'),
                        ),
                        'default'   => 'dark'

                    ),
                    array(
                        'id'        => 'search_pagination',
                        'type'      => 'select',
                        'title'     => esc_html__('Pagination Type', 'gogreen'),
                        'subtitle'  => esc_html__('Select the pagination type for blog page.', 'gogreen'),
                        'options'   => array(
                            '1' => esc_html__('Numeric Pagination', 'gogreen'),
                            '2' => esc_html__('Infinite Scroll', 'gogreen'),
                            '3' => esc_html__('Next and Previous', 'gogreen'),
                        ),
                        'default'   => '1'
                    ),
                    array(
                        'id'        => 'search_show_image',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show Featured Image', 'gogreen'),
                        'subtitle'  => esc_html__('Display featured images in search results.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'search_show_date',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show Post Date', 'gogreen'),
                        'subtitle'  => esc_html__('Display post date in search results.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'search_show_author',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show Author', 'gogreen'),
                        'subtitle'  => esc_html__('Display post author in search results.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'ajax_search',
                        'type'      => 'switch',
                        'title'     => esc_html__('Ajax Search', 'gogreen'),
                        'subtitle'  => esc_html__('Enable ajax auto suggest search.', 'gogreen'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'section_ajax_search',
                        'type'      => 'section',
                        'required'  => array('ajax_search', '=', 1),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'search_post_types',
                        'type'      => 'checkbox',
                        'title'     => esc_html__('Post Types', 'gogreen'),
                        'subtitle'  => esc_html__('Select post types for ajax auto suggest search.', 'gogreen'),
                        'data'  => 'post_types',
                        'default'   => array(
                            'page' => true,
                            'post' => true,
                            'wyde_portfolio' => true,
                            'product'   => true
                        )
                    ),
                    array(
                        'id'        => 'search_suggestion_items',
                        'type'      => 'select',
                        'title'     => esc_html__('Number of Suggestion Items.', 'gogreen'),
                        'subtitle'  => esc_html__('Select number of search suggestion items per post type.', 'gogreen'),
                        'options'  => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                            '7' => '7',
                            '8' => '8',
                            '9' => '9',
                            '10' => '10',
                        ),
                        'default'   => '5'
                        
                    )
                  )
            );

            /***************************** 
            * AJAX Page Options
            ******************************/
            $this->sections['ajax_page'] = array(
                'icon'      => 'el el-hourglass',
                'title'     => esc_html__('AJAX Page', 'gogreen'),
                'heading'     => false,
                'fields'    => array(
                    array(
                        'id'        => 'section_ajax_options',
                        'type'      => 'section',
                        'title'     => esc_html__('AJAX Options', 'gogreen'),
                        'subtitle'  => esc_html__('Turn on or off the AJAX page features.', 'gogreen'),
                        'indent'    => true
                    ),
                    array(
                        'id'        => 'ajax_page',
                        'type'      => 'switch',
                        'title'     => esc_html__('Ajax Page', 'gogreen'),
                        'subtitle'  => esc_html__('Enable ajax page transitions.', 'gogreen'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'ajax_page_transition',
                        'type'      => 'select',
                        'required'  => array('ajax_page', '=', 1),
                        'title'     => esc_html__('Transitions', 'gogreen'),
                        'subtitle'  => esc_html__('Select a page transition effect.', 'gogreen'),
                        'options'   => array(
                            'fade' => esc_html__('Fade', 'gogreen'),
                            'slideToggle' => esc_html__('Slide Toggle', 'gogreen'),
                            'slideLeft' => esc_html__('Slide to Left', 'gogreen'),
                            'slideRight'=> esc_html__('Slide to Right', 'gogreen'),
                            'slideUp'=> esc_html__('Slide Up', 'gogreen'),
                            'slideDown'=> esc_html__('Slide Down', 'gogreen'),
                        ),
                        'default'   => 'fade',
                    ),
                    array(
                        'id'        => 'ajax_page_exclude_urls',
                        'type'      => 'multi_text',
                        'required'  => array('ajax_page', '=', 1),
                        'title'     => esc_html__('Exclude URLs', 'gogreen'),
                        'subtitle'  => esc_html__('Excludes the specific links from AJAX Page Loader. E.g. /shop/, /cart/, /checkout/, etc.', 'gogreen'),
                        'add_text'  => esc_html__('Add New', 'gogreen'),
                        'default'   => array(
                            '/shop/',
                            '/product/',
                            '/product-category/',
                            '/cart/',
                            '/checkout/',
                            '/my-account/',
                        ),
                    )
                )
            );

            /***************************** 
            * Social Media
            ******************************/           
            $social_fields = array();

            $social_icons = gogreen_get_social_icons(); // get social icons from inc/custom-functions.php

            foreach($social_icons as $key => $value){
               $social_fields[] = array(
                        'id'        => 'social_'. gogreen_string_to_underscore_name($value),
                        'type'      => 'text',
                        'title'     => $value,
               ); 
            }

            $this->sections['social'] = array(
                'icon'      => 'el-icon-group',
                'title'     => esc_html__('Social Media', 'gogreen'),
                'fields'    => $social_fields
            );


           /***************************** 
            * Typography
            ******************************/
            $this->sections['typography'] = array(
                'icon'      => 'el-icon-font',
                'title'     => esc_html__('Typography', 'gogreen'),
                'desc'     => esc_html__('Customize font options for your site.', 'gogreen'),
                'fields'    => array(
                    array(
                        'id'            => 'font_body',
                        'type'          => 'typography',
                        'title'         => esc_html__('Body', 'gogreen'),
                        'subtitle'      => esc_html__('Font options for main body text.', 'gogreen'),
                        'google'        => true,    
                        'font-style'    => false, 
                        'line-height'   => false,
                        'all_styles'    => true,  
                        'letter-spacing'=> true,
                        'font-backup'   => true,
                        'units'         => 'px',
                        'output'        => array('body'),
                        'default'       => array(
                            'google'        => true,
                            'font-family'   => 'Open Sans',
                            'font-size'     => '14px',
                            'font-backup'   => "Arial, Helvetica, sans-serif"
                        ),
                        'preview' => array('text' => 'Body Text <br /> 1234567890 <br /> ABCDEFGHIJKLMNOPQRSTUVWXYZ <br /> abcdefghijklmnopqrstuvwxyz'),
                    ),                    
                    array(
                        'id'            => 'font_menu',
                        'type'          => 'typography',
                        'title'         => esc_html__('Primary Menu', 'gogreen'),
                        'subtitle'      => esc_html__('Font options for primary navigation.', 'gogreen'),
                        'google'        => true,    
                        'font-style'    => false, 
                        'color'         => false, 
                        'font-size'     => true, 
                        'text-align'    => false,
                        'all_styles'    => true,
                        'letter-spacing'=> true,
                        'font-backup'   => true,
                        'line-height'   => false,   
                        'units'         => 'px', 
                        'output'        => array('#top-nav .top-menu > li > a, .live-search-form input'),
                        'default'       => array(
                            'google'        => true,
                            'font-family'   => 'Roboto Condensed',
                            'font-weight'     => '400',
                            'font-backup'   => "Arial, Helvetica, sans-serif"
                        ),
                        'preview' => array('text' => 'Main Menu <br /> 1234567890 <br /> ABCDEFGHIJKLMNOPQRSTUVWXYZ <br /> abcdefghijklmnopqrstuvwxyz'),
                    ),
                    array(
                        'id'            => 'font_buttons',
                        'type'          => 'typography',
                        'title'         => esc_html__('Buttons and Link Buttons', 'gogreen'),
                        'subtitle'      => esc_html__('Font options for buttons and link buttons.', 'gogreen'),
                        'google'        => true,    
                        'font-style'    => false, 
                        'color'         => false, 
                        'font-size'     => false, 
                        'text-align'    => false,
                        'all_styles'    => true,
                        'letter-spacing'=> true,
                        'font-backup'   => true,
                        'line-height'   => false,   
                        'units'         => 'px', 
                        'output'        => array('.w-button, .w-link-button, .w-ghost-button, a.button, button, input[type="submit"], input[type="button"], input[type="reset"]'),
                        'default'       => array(
                            'google'        => true,
                            'font-family'   => 'Roboto Condensed',
                            'letter-spacing'    => '0.5px',
                            'font-backup'   => "Arial, Helvetica, sans-serif"
                        ),
                        'preview' => array('text' => 'Buttons <br /> 1234567890 <br /> ABCDEFGHIJKLMNOPQRSTUVWXYZ <br /> abcdefghijklmnopqrstuvwxyz'),
                    ),                     
                    array(
                        'id'            => 'font_h1',
                        'type'          => 'typography',
                        'title'         => esc_html__('H1', 'gogreen'),
                        'subtitle'      => esc_html__('Font options for heading 1.', 'gogreen'),
                        'google'        => true,    
                        'font-style'    => false, 
                        'line-height'   => false,   
                        'all_styles'    => true,
                        'letter-spacing'=> true,
                        'font-backup'   => true,
                        'units'         => 'px', 
                        'output'        => array('h1'),
                        'default'       => array(
                            'google'        => true,
                            'font-family'   => 'Roboto Condensed',
                            'font-size'     => '60px',
                            'font-weight'     => '700',
                            'font-backup'   => "Arial, Helvetica, sans-serif"
                        ),
                        'preview' => array('text' => 'Heading 1 <br /> 1234567890 <br /> ABCDEFGHIJKLMNOPQRSTUVWXYZ <br /> abcdefghijklmnopqrstuvwxyz'),
                    ),                     
                    array(
                        'id'            => 'font_h2',
                        'type'          => 'typography',
                        'title'         => esc_html__('H2', 'gogreen'),
                        'subtitle'      => esc_html__('Font options for heading 2.', 'gogreen'),
                        'google'        => true,    
                        'font-style'    => false, 
                        'line-height'   => false,   
                        'all_styles'    => true,
                        'letter-spacing'=> true,
                        'font-backup'   => true,
                        'units'         => 'px', 
                        'output'        => array('h2'),
                        'default'       => array(
                            'google'        => true,
                            'font-family'   => 'Roboto Condensed',
                            'font-size'     => '56px',
                            'font-weight'     => '700',
                            'font-backup'   => "Arial, Helvetica, sans-serif"
                         ),
                        'preview' => array('text' => 'Heading 2 <br /> 1234567890 <br /> ABCDEFGHIJKLMNOPQRSTUVWXYZ <br /> abcdefghijklmnopqrstuvwxyz'),
                    ),                     
                    array(
                        'id'            => 'font_h3',
                        'type'          => 'typography',
                        'title'         => esc_html__('H3', 'gogreen'),
                        'subtitle'      => esc_html__('Font options for heading 3.', 'gogreen'),
                        'google'        => true,    
                        'font-style'    => false, 
                        'line-height'   => false,   
                        'all_styles'    => true,
                        'letter-spacing'=> true,
                        'font-backup'   => true,
                        'units'         => 'px', 
                        'output'        => array('h3'),
                        'default'       => array(
                            'google'        => true,
                            'font-family'   => 'Roboto Condensed',
                            'font-size'     => '40px',
                            'font-weight'     => '700',
                            'font-backup'   => "Arial, Helvetica, sans-serif"
                         ),
                        'preview' => array('text' => 'Heading 3 <br /> 1234567890 <br /> ABCDEFGHIJKLMNOPQRSTUVWXYZ <br /> abcdefghijklmnopqrstuvwxyz'),
                    ),                     
                    array(
                        'id'            => 'font_h4',
                        'type'          => 'typography',
                        'title'         => esc_html__('H4', 'gogreen'),
                        'subtitle'      => esc_html__('Font options for heading 4.', 'gogreen'),
                        'google'        => true,    
                        'font-style'    => true, 
                        'font-size'     => false, 
                        'line-height'   => false, 
                        'color'         => false, 
                        'text-align'    => false, 
                        'subsets'       => false, 
                        'all_styles'    => false,
                        'letter-spacing'=> false,
                        'font-backup'   => true,
                        'units'         => 'px', 
                        'output'        => array('h4'),
                        'default'       => array(
                            'google'        => true,
                            'font-family'   => 'Open Sans',
                            'font-weight'     => '700',
                            'font-backup'   => "Arial, Helvetica, sans-serif"
                         ),
                        'preview' => array('text' => 'Heading 4 <br /> 1234567890 <br /> ABCDEFGHIJKLMNOPQRSTUVWXYZ <br /> abcdefghijklmnopqrstuvwxyz'),
                    ),                     
                    array(
                        'id'            => 'font_h5',
                        'type'          => 'typography',
                        'title'         => esc_html__('H5', 'gogreen'),
                        'subtitle'      => esc_html__('Font options for heading 5 and blockquote.', 'gogreen'),
                        'google'        => true,    
                        'font-style'    => true, 
                        'font-size'     => false, 
                        'line-height'   => false, 
                        'color'         => false, 
                        'text-align'    => false, 
                        'subsets'       => false, 
                        'all_styles'    => false,
                        'letter-spacing'=> false,
                        'font-backup'   => true,
                        'units'         => 'px', 
                        'output'        => array('h5', 'blockquote', '.format-quote .post-title', '.post .post-date strong', '.w-blog-posts .post-external-link a'),
                        'default'       => array(
                            'google'        => true,
                            'font-family'   => 'Roboto Slab',
                            'font-weight'   => '400',                           
                            'font-backup'   => "Arial, Helvetica, sans-serif"
                         ),
                        'preview' => array('text' => 'Heading 5 <br /> 1234567890 <br /> ABCDEFGHIJKLMNOPQRSTUVWXYZ <br /> abcdefghijklmnopqrstuvwxyz'),
                    ),                     
                    array(
                        'id'            => 'font_headings',
                        'type'          => 'typography',
                        'title'         => esc_html__('Element headings', 'gogreen'),
                        'subtitle'      => esc_html__('Font options for element headings, text separator, donut chart and related posts.', 'gogreen'),
                        'google'        => true,    
                        'font-style'    => false, 
                        'font-size'     => false,
                        'font-weight'   => false, 
                        'line-height'   => false, 
                        'color'         => false, 
                        'text-align'    => false, 
                        'subsets'       => false, 
                        'all_styles'    => false,
                        'letter-spacing'=> false,
                        'font-backup'   => true,
                        'units'         => 'px', 
                        'output'        => array('.w-separator .w-text', '.w-donut-chart span', '.related-posts li h4', '.title-wrapper .subtitle'),
                        'default'       => array(
                            'google'        => true,
                            'font-family'   => 'Roboto Condensed',
                            'font-backup'   => "Arial, Helvetica, sans-serif"
                         ),
                        'preview' => array('text' => 'Heading <br /> 1234567890 <br /> ABCDEFGHIJKLMNOPQRSTUVWXYZ <br /> abcdefghijklmnopqrstuvwxyz'),
                    )               
                )
            );


            /***************************** 
            * Google API Options
            ******************************/
            $this->sections['google_api'] = array(
                'icon'      => 'el el-map-marker',
                'title'     => esc_html__('Google Maps', 'gogreen'),
                'heading'     => false,
                'fields'    => array(
                    array(
                        'id'        => 'google_maps_api_key',
                        'type'      => 'text',
                        'title'     => esc_html__('Google Maps API Key', 'gogreen'),
                        'subtitle'  => wp_kses( __('Enter your Google Maps API key, <a href="https://developers.google.com/maps/documentation/javascript/get-api-key#key" target="_blank">Get an API key</a>', 'gogreen'), $allowed_html ),
                        'default'   => ''
                    )
                )
            );

            /***************************** 
            * Advanced
            ******************************/
            $this->sections['advanced'] = array(
                'icon'      => 'el-icon-wrench',
                'title'     => esc_html__('Advanced', 'gogreen'),
                'heading'   => false,
                'fields'    => array(
                    array(
                        'id'        => 'head_script',
                        'type'      => 'ace_editor',
                        'title'     => esc_html__('Head Content', 'gogreen'),
                        'subtitle'  => esc_html__('Enter HTML/JavaScript/StyleSheet. The content will be added into the head tag. You can add Google Verification code and custom Meta HTTP Content here.', 'gogreen'),
                        'mode'  => 'html'
                        
                    ),
                    array(
                        'id'        => 'footer_script',
                        'type'      => 'ace_editor',
                        'title'     => esc_html__('Body Content', 'gogreen'),
                        'subtitle'  => esc_html__('Enter HTML/JavaScript/StyleSheet. The content will be added into the footer of all pages. You can add Google Analytics code and custom JavaScript here.', 'gogreen'),
                        'mode'  => 'html'
                        
                    ),
                  )
            );
                       
            /***************************** 
            * Theme Settings
            ******************************/
            $this->sections['import_export'] = array(
                'title'     => esc_html__('Settings', 'gogreen'),
                'heading' => false,
                'icon'      => 'el-icon-cog',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => esc_html__('Theme Options', 'gogreen'),
                        'subtitle'      => esc_html__('Import and Export your Theme Options.', 'gogreen'),
                        'full_width'    => false,
                    ),
                ),
            );                     

            /***************************** 
            * Theme Information
            ******************************/
            $this->theme    = wp_get_theme();
            $item_name      = $this->theme->get('Name');
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = esc_html__('Customize', 'gogreen') . ' '. $this->theme->display('Name');

            ob_start();
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')): ?>
                        <a href="<?php echo esc_url( wp_customize_url() ); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php echo esc_attr($item_name);?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php echo esc_attr($item_name);?>" />
                <?php endif; ?>
                <h4><?php echo esc_html( $this->theme->display('Name') ); ?></h4>
                <div>
                    <p><?php echo esc_html__('By', 'gogreen') . ' '. $this->theme->display('Author') ; ?></p>
                    <p><?php echo esc_html__('Version', 'gogreen') . ' '. esc_html( $this->theme->display('Version') ); ?></p>
                    <p><?php echo '<strong>' . esc_html__('Tags', 'gogreen') . ':</strong> '; ?><?php echo esc_html( $this->theme->display('Tags') ); ?></p>
                    <p class="theme-description"><?php echo esc_html( $this->theme->display('Description') ); ?></p>
            <?php
            if ($this->theme->parent()) {
               echo '<p class="howto">' . esc_html__('This child theme requires its parent theme', 'gogreen') . ', '. esc_html( $this->theme->parent()->display('Name') ). '</p>';
            }
            ?>
                </div>
            </div>
            <?php
            $item_info = ob_get_clean();

            $this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections['theme_info'] = array(
                'icon'      => 'el el-info-circle',
                'title'     => esc_html__('Theme Information', 'gogreen'),
                'desc'      => '<p class="description">' . esc_html__('For more information and features about this theme, please visit', 'gogreen') . ' <a href="'. esc_url( $this->theme->display('AuthorURI') ) .'" target="_blank">'. esc_url( $this->theme->display('AuthorURI') ) . '</a>.</p>',
                'fields'    => array(
                    array(
                        'id'        => 'raw-theme-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );

        }

        /** Set framework arguments **/
        public function setArguments() {

           $this->args = array(
                'opt_name' => 'gogreen_options',
                'display_name' => $this->theme->get('Name'),
                'display_version' =>  $this->theme->get('Version'),                
                'page_slug' => 'theme-options',
                'page_title' =>  esc_html__('Theme Options', 'gogreen'),
                'menu_type' => 'menu',
                'menu_title' => esc_html__('Theme Options', 'gogreen'),
                'page_parent'  => 'themes.php',
                'allow_sub_menu' => false,
                'customizer' => false,
                'update_notice' => false,
                'dev_mode'  => false,
                'admin_bar' => true,
                'admin_bar_icon'    => 'dashicons-admin-generic',
                'hints' => 
                        array(
                          'icon' => 'el-icon-question-sign',
                          'icon_position' => 'right',
                          'icon_size' => 'normal',
                          'tip_style' => 
                          array(
                            'color' => 'light',
                          ),
                          'tip_position' => 
                          array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                          ),
                          'tip_effect' => 
                          array(
                            'show' => 
                            array(
                              'duration' => '500',
                              'event' => 'mouseover',
                            ),
                            'hide' => 
                            array(
                              'duration' => '500',
                              'event' => 'mouseleave unfocus',
                            ),
                          ),
                ),
                'output' => true,
                'compiler'  => true,
                'output_tag' => true,
                'menu_icon' => '',
                'page_icon' => 'icon-themes',
                'page_permissions' => 'manage_options',
                'save_defaults' => true,
                'show_import_export' => true,
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'network_sites' => true,
                'allow_tracking' => false,
                'google_api_key'   => '',//AIzaSyBss9ufj66aGyREW-VQdhuDSJ4opKsD-4U',//Replace with your Google API KEY
                'async_typography' => false,
                'intro_text' => '',
                'footer_text' => '',
                'footer_credit' => sprintf('%s Theme Options panel version %s.', $this->theme->get('Name'), $this->theme->get('Version'))
              );

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'http://themeforest.net/user/Wyde',
                'title' => 'Help',
                'icon'  => 'el-icon-question-sign'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://themeforest.net/user/Wyde/follow',
                'title' => 'Follow us on ThemeForest',
                'icon'  => 'el-icon-heart'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://themeforest.net/downloads',
                'title' => 'Give me a rating on ThemeForest',
                'icon'  => 'el-icon-star'
            );
            

        }

    }    
    
    new GoGreen_Theme_Options();
}