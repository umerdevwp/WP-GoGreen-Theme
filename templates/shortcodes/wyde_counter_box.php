<?php 

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-counter-box';

    if( !empty($style) ){
        $classes[] = 'w-'.$style;
    }

    if( $animation ){
        $classes[] = 'w-animation';
        $attrs['data-animation'] = $animation;
        if( $animation_delay ) $attrs['data-animation-delay'] = floatval( $animation_delay );
    } 

    if( !empty($el_class) ){
        $classes[] = $el_class;
    }
  
	$attrs['class'] = implode(' ', $classes);

    $border_attrs = array();

    if( !empty($color) ){
        $attrs['style'] = 'color:'.$color.';';
        $border_attrs['style'] = 'background-color:'.$color;
    }

    if( !empty($icon_set) ){
        $icon = isset( ${"icon_" . $icon_set} )? ${"icon_" . $icon_set} : '';
    } 
?>
<div<?php echo gogreen_get_attributes( $attrs ) ;?>>
    <?php if( !empty( $icon ) ):?>
    <span><i class="<?php echo esc_attr( $icon );?>"></i></span>
    <?php endif; ?>
    <h3 class="counter-value" data-value="<?php echo esc_attr(  floatval( $value ) );?>" data-format="<?php echo esc_attr(  $format );?>" data-unit="<?php echo esc_attr(  $unit );?>"><?php echo floatval( $start );?></h3>
    <?php if( !empty( $title ) ):?>
    <h4 class="counter-title">        
        <span<?php echo gogreen_get_attributes( $border_attrs ) ;?>></span>
        <?php echo esc_html( $title );?>        
    </h4>
    <?php endif; ?>
</div>