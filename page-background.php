<?php

    $page_bg = get_post_meta( gogreen_get_current_page(), '_w_background', true );
    
    if( empty($page_bg) ){
        return;
    }
    
    $attrs = array();

    $classes = array();

    $classes[] = 'page-background';

    $bg_image_url = '';
    $bg_image_size = '';
    if($page_bg == 'image'){
        $bg_image_url =   get_post_meta( gogreen_get_current_page(), '_w_background_image', true ); 
        $bg_image_size = 'w-'.get_post_meta( gogreen_get_current_page(), '_w_background_size', true );
    }

    $page_bg_color = get_post_meta( gogreen_get_current_page(), '_w_background_color', true );

    $attrs['class'] = implode(' ', $classes);

    if( !empty($page_bg_color) ){
        $attrs['style'] = 'background-color:'.$page_bg_color.'';
    } 

    $page_overlay_color = get_post_meta( gogreen_get_current_page(), '_w_background_overlay_color', true ); 
    $page_overlay_opacity = get_post_meta( gogreen_get_current_page(), '_w_background_overlay_opacity', true ); 

?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <?php if( !empty($bg_image_url) ): ?>
    <div class="bg-image <?php echo esc_attr($bg_image_size); ?>" style="background-image: url('<?php echo esc_url( $bg_image_url );?>');"></div>
    <?php if( !empty($page_overlay_color) ) { ?>
    <?php 
    $opacity = '';
    if( !empty($page_overlay_opacity) ){
        $opacity = 'opacity:'.$page_overlay_opacity.';';
    }
    ?>
    <div class="bg-overlay" style="background-color: <?php echo esc_attr( $page_overlay_color ); ?>;<?php echo esc_attr( $opacity ); ?>"></div>
    <?php } ?>
    <?php endif; ?>
</div>