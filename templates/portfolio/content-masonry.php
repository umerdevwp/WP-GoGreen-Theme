<figure>
    <?php 

    $image_size = 'gogreen-xlarge';
   
    $cover_id = get_post_thumbnail_id( get_the_ID() );
    $cover_image = '';   
    $lightbox_url = '';
    $cover_image_url = '';

    $cover_image = wp_get_attachment_image_src( $cover_id, $image_size ); 

    if( $cover_image[0] ){
        $cover_image_url = $cover_image[0];
        if( gogreen_get_option('portfolio_single_lightbox_size') == $image_size ) {
            $lightbox_url = $cover_image[0];
        }else{
            $full_image = wp_get_attachment_image_src( $cover_id, gogreen_get_option('portfolio_single_lightbox_size') );
            if( isset($full_image[0]) ){
                $lightbox_url = $full_image[0]; 
            }            
        }        
    }else{        
        $cover_image = gogreen_get_option('portfolio_placeholder_image');
        $cover_image_url = $cover_image['url'];        
    }    

    echo sprintf('<div class="cover-image" style="background-image:url(%s);"></div>', esc_url( $cover_image_url ) );


    ?>    
    <a href="<?php echo esc_url( get_permalink() );?>" title="<?php echo esc_attr( get_the_title() ); ?>"></a>
    <span>
        <?php if($lightbox_url){ ?>
            <a href="<?php echo esc_url( $lightbox_url );?>" data-rel="prettyPhoto[portfolio]" title="<?php echo esc_attr( get_the_title() ); ?>">
                <?php echo wp_get_attachment_image($cover_id, $image_size, false, array('class' => 'cover-image')); ?>
            </a>
        <?php } ?>
    </span>
    <figcaption>
        <h3><?php echo esc_html( get_the_title() );?></h3>
        <?php
        $cate_names = array();         
        $categories = get_the_terms( get_the_ID(), 'portfolio_category' );            
        if (is_array( $categories )) { 
            foreach ( $categories as $item ) 
            {
                $cate_names[] = $item->name;
            }
        }
        ?>
        <p><?php echo esc_html( implode(', ', $cate_names) ) ?></p>        
    </figcaption>
</figure>