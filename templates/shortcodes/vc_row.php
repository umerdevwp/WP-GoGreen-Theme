<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );    

    $attrs = array();

    $classes = array();
    
    $styles = array();
    

    if( !empty($el_id) ){
        $attrs['id'] = sanitize_title_with_dashes( $el_id );
    }

    $classes[] = 'w-section';

    switch ($row_style) {
        case 'full-width':
            $classes[] = 'w-full';
            break;
        case 'full-height':
            $classes[] = 'w-full-height';
            break;   
        case 'full-screen':
            $classes[] = 'w-full';
            $classes[] = 'w-full-height';
            break;          
    }   

    if( !empty($text_style) ) $classes[] = 'w-text-'.$text_style;           
    if( !empty($padding_size) ) $classes[] = $padding_size; 
    
    

    if( !empty($overlap) ){
        $classes[] = 'w-overlap-box';
        $styles[] = $overlap.':-'. $overlap_distance;
    }
    
    if( !empty($overlap_index) ){
        $styles[] = 'z-index:'.$overlap_index;
    }

    $background = '';
    $overlay = '';
    if( !empty($background_image) ){
        $image_id = preg_replace( '/[^\d]/', '', $background_image );
        if( $image_id ){
            $image = wp_get_attachment_image_src( $image_id, 'full' );
            if( $image[0] ){
                $bg_styles = array();
                $bg_styles[] = sprintf('background-image:url(%s)', $image[0]);
                if( !empty($background_style) ){
                    switch($background_style){
                        case 'repeat':
                        case 'no-repeat':
                        $bg_styles[] = 'background-size:auto;background-repeat:'.$background_style;
                        break;
                        default:
                        $bg_styles[] = 'background-size:'.$background_style;
                        break;
                    }
                }

                if( !empty($background_position) ){
                    $bg_styles[] = 'background-position:'.$background_position;
                }
                
                $background = sprintf('<div class="bg-wrapper bg-image" style="%s"></div>', implode(';', $bg_styles));

                if( !empty($parallax) ){
                    $classes[] =  'w-parallax';
                    if( $parallax == 'reverse' ) $classes[] = 'w-reverse';
                }

                if($background_overlay == 'color'){

                    $overlay_styles = array();
                    if( !empty($overlay_color) ){

                        $overlay_styles[] = 'background-color:'.$overlay_color;
                        if( !empty($overlay_opacity) ){
                            $overlay_styles[] = 'opacity:'.$overlay_opacity;
                        }

                        $overlay_style = implode(';', $overlay_styles);

                        if( !empty($overlay_style ) ) $overlay_style = ' style="'.$overlay_style.'"';

                        $overlay = sprintf('<div class="bg-overlay"%s></div>', $overlay_style);
                    }
                }
            } 
        }        
    }    

    $flex_row = false;
    
    $row_classes = array();

    $row_classes[] = 'row';

    if( !empty($equal_height) ){
        $row_classes[] = 'w-equal-height';
        $flex_row = true;
    }   

    if( !empty($vertical_align) ){
        $row_classes[] = 'w-align-'.$vertical_align;
        $flex_row = true;
    }

    if( $flex_row ){
        $row_classes[] = 'w-row-flex';
    }

    if( !empty($css) ){
        $classes[] = vc_shortcode_custom_css_class( $css, '' );
    } 
    
    if( !empty($el_class) ){
        $classes[] =  $el_class;
    } 

    if( !empty($background_color) ){
        $styles[] = 'background-color:'.$background_color;
    }

    $attrs['class'] = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ', $classes), $this->settings['base'], $atts ) );
    
    if( count($styles) )  $attrs['style'] = implode(';', $styles);
    
?>
<section<?php echo gogreen_get_attributes( $attrs );?>>
<?php 
    if( !empty($background) ){
        echo sprintf('<div class="section-background">%s%s</div>', $background, $overlay); 
    }
    echo '<div class="'. esc_attr( implode(' ', $row_classes) ) .'">';
    echo wpb_js_remove_wpautop($content);
    echo '</div>';
    ?>
</section>