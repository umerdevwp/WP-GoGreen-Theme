<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-heading';

    if( !empty($style) ){
        $classes[] = 'heading-'.$style;
    }

    if( $style !== '5' && $style !== '6' && !empty($text_align) ){
        $classes[] = 'text-'. $text_align;
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

    $wrapper_attrs = array();
    $wrapper_attrs['class'] = 'w-wrapper';
    if( $style === '3' && !empty($background_color) ){
        $wrapper_attrs['style'] = 'background-color:'.$background_color;
    }

    $heading_attrs = array();
    if( !empty($heading_color) ){
        $heading_attrs['style'] = 'color:'.$heading_color;
        if( $style === '8' ){
            $heading_attrs['style'] .= ';border-color:'.$heading_color;
        }
    }

    $subheading_attrs = array();
    $subheading_attrs['class'] = 'subheading';
    if( !empty($subheading_color) ){
        $subheading_attrs['style'] = 'color:'.$subheading_color;
    }

    if( !empty($title) && $style == '9' ){
        $title = '<span>'.$title.'</span>';
    }
?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <div<?php echo gogreen_get_attributes( $wrapper_attrs );?>>
        <?php if( !empty($subheading) && ( $style === '1' || $style === '6' ) ) : ?> 
        <h4<?php echo gogreen_get_attributes( $subheading_attrs );?>><?php echo wpb_js_remove_wpautop($subheading);?></h4>
        <?php endif; ?>
        <?php if(!empty($title)) : ?> 
        <h2<?php echo gogreen_get_attributes( $heading_attrs );?>>           
            <?php echo wpb_js_remove_wpautop( $title ); ?>
        </h2>
        <?php endif; ?>
        <?php if( !empty($subheading) && !( $style === '1' || $style === '6' ) ) : ?> 
        <h4<?php echo gogreen_get_attributes( $subheading_attrs );?>><?php echo wpb_js_remove_wpautop($subheading);?></h4>
        <?php endif; ?>
    </div>
</div>