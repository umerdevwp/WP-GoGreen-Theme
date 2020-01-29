<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-accordion';

    if( $animation ){
        $classes[] = 'w-animation';
        $attrs['data-animation'] = $animation;
        if( $animation_delay ) $attrs['data-animation-delay'] = floatval( $animation_delay );
    } 

    if( !empty($el_class) ){
        $classes[] = $el_class;
    }

    $attrs['class'] = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ', $classes), $this->settings['base'], $atts ) );

    if( $collapsible == 'yes' ) $attrs['data-collapsible'] = $collapsible;
    $attrs['data-active'] = $active_tab;

    if( !empty($color) ) {
        $attrs['style'] = 'border-color:'.$color;
        $attrs['data-color'] =$color;
    }   

?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <?php echo wpb_js_remove_wpautop($content);?>
</div>