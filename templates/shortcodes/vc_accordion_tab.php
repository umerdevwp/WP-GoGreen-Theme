<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-accordion-tab';

    if( !empty($el_class) ){
        $classes[] = $el_class;
    }

    $attrs['class'] = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ', $classes), $this->settings['base'], $atts ) );

    if( !empty($icon_set) ){
        $icon = isset( ${"icon_" . $icon_set} )? ${"icon_" . $icon_set} : '';
    } 

?>
<div<?php echo gogreen_get_attributes($attrs);?>>
    <h3 class="acd-header">
        <?php if( !empty($icon) ):?>
        <i class="<?php echo esc_attr( $icon );?>"></i>
        <?php endif; ?>
        <span>
        <?php echo esc_html( $title ); ?>
        </span>
    </h3>
    <div class="acd-content">
       <?php echo wpb_js_remove_wpautop( $content );?> 
    </div>
</div>