<?php
        
    extract( shortcode_atts( array(
        'title' => '',
        'value' => 80,
        'label_style' => '',
        'label'  => '',
        'icon_set' => '',
        'icon' => '',
        'icon_typicons' => '',
        'icon_linecons' => '',
        'icon_bigmug_line' => '',
        'icon_simple_line' => '',
        'icon_farming' => '',
        'style' => '',
        'type'  => '',
        'bar_color'   => '',
        'bar_border_color'   => '',
        'fill_color'   => '',
        'start'   => '',
        'animation' =>  '',
        'animation_delay' =>  0,
        'el_class' =>  '',
        'css' =>  '',
    ), $atts ) );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-donut-chart';

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

        
    if( !empty($value) ){
        $attrs['data-value'] =  floatval( $value );
    } 

    if( !empty($style) ){
        $attrs['data-border'] = $style;
    } 

    if( !empty($bar_color) ){
        $attrs['data-color'] = $bar_color;
    }else{
        $attrs['data-color'] = gogreen_get_color();            
    } 

    if( !empty($bar_border_color) ){
        $attrs['data-bgcolor'] = $bar_border_color;
    } 

    if( !empty($fill_color) ){
        $attrs['data-fill'] = $fill_color;
    } 

    if( !empty($start) ){
        $attrs['data-startdegree'] = $start;
    } 

    if( !empty($type) ){
        $attrs['data-type'] = $type;
    } 
    
    if( $label_style == 'icon' && !empty($icon_set) ){
        $icon = isset( ${"icon_" . $icon_set} )? ${"icon_" . $icon_set} : '';
    } 
?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <span>
    <?php if( !empty($icon) ){ ?>
    <i class="<?php echo esc_attr($icon);?>"></i>
    <?php }else{ ?>
    <?php echo esc_html($label);?></span>
    <?php } ?>
    </span>
    <?php if( !empty($title) ){ ?>
    <h3><?php echo esc_html($title);?></h3>
    <?php } ?>
</div>