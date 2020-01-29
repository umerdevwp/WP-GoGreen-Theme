<?php

    $has_cover = gogreen_get_option('portfolio_single_featured_image') && has_post_thumbnail();

    $images = get_post_meta(get_the_ID(), '_w_gallery_images', true);
                
    $embed_url = esc_url( get_post_meta(get_the_ID(), '_w_embed_url', true ) );

    $media_button = false;
    $image_size = 'gogreen-large';
    $gallery_name = '';
    if($images){
        $gallery_name = '[gallery-'.get_the_ID().']';
    }
    
?>
<div class="page-content">    
    <div class="container">  
        <?php if( !gogreen_has_title_area() ) the_title('<h2 class="post-title">', '</h2>'); ?>  
        <?php if( $has_cover || $images ) : ?>
        <div class="post-media w-masonry">
            <?php if(!$has_cover && !empty($embed_url) ): ?>      
            <?php echo do_shortcode( sprintf('[vc_video media_url="%s" el_class="featured"]', $embed_url) ); ?>
            <?php endif; ?>
            <ul class="w-view">
            <?php
                $masonry_layouts = array('w-item w-w2 w-h2', 'w-item', 'w-item', 'w-item w-w2', 'w-item', 'w-item', 'w-item w-w2 w-h2', 'w-item w-w2');
                $masonry_layouts = apply_filters('gogreen_portfolio_masonry', $masonry_layouts);
                $layout_count = count( $masonry_layouts );  
                $item_index = 0;
                $item_class = '';

                $cover_id = get_post_thumbnail_id(get_the_ID()); 
                $cover_image = wp_get_attachment_image_src($cover_id, $image_size ); 
           
                $lightbox_url = '';                    
                if( $has_cover ):
                    if( !empty( $embed_url ) ){

                        $lightbox_url = gogreen_get_media_preview( $embed_url );

                        $media_button = true;

                    }else{
                        if( gogreen_get_option('portfolio_single_lightbox_size') == $image_size ) {
                            $lightbox_url = $cover_image[0];
                        }else{
                            $full_image = wp_get_attachment_image_src($cover_id, gogreen_get_option('portfolio_single_lightbox_size') );
                            if( isset($full_image[0]) ){
                                $lightbox_url = $full_image[0]; 
                            }
                        }
                    }
            ?>
            <?php 
            if( $cover_id && isset($cover_image[0]) ) {
                $key = ($item_index % $layout_count);
                if( isset($masonry_layouts[$key]) ){
                    $item_class = $masonry_layouts[$key];                                  
                }  
            ?>
            <li class="<?php echo esc_attr($item_class); ?>">
                <div class="image-wrapper">                     
                    <div class="cover-image" style="background-image:url('<?php echo esc_url( $cover_image[0] ); ?>');"></div>
                    <a href="<?php echo esc_url( $lightbox_url );?>" data-rel="prettyPhoto<?php echo esc_attr($gallery_name);?>">
                        <?php echo wp_get_attachment_image($cover_id, $image_size, false, array('class' => 'cover-image')); ?>                
                        <?php if( $media_button ){ ?>
                            <span class="w-media-player"></span>
                        <?php } ?>
                    </a>
                </div>
            </li>
            <?php 
                $item_index++;
            }
            endif;            
            if( is_array($images) ){
            foreach( $images as $image_id => $image_url ):    
                $gallery_image = wp_get_attachment_image_src($image_id, $image_size );       
                $lightbox_url =  wp_get_attachment_image_src($image_id, gogreen_get_option('portfolio_single_lightbox_size') );
                if( is_array($lightbox_url) ){
                    $lightbox_url = $lightbox_url[0];
                } 

                $key = ($item_index % $layout_count);
                if( isset($masonry_layouts[$key]) ){
                    $item_class = $masonry_layouts[$key];                                  
                }  
            ?>
            <li class="<?php echo esc_attr($item_class); ?>">
                <div class="image-wrapper">                               
                    <div class="cover-image" style="background-image:url('<?php echo esc_url( $gallery_image[0] ); ?>');"></div>
                    <a href="<?php echo esc_url( $lightbox_url );?>" data-rel="prettyPhoto<?php echo esc_attr($gallery_name);?>">
                        <?php echo wp_get_attachment_image($image_id, $image_size, false, array('class' => 'cover-image')); ?>
                    </a>
                </div>
            </li>
            <?php    
                $item_index++;
            endforeach;
            }
            ?>
            </ul>
        </div>
        <?php endif; ?>            
    </div>
    <div class="container">        
        <div class="post-content">
        <?php the_content(); ?>
        </div>
        <div class="post-description row">
            <div class="col col-3">
                <div class="col-inner">                
                <?php gogreen_portfolio_widget('meta'); ?>
                </div>
            </div>
            <div class="col col-8 col-offset-1">
                <div class="col-inner">
                <?php gogreen_portfolio_widget('categories'); ?>
                <?php gogreen_portfolio_widget('skills'); ?>
                <?php gogreen_portfolio_widget('clients'); ?>
                <?php gogreen_portfolio_widget('fields'); ?>
                </div>
            </div>
        </div>
        <?php if(gogreen_get_option('portfolio_single_nav')) gogreen_portfolio_nav(); ?>
        <?php
        $related = get_post_meta(get_the_ID(), '_w_post_related', true);
        if( empty($related) ){
            $related = gogreen_get_option('portfolio_single_related');
        }
        if( $related && $related !== 'hide' ){
            gogreen_portfolio_related();
        }
        ?>
    </div>    
</div>