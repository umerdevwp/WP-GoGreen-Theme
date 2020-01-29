<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();
    $classes = array();

    if( $this->shortcode == 'vc_tour' ){
        $classes[] = 'w-tour clear';
    }else{
        $classes[] = 'w-tabs';
    }

    if( $animation ){
        $classes[] = 'w-animation';
        $attrs['data-animation'] = $animation;
        if( $animation_delay ) $attrs['data-animation-delay'] = floatval( $animation_delay );
    }    

    if( !empty($el_class) ){
        $classes[] = $el_class;
    }

    $attrs['class'] = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ', $classes), $this->settings['base'], $atts ) );

    if( !empty($interval) ) $attrs['data-interval'] = intval( $interval );

    // Extract tab titles
    preg_match_all( '/vc_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
    $tabs = array();
    if ( isset( $matches[1] ) ) {
        $tabs = $matches[1];
    }

?>
<div<?php echo gogreen_get_attributes($attrs);?>>
    <ul class="w-tabs-nav">
        <?php
        foreach ( $tabs as $tab ) {
            $tab_atts = shortcode_parse_atts($tab[0]);
            $title = '';
            if( isset($tab_atts['title']) ){
                $title = $tab_atts['title'];
            }
        ?>
        <li><h3><a href="#<?php echo esc_attr($tab_atts['tab_id']); ?>"><?php echo esc_html( $title ); ?></a></h3></li>
        <?php } ?>
    </ul>
    <div class="w-tab-wrapper">
        <?php echo wpb_js_remove_wpautop( $content );?> 
    </div>
</div>