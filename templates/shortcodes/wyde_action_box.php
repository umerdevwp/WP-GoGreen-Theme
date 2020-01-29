<?php
        
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-action-box';

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

    if( !empty($bg_color) ){
        $attrs['style'] = 'background-color:'.$bg_color;
    }

    if( !empty($icon_set) ){
        $icon = isset( ${"icon_" . $icon_set} )? ${"icon_" . $icon_set} : '';
    } 

?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <div class="w-content">
        <?php if( !empty( $title ) ):?>
        <h3><?php echo esc_html($title); ?></h3>
        <?php endif;?>
        <?php if( !empty( $content ) ):?>
        <?php echo wpb_js_remove_wpautop($content, true); ?>
        <?php endif;?>
    </div>
    <?php if( !empty( $button_text ) ):?>
    <div class="w-action-button">
    <?php echo do_shortcode(sprintf('[wyde_link_button title="%s" link="%s" icon="%s" color="%s" hover_color="%s" bg_color="%s" size="%s" style="%s"]', 
        $button_text, $link, $icon, $color, $hover_color, $button_color, $size, $style)); ?>
    </div>
    <?php endif;?>
</div>


