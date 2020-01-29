<?php
	
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-image-gallery';

    $gallery_attrs = array();
    $masonry_layout = array();
    $layout_count = 0;
    $col_name = '';

    switch( $gallery_type ){
        case 'slider':
            $gallery_attrs['class'] = 'owl-carousel';
            $gallery_attrs['data-items'] = intval( $visible_items );
            $gallery_attrs['data-navigation'] = ($show_navigation == 'true' ?  'true':'false');
            $gallery_attrs['data-pagination'] = ($show_pagination == 'true' ? 'true':'false');
            $gallery_attrs['data-loop'] = ($loop == 'true' ? 'true':'false');
            
            if( intval( $visible_items ) === 1 && !empty($transition) ) {                
                $gallery_attrs['data-transition'] = $transition;                
            }
            
            if( $auto_play == 'true' ){
                $gallery_attrs['data-auto-play'] = 'true';
                $gallery_attrs['data-speed'] = $speed;
            }else{
                $gallery_attrs['data-auto-play'] = 'false';
            } 

        break;
        case 'masonry':
            $classes[] = 'w-masonry w-'.$layout;

            $gallery_attrs['class'] = 'w-view clear';
            if( !empty($hover_effect) ) $gallery_attrs['class'] .= ' w-effect-'. $hover_effect;
            
            $masonry_layout = $this->get_masonry_layout( $layout );
            $layout_count = count($masonry_layout);
        break;
        default:
            $classes[] = 'w-'.$gallery_type;

            $gallery_attrs['class'] = 'w-view clear';
            if( !empty($hover_effect) ) $gallery_attrs['class'] .= ' w-effect-'. $hover_effect;           

            $col_name = gogreen_get_column_name($columns);
                        

        break;
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


    if( !empty($images) ){
        $images = explode(',', $images);
    }

    $gallery_id = wp_rand(0, 100);

    $item_index = 0;

?>
<div<?php echo gogreen_get_attributes( $attrs ); ?>>
    <div<?php echo gogreen_get_attributes( $gallery_attrs );?>>
    <?php foreach ($images as $image_id ): ?>
        <?php
        $item_class = '';
        if( $gallery_type == 'masonry' ){
            $key = ($item_index % $layout_count);
            if( isset($masonry_layout[$key]) ) $item_class = $masonry_layout[$key];
        }elseif(!empty($col_name)){
            $item_class = 'w-item '. $col_name;
        }                   
        ?>
        <div class="<?php echo esc_attr( $item_class ); ?>">
        <?php $cover_image = wp_get_attachment_image_src($image_id, $image_size); ?>
        <?php if( isset( $cover_image[0] ) ) :?>
        <?php 
        if( 'full' == $image_size ) {
            $lightbox_url = $cover_image[0];
        }else{
            $full_image = wp_get_attachment_image_src($image_id, 'full' );
            if( isset( $full_image[0] ) ){
                $lightbox_url =  $full_image[0];   
            }            
        }            
        ?>
        <a href="<?php echo esc_url($lightbox_url); ?>" data-rel="prettyPhoto[gallery-<?php echo esc_attr( $gallery_id ); ?>]">
        <?php
        echo wp_get_attachment_image($image_id, $image_size, false, array('class' => 'cover-image'));  
        if($gallery_type == 'masonry'){            
            echo sprintf('<div class="cover-image" style="background-image:url(%s);"></div>', esc_url( $cover_image[0] ));
        }
        ?>
        </a>
        <?php endif; ?>
        </div>
    <?php 
        $item_index++; 
        endforeach; 
    ?>
    </div>
</div>