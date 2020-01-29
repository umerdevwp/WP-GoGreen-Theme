<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-pricing-box';

    if($featured == 'true') $classes[] = 'w-featured';

    if( $animation ){
        $classes[] = 'w-animation';
        $attrs['data-animation'] = $animation;
        if( $animation_delay ) $attrs['data-animation-delay'] = floatval( $animation_delay );
    } 

    if( !empty($el_class) ){
        $classes[] = $el_class;
    }

    $attrs['class'] = implode(' ', $classes);

    $styles = array();

    if( !empty($color) ){
        $attrs['style'] = 'color:'.$color.';';
    } 

    $header_attrs = array();
    $header_attrs['class'] = 'box-header clear';

    $img_id = preg_replace( '/[^\d]/', '', $image );    
    if( !empty($img_id) ){
        $image_url = wp_get_attachment_image_src( $img_id, 'full' );
        if( is_array($image_url) ){
            $image_url = $image_url[0];
        }
        if( !empty($image_url) ){
            $header_attrs['class'] .= ' with-bg-image';
            $header_attrs['style'] = 'background-image:url('.$image_url.');';
        }
    } 

    $bg_color = $color;
    if( empty($bg_color) ){
        $bg_color = gogreen_get_color();
    }

    $button_attrs = array();   
    $button_attrs['class'] = 'box-button';
    if( !empty($button_color) ){
        $button_attrs['style'] = 'background-color:' . $button_color;
    }    

    $link_attrs = array();    

    $link = ( $link == '||' ) ? '' : $link;
       
    $link = vc_build_link( $link );

    $link_attrs['href'] = empty( $link['url'] ) ? '#' : esc_url( $link['url'] ); 

    if( !empty($link['title']) ){
        $link_attrs['title'] = $link['title']; 
    } 

    if( !empty($link['target']) ){
        $link_attrs['target'] = trim( $link['target'] );
    }    

?>
<div<?php echo gogreen_get_attributes( $attrs );?>>   
    <div<?php echo gogreen_get_attributes( $header_attrs );?>>
        <div class="w-background"></div>
        <?php if( !empty($price) ): ?> 
        <div class="box-price">
            <h5><sup><?php echo esc_html( $price_unit ); ?></sup><?php echo esc_html( $price ); ?></h5>
            <span><?php echo esc_html( $price_term ); ?></span>
        </div>
        <?php endif; ?>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 50" preserveAspectRatio="none">
          <polygon fill="<?php echo esc_attr( $bg_color );?>" points="0,50 0,0 50,50" />
          <polygon points="0,50 75,15 100,40 100, 50" />
        </svg>
    </div>
    <div class="w-header"> 
        <?php if( !empty($heading) ): ?>  
        <h3><?php echo esc_html( $heading );?></h3>
        <?php endif; ?>
        <?php if( !empty($sub_heading) ): ?>  
        <h4><?php echo esc_html( $sub_heading );?></h4>
        <?php endif; ?>
    </div>
    <div class="box-content">
    <?php if( !empty($content) ): ?>
    <?php echo wpb_js_remove_wpautop($content, true); ?>
    <?php endif;?>
    </div>
    <?php if( !empty($button_text) ): ?> 
    <div<?php echo gogreen_get_attributes( $button_attrs ); ?>>
    <a<?php echo gogreen_get_attributes( $link_attrs ); ?>><?php echo esc_html( $button_text ); ?></a>
    </div>
    <?php endif;?>
</div>