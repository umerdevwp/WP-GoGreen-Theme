<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();
    $classes = array();
    $classes[] = 'w-banner';
    if( !empty($banner_style) ) $classes[] = 'w-'.$banner_style;

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

    $img_id = preg_replace( '/[^\d]/', '', $image );    
    if( !empty($img_id) ){
        $image_url = wp_get_attachment_image_src( $img_id, $image_size );
        if( is_array($image_url) ){
            $image_url = $image_url[0];
        }
    } 

    $link = ( $link == '||' ) ? '' : $link;
       
    $link = vc_build_link( $link );

    $link_attrs = array();

    if( !empty( $link['url'] ) ){                

        $link_attrs['href'] = esc_url( $link['url'] ); 

        if( !empty($link['title']) ){
            $link_attrs['title'] = $link['title']; 
        } 

        if( !empty($link['target']) ){
            $link_attrs['target'] = trim( $link['target'] );
        }
        
    }

    $banner_attrs = array();
    $banner_attrs['class'] = 'w-banner-title';
    if( !empty($bg_color) ){
        $banner_attrs['style'] = 'background-color:'.$bg_color;
    }

    $heading_attrs = array();
    if( !empty($heading_color) ){
        $heading_attrs['style'] = 'color:'.$heading_color;
    }

    $subheading_attrs = array();
    $subheading_attrs['class'] = 'subheading';
    if( !empty($subheading_color) ){
        $subheading_attrs['style'] = 'color:'.$subheading_color;
    }
    
?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
	<?php if( !empty($image_url) ){ ?>
    <img src="<?php echo esc_attr($image_url);?>" alt="" />
    <?php }	?>
    <div<?php echo gogreen_get_attributes( $banner_attrs );?>>
        <h2<?php echo gogreen_get_attributes( $heading_attrs );?>><?php echo wpb_js_remove_wpautop($title);?></h2>
        <h2<?php echo gogreen_get_attributes( $subheading_attrs );?>><?php echo wpb_js_remove_wpautop($subheading);?></h2>
    </div>
    <?php if( !empty( $link['url'] ) ):?>
        <a<?php echo gogreen_get_attributes( $link_attrs );?>></a>
    <?php endif;?>
</div>

