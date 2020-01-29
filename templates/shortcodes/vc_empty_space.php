<?php
    
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = "w-space";

    if( !empty($el_class) ){
        $classes[] = $el_class;
    }
        
    $attrs['class'] = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ', $classes), $this->settings['base'], $atts ) );

    $pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
    // allowed metrics: http://www.w3schools.com/cssref/css_units.asp
    $regexr = preg_match($pattern,$height,$matches);
    $value = isset( $matches[1] ) ? (float) $matches[1] : (float) WPBMap::getParam('vc_empty_space','height');
    $unit = isset( $matches[2] ) ? $matches[2] : 'px';
    $height = $value . $unit;

    if( (float) $height >= 0.0 ){
        $attrs['style'] = 'height:'.$height;
    }

?>
<div<?php echo gogreen_get_attributes( $attrs );?>></div>