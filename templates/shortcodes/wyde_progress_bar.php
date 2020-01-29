<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-progress-bar';
    
    $hide_counter = 0;
    
    $options = explode( ",", $options );
    /*
    if ( in_array( "animated", $options ) ) $classes[] = "animated";
    if ( in_array( "striped", $options ) ) $classes[] = "striped";
    */

    if ( in_array( "hidecounter", $options ) ) $hide_counter = 1;

    if( !empty($el_class) ){
        $classes[] = $el_class;
    }
        
    $attrs['class'] = implode(' ', $classes);

    $bar_attrs = array();
    $bar_attrs['class'] = 'w-bar';
    if( !empty($color) ){
        $bar_attrs['style'] = 'background-color:'.$color;
    }

    $attrs['data-value'] = $value;
    $attrs['data-unit'] = $unit;

?>
<div<?php echo gogreen_get_attributes($attrs);?>>
    <h4>
        <?php echo esc_html( $title );?>
        <?php if( !$hide_counter ):?>
        <strong class="w-counter"><?php echo esc_html( '0 '. $unit );?></strong>
        <?php endif; ?>
    </h4>
    <div class="w-bar-wrapper">
        <div<?php echo gogreen_get_attributes($bar_attrs);?>></div>
    </div>
</div>