<?php 

    $has_cover = has_post_thumbnail();

    $images = get_post_meta(get_the_ID(), '_w_gallery_images', true);
        
?>
<figure>
    <div class="post-media">
        <div class="w-gallery w-fadeslider">
        <?php  
        
            $image_size = 'gogreen-large';               

            $cover_id = get_post_thumbnail_id(get_the_ID()); 
            $cover_image = wp_get_attachment_image_src($cover_id, $image_size );
            
            $cover_image_url = '';
            if( $cover_image[0] ){
                $cover_image_url = $cover_image[0];
            }else{
                $cover_image = gogreen_get_option('portfolio_placeholder_image');
                $cover_image_url = $cover_image['url'];
            }
            ?>
            <div class="cover-image" style="background-image: url('<?php echo esc_url( $cover_image_url );?>');"><a href="<?php echo esc_url( get_permalink() );?>" title="<?php echo esc_attr( get_the_title() ); ?>"></a></div>
            <?php   
            if( is_array($images) ): 
                foreach((array) $images as $image_id => $image_url): 
                    $gallery_image = wp_get_attachment_image_src($image_id, $image_size); 
                    if( isset( $gallery_image[0] ) ){
            ?>
            <div class="cover-image" style="background-image: url('<?php echo esc_url( $gallery_image[0] );?>');"><a href="<?php echo esc_url( get_permalink() );?>" title="<?php echo esc_attr( get_the_title() ); ?>"></a></div>
            <?php   }
                endforeach; 
            endif; 
            ?>
        </div>
        <?php if( is_array($images) && count($images) > 0){ ?>
        <span class="w-gallery-icon">
        <?php echo count($images) + ($has_cover?1:0);?>
        </span> 
        <?php } ?>
    </div>
    <figcaption>
        <h3><a href="<?php echo esc_url( get_permalink() );?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo get_the_title();?></a></h3>
        <?php
        $cate_names = array();         
        $categories = get_the_terms( get_the_ID(), 'portfolio_category' );            
        if ( is_array($categories) ) { 
            foreach ( $categories as $item ) 
            {
                $cate_names[] = $item->name;
            }
        }
        ?>
        <p><?php echo implode(', ', $cate_names); ?></p>
    </figcaption>
</figure>