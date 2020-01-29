<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-toggle';

    if($open == 'true') $classes[] = 'active';

    if( $animation ){
        $classes[] = 'w-animation';
        $attrs['data-animation'] = $animation;
        if( $animation_delay ) $attrs['data-animation-delay'] = floatval( $animation_delay );
    } 

    $attrs['class'] = implode(' ', $classes);     

?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <h3><?php echo esc_html( $title );?></h3>
    <div><?php echo wpb_js_remove_wpautop($content, true);?></div>
</div>