<?php 

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-icon-block';

    if( !empty($size) ) $classes[] = 'w-'.$size;
    if( !empty($style) ) $classes[] = 'w-'.$style;

    $styles = array();
    $border_attrs = array();

    if( $style == 'none'){
        if( !empty($color) ){
            $styles[] = 'color:'.$color;
        }
    }else{

        if( !empty($hover) ) $classes[] = 'w-effect-'.$hover;

        if( !empty($bg_color) ){
            $styles[] = 'background-color:'.$bg_color;
            $styles[] = 'border-color:'.$bg_color;
        }       

        $border_attrs['class'] = 'w-border';
        if( count( $styles ) > 0 ){
            $border_attrs['style'] = implode(';', $styles);
        }
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

    $attrs['style'] = implode(';', $styles);

    $link = ( $link == '||' ) ? '' : $link;
       
    $link = vc_build_link( $link );

    $link_attrs = array();

    if( !empty($link['url']) ){

        $link_attrs['href'] = esc_url( $link['url'] ); 

        if( !empty($link['target']) ){
            $link_attrs['target'] = trim($link['target']);
        } 
   
        if( !empty($link['title']) ){
            $link_attrs['title'] = $link['title'];    
        }

    }

    if( !empty($icon_set) ){
        $icon = isset( ${"icon_" . $icon_set} )? ${"icon_" . $icon_set} : '';
    } 
    
?>
<span<?php echo gogreen_get_attributes( $attrs ); ?>>
    <?php if( $style != 'none' ):?>
    <span<?php echo gogreen_get_attributes( $border_attrs ); ?>></span>
    <?php endif; ?>
    <?php if( !empty($link['url']) ):?>
    <a<?php echo gogreen_get_attributes( $link_attrs ); ?>>
    <?php endif; ?>
        <?php if( !empty($icon) ):?>
        <i class="<?php echo esc_attr( $icon );?>"></i>
        <?php endif; ?>
    <?php if( !empty($link['url']) ):?>
    </a>
    <?php endif; ?>
</span>