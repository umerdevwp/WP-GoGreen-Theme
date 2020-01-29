<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    switch($style){
        case 'round':
            $classes[] = 'w-button round';
        break;
        case 'rounded':
            $classes[] = 'w-button rounded';
        break;
        case 'outline':
            $classes[] = 'w-ghost-button';
        break;
        case 'round-outline':
            $classes[] = 'w-ghost-button round';
        break;        
        case 'rounded-outline':
            $classes[] = 'w-ghost-button rounded';
        break;
        default:
            $classes[] = 'w-button';
        break;
    }

    if( !empty( $size ) ){
        $classes[] = $size;
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

    $attrs['class'] = implode(' ', $classes);

    $styles = array();
    if($style == 'outline' || $style == 'round-outline'){
        if( !empty( $bg_color ) ){
            $styles[] = 'border-color:'.$bg_color.';color:'.$bg_color.';';
        }
    }else{
        if( !empty( $bg_color ) ){
            $styles[] = 'border-color:'.$bg_color.';background-color:'.$bg_color.';';
        }
        if( !empty($color) ){
            $styles[] = 'color:'.$color;
        }
    }

   
    $attrs['style'] = implode(';', $styles);

    $link = ( $link == '||' ) ? '' : $link;
    
    $link = vc_build_link( $link );

    $attrs['href'] = empty( $link['url'] ) ? '#' : esc_url( $link['url'] ); 

    if( !empty($link['title']) ){
        $attrs['title'] = $link['title'];    
    }

    if( !empty($link['target']) ){
        $attrs['target'] = trim($link['target']);
    } 
?>
<a<?php echo gogreen_get_attributes( $attrs );?>>
    <span><?php echo esc_html( $title ); ?></span>
</a>