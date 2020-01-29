<?php

	$prefix = '_w_';

    /***************************** 
    * Portfolio Post Options 
    ******************************/
    /** Portfolio Options **/
    $portfolio_options = new_cmb2_box( array(
		'id'         => 'portfolio_options',
		'title'      => esc_html__( 'Portfolio', 'gogreen' ),
        'icon'         => 'dashicons dashicons-portfolio',
		'object_types'      => array('wyde_portfolio'),
	) );
    
    $portfolio_options->add_field( array(
        'id'   => $prefix . 'portfolio_layout',
		'name' => esc_html__( 'Layout', 'gogreen' ),
		'desc' => esc_html__( 'Select portfolio layout.', 'gogreen' ),
		'type' => 'radio_inline',
        'options' => array(
            '1'     => '<img src="' . get_template_directory_uri() . '/images/portfolio/1.jpg" alt="Masonry" title="Masonry"/>',
            '2' => '<img src="' . get_template_directory_uri() . '/images/portfolio/2.jpg" alt="Gallery" title="Gallery"/>',
            '3'   => '<img src="' . get_template_directory_uri() . '/images/portfolio/3.jpg" alt="Slider" title="Slider"/>',
            '4'   => '<img src="' . get_template_directory_uri() . '/images/portfolio/4.jpg" alt="Grid" title="Grid"/>',
            '5'   => '<img src="' . get_template_directory_uri() . '/images/portfolio/5.jpg" alt="Vertical" title="Vertical"/>',
		),
        'default'   => '1'
	));

    $portfolio_options->add_field( array(
        'id'   => $prefix . 'project_url',
		'name' => esc_html__( 'Project URL', 'gogreen' ),
		'desc' => esc_html__( 'Insert a project URL.', 'gogreen' ),
		'type' => 'text_url'
	));

    $portfolio_options->add_field( array(
        'id'         => $prefix . 'post_related',
		'name'       => esc_html__( 'Related Posts', 'gogreen' ),
		'desc'       => esc_html__( 'Display related posts.', 'gogreen' ),
		'type'    => 'select',
		'options' => array(
            ''   => esc_html__('Default', 'gogreen'),
            'show'   => esc_html__('Show', 'gogreen'),
            'hide'   => esc_html__('Hide', 'gogreen'),
        )
	) );
    
    /** Embeds Options **/
    $portfolio_options->add_field( array(
        'id'       => $prefix . 'media_info',
        'name'     => esc_html__( 'Media Options', 'gogreen' ),
        'desc'     => wp_kses( __( 'You can insert media URL from any major video and audio hosting service (Youtube, Vimeo, etc.). Supports services listed at <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">Codex page</a>', 'gogreen'),
            array(
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'target' => array()
                ),
                'br' => array(),
                'em' => array(),
                'strong' => array(),
            )
        ),
		'type'     => 'title',
	));

    $portfolio_options->add_field( array(
        'id'   => $prefix . 'embed_url',
		'name' => esc_html__( 'Media URL', 'gogreen' ),
		'desc' => esc_html__( 'Insert a media URL.', 'gogreen' ),
		'type' => 'oembed'
	));
   
    /** Gallery Options **/
    $portfolio_options->add_field( array(
        'id'       => $prefix . 'gallery_info',
		'name'     => esc_html__( 'Gallery Options', 'gogreen' ),
		'type'     => 'title',
	));

    $portfolio_options->add_field( array(
        'id'   => $prefix . 'gallery_images',
		'name' => esc_html__( 'Images', 'gogreen' ),
		'desc' => esc_html__( 'Upload or select images from media library. Recommended size: 640x640px or larger.', 'gogreen' ),
		'type' => 'file_list',
        'preview_size' => 'thumbnail', 
	));


    /** Client Options **/
    $portfolio_options->add_field( array(
        'id'       => $prefix . 'client_info',
		'name'     => esc_html__('Client Information', 'gogreen'),
		'type'     => 'title',
	));

    $portfolio_options->add_field( array(						
        'id'   => $prefix . 'client_name',
		'name' => esc_html__('Name', 'gogreen'),
        'description' => esc_html__('Insert a client name.', 'gogreen'),
		'type' => 'text_medium'
	));

    $portfolio_options->add_field( array(
        'id'   => $prefix . 'client_detail',
		'name' => esc_html__('Description', 'gogreen' ),
		'description' => esc_html__('Insert a short description about the client.', 'gogreen'),
		'type' => 'wysiwyg',
        'options' => array(
            'wpautop' => false, 
            'media_buttons' => false,
            'textarea_rows' => 5, 
            'teeny' => true, 
        ),
	));

    $portfolio_options->add_field( array(
        'id'   => $prefix . 'client_website',
		'name' => 'Website',
        'description' =>  esc_html__('Insert a client website.', 'gogreen'),
		'type' => 'text_url',
	));
    
     /** Custom Description Options **/
    $portfolio_options->add_field( array(
        'id'       => $prefix . 'custom_field_info',
		'name'     => esc_html__('Custom Description', 'gogreen'),
		'type'     => 'title',
	));

    $custom_fields = $portfolio_options->add_field( array(
        'id'          => $prefix . 'custom_fields',
        'type'        => 'group',
        'description' => esc_html__( 'Add new custom description fields.', 'gogreen'),
        'options'     => array(
            'group_title'   => esc_html__( 'Entry {#}', 'gogreen' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'    => esc_html__( 'Add Another Entry', 'gogreen' ),
            'remove_button' => esc_html__( 'Remove Entry', 'gogreen' ),
            'sortable'      => true, // beta
        ),
        'fields'    => array(
            array(						
                'id'   => 'custom_field_title',
		        'name' => 'Title',
                'description' => esc_html__('Insert a custom field title.', 'gogreen'),
		        'type' => 'text_medium',
	        ),
            array(						
                'id'   => 'custom_field_value',
		        'name' => 'Description',
                'description' => esc_html__('Insert a custom field description.', 'gogreen'),
		        'type' => 'textarea_small',
	        )

        ),
    ) );


    /***************************** 
    * Header Options 
    ******************************/
    $header_options = new_cmb2_box( array(
		'id'            => 'header_options',
		'title'         => esc_html__( 'Header', 'gogreen' ),
		'icon'         => 'dashicons dashicons-menu',
		'object_types'  => array('wyde_portfolio'),
	) );

   $header_options->add_field( array(
        'id'         => $prefix . 'page_header',
        'name'       => esc_html__( 'Header', 'gogreen' ),
        'desc'       => esc_html__( 'Display the header.', 'gogreen' ),
        'type'    => 'select',
        'options' => array(
            ''   => esc_html__('Show', 'gogreen'),
            'hide'   => esc_html__('Hide', 'gogreen'),
        )
    ) );

    $header_options->add_field( array(
        'id'         => $prefix . 'header_top',
        'name'       => esc_html__( 'Top Bar', 'gogreen' ),
        'desc'       => esc_html__( 'Display the header top bar.', 'gogreen' ),
        'type'    => 'select',
        'options' => array(
            ''   => esc_html__('Default', 'gogreen'),
            'show'   => esc_html__('Show', 'gogreen'),
            'hide'   => esc_html__('Hide', 'gogreen'),
        )
    ) );


    $header_options->add_field( array(
        'id'         => $prefix . 'header_transparent',
		'name'       => esc_html__( 'Transparent Header', 'gogreen' ),
		'desc'       => esc_html__( 'Select a transparent header.', 'gogreen' ),
		'type'    => 'select',
		'options' => array(
            ''   => esc_html__('Disable', 'gogreen'),
            'true'   => esc_html__('Enable', 'gogreen'),
        )
	) );

    $header_options->add_field( array(
		'id'      => $prefix . 'header_text_style',
		'name'    => esc_html__( 'Foreground Style', 'gogreen' ),
		'desc'    => esc_html__( 'Select a header navigation foreground style.', 'gogreen' ),
		'type'       => 'select',
        'options'    => array(
            ''   => esc_html__('Default', 'gogreen'),
            'light' => esc_html__('Light', 'gogreen'),
            'dark' => esc_html__('Dark', 'gogreen')
        ),
        'default'  => ''
	) );

    
    /***************************** 
    * Title Options 
    ******************************/
    $title_options = new_cmb2_box( array(
		'id'            => 'title_options',
		'title'         => esc_html__( 'Title Area', 'gogreen' ),
        'icon'         => 'dashicons dashicons-feedback',
		'object_types'  => array('wyde_portfolio'),
	) );

    $title_options->add_field( array(
        'id'         => $prefix . 'post_custom_title',
		'name'       => esc_html__( 'Title Area', 'gogreen' ),
		'desc'       => esc_html__( 'Use custom title area for this post.', 'gogreen' ),
		'type'       => 'checkbox'
	) );


    $title_options->add_field( array(
        'id'         => $prefix . 'title_area',
		'name'       => esc_html__( 'Display Title Area', 'gogreen' ),
		'desc'       => esc_html__( 'Show or Hide the page title area.', 'gogreen' ),
		'type'       => 'select',
        'options'    => array(
            'hide' => esc_html__('Hide', 'gogreen'),
            'show' => esc_html__('Show', 'gogreen')
        ),
        'default'  => 'hide'
	) );

    $title_options->add_field( array(				
        'id'   => $prefix . 'page_title',
		'name' => esc_html__( 'Page Title', 'gogreen' ),
		'desc' => esc_html__( 'Custom text for the page title.', 'gogreen' ),
		'type' => 'textarea_code',
        'default' => isset( $_GET['post'] ) ? get_the_title( $_GET['post'] ) : ''
	) );

    $title_options->add_field( array(				
        'id'   => $prefix . 'subtitle',
		'name' => esc_html__( 'Subtitle', 'gogreen' ),
		'desc' => esc_html__( 'This text will display as subheading in the title area.', 'gogreen' ),
		'type' => 'textarea_code',
        'default' => ''
	) );

    $title_options->add_field( array(               
        'id'   => $prefix . 'title_size',
        'name' => esc_html__( 'Size', 'gogreen' ),
        'desc' => esc_html__( 'Select a title area size.', 'gogreen' ),
        'type' => 'select',
        'options' => array(
            '' => esc_html__('Default', 'gogreen'), 
            's' => esc_html__('Small', 'gogreen'), 
            'm' => esc_html__('Medium', 'gogreen'), 
            'l' => esc_html__('Large', 'gogreen'), 
            'full' => esc_html__('Full Screen', 'gogreen'), 
            ),
        'default' => ''
    ));

    $title_options->add_field( array(
		'id'   => $prefix . 'title_scroll_effect',
		'name' => esc_html__( 'Scrolling Effect', 'gogreen' ),
		'desc' => esc_html__( 'Select a scrolling animation for title text and subtitle.', 'gogreen' ),
		'type' => 'select',
        'options'   => array(
            '' => esc_html__('Default', 'gogreen'), 
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
        'default'  => ''
	));

    $title_options->add_field( array(
		'id'      => $prefix . 'title_color',
		'name'    => esc_html__( 'Text Color', 'gogreen' ),
		'desc'    => esc_html__( 'Select the title text color.', 'gogreen' ),
		'type'    => 'colorpicker',
		'default' => ''
	) );

    $title_options->add_field( array(				
        'id'   => $prefix . 'title_align',
		'name' => esc_html__( 'Alignment', 'gogreen' ),
		'desc' => esc_html__( 'Select the title text alignment.', 'gogreen' ),
		'type' => 'select',
        'options' => array(
            '' => esc_html__('Default', 'gogreen'), 
            'left' => esc_html__('Left', 'gogreen'), 
            'center' => esc_html__('Center', 'gogreen'), 
            'right' => esc_html__('Right', 'gogreen'), 
            ),
        'default' => ''
	) );    

    $title_options->add_field( array(				
        'id'   => $prefix . 'title_background',
		'name' => esc_html__( 'Background', 'gogreen' ),
		'desc' => esc_html__( 'Select a background type for the title area.', 'gogreen' ),
		'type' => 'select',
        'options' => array(
            '' => esc_html__('Default', 'gogreen'), 
            'none' => esc_html__('None', 'gogreen'), 
            'color' => esc_html__('Color', 'gogreen'), 
            'image' => esc_html__('Image', 'gogreen'), 
            'video' => esc_html__('Video', 'gogreen')
            ),
        'default' => ''
	));

   $title_options->add_field( array(
        'id'   => $prefix . 'title_background_image',
        'name' => esc_html__( 'Background Image', 'gogreen' ),
        'desc' => esc_html__( 'Choose an image or insert a URL.', 'gogreen' ),
        'type' => 'file'
    ));


    $title_options->add_field( array(
        'id'   => $prefix . 'title_background_video',
        'name' => esc_html__( 'Background Video', 'gogreen' ),
        'desc' => esc_html__( 'Choose an MP4 video or insert a URL.', 'gogreen' ),
        'type' => 'file'
    ));

    $title_options->add_field( array(
		'id'      => $prefix . 'title_background_color',
		'name'    => esc_html__( 'Background Color', 'gogreen' ),
		'desc'    => esc_html__( 'Choose a background color.', 'gogreen' ),
		'type'    => 'colorpicker',
		'default' => ''
	));

    $title_options->add_field( array(
		'id'   => $prefix . 'title_background_size',
		'name' => esc_html__( 'Background Size', 'gogreen' ),
		'desc' => esc_html__( 'For full width or high-definition background image, choose Cover. Otherwise, choose Contain.', 'gogreen' ),
		'type' => 'select',
        'options'   => array(
            '' => esc_html__('Cover', 'gogreen'), 
            'contain' => esc_html__('Contain', 'gogreen')
            ),
        'default'  => ''
	));

    $title_options->add_field( array(
		'id'      => $prefix . 'title_overlay_color',
		'name'    => esc_html__( 'Background Overlay Color', 'gogreen' ),
		'desc'    => esc_html__( 'Select background overlay color.', 'gogreen' ),
		'type'    => 'colorpicker',
		'default' => ''
	));

    $title_options->add_field( array(
		'id'      => $prefix . 'title_overlay_opacity',
		'name'    => esc_html__( 'Background Overlay Opacity', 'gogreen' ),
		'desc'    => esc_html__( 'Select background overlay opacity.', 'gogreen' ),
		'type' => 'select',
        'options'   => array(
            '' => esc_html__('Default', 'gogreen'), 
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
		'default' => ''
	));  

    $title_options->add_field( array(
        'id'      => $prefix . 'title_background_effect',
        'name'    => esc_html__( 'Background Effect', 'gogreen' ),
        'desc'    => esc_html__( 'Select background scrolling effect.', 'gogreen' ),
        'type' => 'select',
        'options'   => array(
            '' => esc_html__('None', 'gogreen'),
            'fadeOut' => esc_html__('Fade Out', 'gogreen'),
            'parallax' => esc_html__('Parallax', 'gogreen'), 
        ),
        'default' => ''
    ));

    /***************************** 
    * Background Options 
    ******************************/
    $background_options = new_cmb2_box( array(
		'id'         => 'background_options',
		'title'      => esc_html__( 'Background', 'gogreen' ),
        'icon'         => 'dashicons dashicons-format-image',
		'object_types'      => array('wyde_portfolio'),
	) );

    $background_options->add_field( array(
		'id'   => $prefix . 'background',
		'name' => esc_html__( 'Background', 'gogreen' ),
		'desc' => esc_html__( 'Select a background type for this page.', 'gogreen' ),
		'type' => 'select',
        'options' => array(
            '' => esc_html__('None', 'gogreen'), 
            'color' => esc_html__('Color', 'gogreen'), 
            'image' => esc_html__('Image', 'gogreen'), 
        ),
        'default' => ''
	));

    $background_options->add_field( array(
		'id'   => $prefix . 'background_image',
		'name' => esc_html__( 'Background Image', 'gogreen' ),
		'desc' => esc_html__( 'Upload an image or insert a URL.', 'gogreen' ),
		'type' => 'file'
	));
    
    $background_options->add_field( array(
		'id'      => $prefix . 'background_color',
		'name'    => esc_html__( 'Background Color', 'gogreen' ),
		'desc'    => esc_html__( 'Choose a background color.', 'gogreen' ),
		'type'    => 'colorpicker',
		'default' => ''
	));

    $background_options->add_field( array(
		'id'   => $prefix . 'background_size',
		'name' => esc_html__( 'Background Size', 'gogreen' ),
		'desc' => esc_html__( 'For full width or high-definition background image, choose Cover. Otherwise, choose Contain.', 'gogreen' ),
		'type' => 'select',
        'options'   => array(
            'cover' => esc_html__('Cover', 'gogreen'), 
            'contain' => esc_html__('Contain', 'gogreen')
            ),
        'default'  => 'cover'
	));

    $background_options->add_field( array(
		'id'      => $prefix . 'background_overlay_color',
		'name'    => esc_html__( 'Background Overlay Color', 'gogreen' ),
		'desc'    => esc_html__( 'Select background color overlay.', 'gogreen' ),
		'type'    => 'colorpicker',
		'default' => ''
	));

    $background_options->add_field( array(
		'id'      => $prefix . 'background_overlay_opacity',
		'name'    => esc_html__( 'Background Overlay Opacity', 'gogreen' ),
		'desc'    => esc_html__( 'Select background overlay opacity.', 'gogreen' ),
		'type' => 'select',
        'options'   => array(
                '' => esc_html__('Default', 'gogreen'), 
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
		'default' => ''
	));

    /****************************
    * Footer Options 
    ******************************/
    $footer_options = new_cmb2_box( array(
		'id'         => 'footer_options',
		'title'      => esc_html__( 'Footer', 'gogreen' ),
        'icon'         => 'dashicons dashicons-editor-insertmore',
		'object_types'      => array('wyde_portfolio'),
	) );

    $footer_options->add_field( array(
        'id'         => $prefix . 'page_footer_content',
        'name'       => esc_html__( 'Footer Content', 'gogreen' ),
        'desc'       => esc_html__( 'Show or hide the footer content area.', 'gogreen' ),
        'type'      => 'select',
        'options'   => array(
            ''   => esc_html__('Show', 'gogreen'),
            'hide'   => esc_html__('Hide', 'gogreen'),
        ),
    ));

    $footer_options->add_field( array(
        'id'         => $prefix . 'page_footer',
        'name'       => esc_html__( 'Footer', 'gogreen' ),
        'desc'       => esc_html__( 'Show or hide the footer bottom bar.', 'gogreen' ),
        'type'      => 'select',
        'options'   => array(
            ''   => esc_html__('Show', 'gogreen'),
            'hide'   => esc_html__('Hide', 'gogreen'),
        ),
    ));