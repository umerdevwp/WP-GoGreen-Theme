<?php
    
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-clients-carousel';

    if( $animation ){
        $classes[] = 'w-animation';
        $attrs['data-animation'] = $animation;
        if( $animation_delay ) $attrs['data-animation-delay'] = floatval( $animation_delay );
    } 

    if( !empty($el_class) ){
        $classes[] = $el_class;
    }

    $attrs['class'] = implode(' ', $classes);

    $slider_attrs = array();

    $slider_attrs['class'] = 'owl-carousel';

    $slider_attrs['data-items'] =  intval( $visible_items );
    $slider_attrs['data-auto-play'] = ($auto_play == 'true' ? 'true':'false');
    $slider_attrs['data-navigation'] = ($show_navigation == 'true' ?  'true':'false');
    $slider_attrs['data-pagination'] = ($show_pagination == 'true' ? 'true':'false');
    $slider_attrs['data-loop'] = ($loop == 'true' ? 'true':'false');

    if( !empty($images) ){
        $images = explode(',', $images);
    }

?>
<div<?php echo gogreen_get_attributes( $attrs ); ?>>
    <div<?php echo gogreen_get_attributes( $slider_attrs );?>>
    <?php foreach ($images as $image_id ){ ?>
        <div>
        <?php $image_attrs = wp_get_attachment_image_src($image_id, $image_size); ?>
        <?php if($image_attrs[0]) :?>
            <img src="<?php echo esc_url( $image_attrs[0] ); ?>" alt="<?php esc_attr( $title ); ?>" />
        <?php endif; ?>
        </div>
    <?php } ?>
    </div>
</div>