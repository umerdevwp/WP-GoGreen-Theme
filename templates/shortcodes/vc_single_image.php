<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $styles = array();

    $classes[] = 'w-image';

    if( !empty($alignment) ){
        $classes[] = 'text-'.$alignment;
    }

    if( !empty($style) ){
        $classes[] = 'w-'.$style;
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


    if( !empty($border_color) ){
        $attrs['style'] = 'border-color:'.$border_color;
    }

    $img_id = preg_replace( '/[^\d]/', '', $image );    

    if( $img_id ):

        $link_attrs = array();
        $full_image = array();

        if ( !empty($onclick) ) {

            if( $onclick === 'custom_link' ){

                if( !empty($link) ){
                    $link_attrs['href'] = esc_url( $link ); 
                }                 

                if( !empty($link_target) ){
                    $link_attrs['target'] = trim( $link_target );
                } 

            }else{                

                
                $full_image = wp_get_attachment_image_src( $img_id, 'full' );                    

                if( isset($full_image[0]) ){
                    $link_attrs['href'] = esc_url( $full_image[0] ); 
                }

                if( $onclick === 'link_image' ){
                   $link_attrs['data-rel'] = 'prettyPhoto'; 
                }else{
                    $link_attrs['target'] = $link_target;
                }        

            }                          
            
        }        

?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <?php if( isset($link_attrs['href']) ) : ?>
    <a<?php echo gogreen_get_attributes( $link_attrs ); ?>>
    <?php endif; ?>
        <?php echo wp_get_attachment_image($img_id, $img_size); ?>
    <?php if( isset($link_attrs['href']) ) : ?>
    </a>
    <?php endif; ?>
</div>
<?php endif; ?>