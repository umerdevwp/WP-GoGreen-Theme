<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    if ( $media_url == '' ) {
        return;
    }

    $classes = array();

    $classes[] = 'w-video video-wrapper';
   
    global $wp_embed;

    $video_width =  isset( $GLOBALS['content_width'] ) ? intval( $GLOBALS['content_width'] ) : 1170;
    $video_height = absint( $video_width / 1.61 );

    $embed_html = '';

    if ( is_object( $wp_embed ) ) {

        $embed_html = $wp_embed->run_shortcode( '[embed width="' . $video_width . '" height="' . $video_height . '"]' . $media_url . '[/embed]' );

    }else{

        $embed_html = wp_oembed_get($media_url, array(
            'width'     => $video_width,
            'height'    => $video_height
        ));

    }

    if( strpos ( $embed_html, '[video' ) !== false ){
        $embed_html = do_shortcode( $embed_html );
        $classes[] = 'wp-default-video';
    }    

    if( $animation ){
        $classes[] = 'w-animation';
        $attrs['data-animation'] = $animation;
        if( $animation_delay ) $attrs['data-animation-delay'] = floatval( $animation_delay );
    }  

    if( !empty($el_class) ){
        $classes[] = $el_class;
    }

    if( !empty($css) ){
        $classes[] = vc_shortcode_custom_css_class( $css, '' );    
    }

    $attrs['class'] = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ', $classes), $this->settings['base'], $atts ) );

?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <?php echo wpb_js_remove_wpautop( $embed_html ); ?>
</div>