<?php

	$prefix = '_w_';
  
    
    /***************************** 
    * Testimonial Options 
    ******************************/
    /** Customer Information **/
    $testimonial_options = new_cmb2_box( array(
		'id'         => 'testimonial_options',
		'title'      => esc_html__( 'Customer Information', 'gogreen' ),
		'object_types'      => array('wyde_testimonial'),
	) );

    $testimonial_options->add_field( array(
        'id'       => $prefix . 'testimonial_position',
		'name'     => esc_html__( 'Job Title', 'gogreen' ),
        'desc' => esc_html__( 'Insert a customer\'s job title.', 'gogreen' ),
		'type'     => 'text_medium'
	));

    $testimonial_options->add_field( array(
        'id'       => $prefix . 'testimonial_company',
		'name'     => esc_html__( 'Company', 'gogreen' ),
        'desc' => esc_html__( 'Insert a company name.', 'gogreen' ),
		'type'     => 'text_medium'
	));

    $testimonial_options->add_field( array(
        'id'   => $prefix . 'testimonial_website',
		'name' => esc_html__( 'Website', 'gogreen' ),
		'desc' => esc_html__( 'Insert a website URL for this customer or company.', 'gogreen' ),
		'type' => 'text_url'
	));

    $testimonial_options->add_field( array(
        'id'   => $prefix . 'testimonial_email',
		'name'     => esc_html__( 'Email Address', 'gogreen' ),
        'desc' => esc_html__( 'Insert a customer\'s email address.', 'gogreen' ),
		'type'     => 'text_medium'
	));

    $testimonial_options->add_field( array(
        'id'   => $prefix . 'testimonial_detail',
		'name' => '',
		'desc' => '',
		'type' => 'wysiwyg',
        'options' => array(
            'media_buttons' => false,
            'teeny' => true,
        ),
	));    