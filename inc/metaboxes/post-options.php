<?php

	$prefix = '_w_';

    /***************************** 
    * Single Post Options 
    ******************************/
    $post_options = new_cmb2_box( array(
		'id'         => 'post_options',
		'title'      => esc_html__( 'Single Post', 'gogreen' ),
        'icon'         => 'dashicons dashicons-media-document',
		'object_types'      => array('post'),
	) );

    /** Embeds Options **/
    $post_options->add_field( array(
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

    $post_options->add_field( array(
        'id'   => $prefix . 'embed_url',
		'name' => esc_html__( 'Media URL', 'gogreen' ),
		'desc' => esc_html__( 'Insert a media URL.', 'gogreen' ),
		'type' => 'oembed'
	));

    
    /** Gallery Options **/
    $post_options->add_field( array(
        'id'       => $prefix . 'gallery_info',
		'name'     => esc_html__( 'Gallery Options', 'gogreen' ),
		'type'     => 'title',
	));

    $post_options->add_field( array(
        'id'   => $prefix . 'gallery_images',
		'name' => esc_html__( 'Images', 'gogreen' ),
		'desc' => esc_html__( 'Upload or select images from media library. Recommended size: 960x540px or larger.', 'gogreen' ),
		'type' => 'file_list',
        'preview_size' => 'thumbnail', 
	));


    /** Post Format Link Options **/
    $post_options->add_field( array(
        'id'       => $prefix . 'link_info',
		'name'     => esc_html__( 'Link Options.', 'gogreen' ),
        'desc' => esc_html__( 'Extra options for Post Format Link.', 'gogreen' ),
		'type'     => 'title',
	));

    $post_options->add_field( array(
        'id'   => $prefix . 'post_link',
		'name' => esc_html__( 'Post URL', 'gogreen' ),
		'desc' => esc_html__( 'Insert a post URL.', 'gogreen' ),
		'type' => 'text_url'
	));
      

    /** Quote Options **/
    $post_options->add_field( array(
        'id'       => $prefix . 'quote_info',
		'name'     => esc_html__( 'Quote Options', 'gogreen' ),
        'desc' => esc_html__( 'Extra options for Post Format Quote.', 'gogreen' ),
		'type'     => 'title',
	));

    $post_options->add_field( array(
        'id'   => $prefix . 'post_quote',
		'name' => esc_html__( 'Quote', 'gogreen' ),
		'desc' => esc_html__( 'Insert quote here.', 'gogreen' ),
		'type' => 'textarea_small'
	));

    $post_options->add_field( array(
        'id'   => $prefix . 'post_quote_author',
		'name' => esc_html__( 'Author', 'gogreen' ),
		'desc' => esc_html__( 'Insert quote\'s author.', 'gogreen' ),
		'type' => 'text_medium'
	));   
    
    /* Post Options */
    $post_options->add_field( array(
        'id'         => $prefix . 'post_author',
		'name'       => esc_html__( 'Author Info', 'gogreen' ),
		'desc'       => esc_html__( 'Display author description box.', 'gogreen' ),
		'type'    => 'select',
		'options' => array(
            ''   => esc_html__('Default', 'gogreen'),
            'show'   => esc_html__('Show', 'gogreen'),
            'hide'   => esc_html__('Hide', 'gogreen'),
        )
	) );

    $post_options->add_field( array(
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

    /***************************** 
    * Header Options 
    ******************************/
    $header_options = new_cmb2_box( array(
		'id'            => 'header_options',
		'title'         => esc_html__( 'Header', 'gogreen' ),
		'icon'         => 'dashicons dashicons-menu',
		'object_types'  => array('post'),
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
		'object_types'  => array('post'),
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
		'object_types'      => array('post'),
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

    /***************************** 
    * Sidebar Options 
    ******************************/
    $sidebars = array();
    $sidebars[''] = esc_html__('Default', 'gogreen');
    foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { 
        $sidebars[$sidebar['id']] = $sidebar['name'];
    }

    $sidebar_options = new_cmb2_box( array(
		'id'         => 'sidebar_options',
		'title'      => esc_html__( 'Sidebar', 'gogreen' ),
        'icon'         => 'dashicons dashicons-format-aside',
		'object_types'      => array('post'),
	) );

    $sidebar_options->add_field( array(
        'id'         => $prefix . 'post_custom_sidebar',
		'name'       => esc_html__( 'Sidebar', 'gogreen' ),
		'desc'       => esc_html__( 'Use custom sidebar for this post.', 'gogreen' ),
		'type'       => 'checkbox'
	) );

    $sidebar_options->add_field( array(
        'id'         => $prefix . 'sidebar_position',
		'name'       => esc_html__( 'Sidebar Position', 'gogreen' ),
		'desc'       => esc_html__( 'Select sidebar position.', 'gogreen' ),
		'type'    => 'radio_inline',
		'options' => array(
			'1' => '<img src="' . get_template_directory_uri() . '/images/columns/1.png" alt="No Sidebar"/>',
			'2' => '<img src="' . get_template_directory_uri() . '/images/columns/2.png" alt="One Left"/>',
			'3' => '<img src="' . get_template_directory_uri() . '/images/columns/3.png" alt="One Right"/>',
		),
        'default'   =>  '1'
	));

    $sidebar_options->add_field( array(
		'id'   => $prefix . 'sidebar_name',
		'name' => esc_html__( 'Sidebar Name', 'gogreen' ),
		'desc' => esc_html__( 'Select a sidebar to display.', 'gogreen' ),
		'type' => 'select',
        'options' => $sidebars,
        'default' => ''
	));
   
    /****************************
    * Footer Options 
    ******************************/
    $footer_options = new_cmb2_box( array(
		'id'         => 'footer_options',
		'title'      => esc_html__( 'Footer', 'gogreen' ),
        'icon'         => 'dashicons dashicons-editor-insertmore',
		'object_types'      => array('post'),
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