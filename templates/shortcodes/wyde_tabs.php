<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-icon-tabs';

    if( $animation ){
        $classes[] = 'w-animation';
        $attrs['data-animation'] = $animation;
        if( $animation_delay ) $attrs['data-animation-delay'] = floatval( $animation_delay );
    } 

    if( !empty($el_class) ){
        $classes[] = $el_class;
    }

    $attrs['class'] = implode(' ', $classes);

    if( !empty($interval) ) $attrs['data-interval'] = intval( $interval );

    // Extract tab titles
    preg_match_all( '/wyde_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
    $tabs = array();
    if ( isset( $matches[1] ) ) {
	    $tabs = $matches[1];
    }
?>
<div<?php echo gogreen_get_attributes($attrs);?>>
    <ul class="w-tabs-nav">
        <?php
        $icon = '';
        foreach ( $tabs as $tab ) {
	        $tab_atts = shortcode_parse_atts($tab[0]);
            if( !empty($tab_atts['icon_set']) ){
                $icon = isset($tab_atts['icon_' . $tab_atts['icon_set']]) ? $tab_atts['icon_' . $tab_atts['icon_set']] : '';
            }else{
                $icon = isset($tab_atts['icon'])?$tab_atts['icon']:'';
            }

            if( !empty($icon) ) $icon = '<i class="'. esc_attr( $icon ) .'"></i>';
        ?>
        <li><a href="#<?php echo esc_attr($tab_atts['tab_id']); ?>"><?php echo wpb_js_remove_wpautop( $icon ); ?></a></li>
        <?php } ?>
    </ul>
    <div class="w-tab-wrapper">
        <?php echo wpb_js_remove_wpautop( $content );?> 
    </div>
</div>