<?php
    
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-half-donut-chart';

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

?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <?php echo do_shortcode( sprintf('[wyde_donut_chart value="%s" label_style="%s" label="%s" icon_set="%s" icon="%s" icon_typicons="%s" icon_linecons="%s" icon_bigmug_line="%s" icon_simple_line="%s" icon_farming="%s" style="%s" bar_color="%s" bar_border_color="%s" fill_color="%s" start="%s" type="half"]',
            esc_attr( $value ), 
            esc_attr( $label_style ), 
            esc_attr( $label ), 
            esc_attr( $icon_set ), 
            esc_attr( $icon ), 
            esc_attr( $icon_typicons ), 
            esc_attr( $icon_linecons ), 
            esc_attr( $icon_bigmug_line ), 
            esc_attr( $icon_simple_line ), 
            esc_attr( $icon_farming ), 
            esc_attr( $style ), 
            esc_attr( $bar_color ), 
            esc_attr( $bar_border_color ), 
            esc_attr( $fill_color ), 
            esc_attr( $start )
        ) );
    ?>
    <?php if( $title || $content): ?>
    <div class="w-content">
    <?php if(!empty($title)) : ?> 
        <h3><?php echo esc_html( $title );?></h3>
    <?php endif; ?>
    <?php if(!empty($content)) :?>
    <?php echo wpb_js_remove_wpautop($content, true); ?>
    <?php endif; ?>
    </div>
    <?php endif; ?>
</div>