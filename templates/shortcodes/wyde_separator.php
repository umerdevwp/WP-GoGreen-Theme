<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-separator';

    if( empty($label_style) ){
        $classes[] = 'no-text';
    }

    if( !empty($text_align) ){
        $classes[] = 'text-'. $text_align;
    }

    $styles = array();
    $border_styles = array();

    if( !empty($style) ){
        $border_styles[] = 'border-style:'. $style;        
    }

    if( !empty($border_width) ){
        $border_styles[] = 'border-top-width:'. $border_width;
    }

    if( !empty($color) ){
        $styles[] = 'color:'. $color;
        $border_styles[] = 'border-color:'. $color;
    }

    if( !empty($el_class) ){
        $classes[] = $el_class;
    }
    
    if( !empty($css) ){
        $classes[] = vc_shortcode_custom_css_class( $css, '' );    
    }
    
    if( !empty($el_width) ){
        $styles[] = 'width:'. $el_width;
    }

    $attrs['class'] = implode(' ', $classes);
    
    $attrs['style'] = implode(';', $styles);    

    $border_attrs = array();
    $border_attrs['style'] = implode(';', $border_styles);

    if( $label_style == 'icon' && !empty($icon_set) ){
        $icon = isset( ${"icon_" . $icon_set} )? ${"icon_" . $icon_set} : '';
    } 

?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <span class="w-border-left"<?php echo gogreen_get_attributes( $border_attrs ); ?>></span>
    <span class="w-text">
        <?php if( $label_style == 'icon' && !empty($icon)){?>
        <i class="<?php echo esc_attr($icon); ?>"></i>
        <?php }else{ ?>
        <?php echo esc_html($title); ?>
        <?php } ?>
    </span>
    <span class="w-border-right"<?php echo gogreen_get_attributes( $border_attrs ); ?>></span>
</div>