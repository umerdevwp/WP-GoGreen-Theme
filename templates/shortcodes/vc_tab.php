<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $attrs['id'] = $tab_id;

    $classes = array();

    $classes[] = 'w-tab';

    $attrs['class'] = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ', $classes), $this->settings['base'], $atts ) );
?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <div class="w-tab-content">
    <?php echo wpb_js_remove_wpautop($content);?> 
    </div>
</div>