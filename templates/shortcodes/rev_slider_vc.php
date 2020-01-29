<?php
    
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-revslider';

    if( !empty($el_class) ){
        $classes[] = $el_class;
    }

    $attrs['class'] = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ', $classes), $this->settings['base'], $atts ) );

    $button_attrs = array();
    if( !empty($button_style) ){
        $button_attrs['class'] = 'w-scroll-button w-button-'. $button_style;
    }
    if( !empty($color) ){
        $button_attrs['style'] = 'border-color:'.$color.';color:'.$color;
    }

?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <?php 
    if( !empty($alias) ){
        echo apply_filters( 'vc_revslider_shortcode', do_shortcode( '[rev_slider ' . esc_attr( $alias ). ']' ) );
    }
    ?>
    <?php if( !empty($button_style) ): ?>
    <div<?php echo gogreen_get_attributes( $button_attrs );?>>
        <a href="#scroll">
            <i></i>
        </a>
    </div>
    <?php endif; ?>
</div>