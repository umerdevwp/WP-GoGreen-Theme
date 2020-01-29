<?php

    if( !isset( $item_index ) ) $item_index = 0;
    if( !isset( $blog_excerpt ) ) $blog_excerpt = gogreen_get_option('blog_excerpt');
    if( !isset( $blog_excerpt_base ) ) $blog_excerpt_base = gogreen_get_option('blog_excerpt_base');
    if( !isset( $blog_excerpt_length ) ) $blog_excerpt_length = gogreen_get_option('blog_excerpt_length');
    if( !isset( $blog_excerpt_more ) ) $blog_excerpt_more = gogreen_get_option('blog_excerpt_more');

    $post_format = get_post_format();

    $has_cover = has_post_thumbnail();

    $images = '';
    $embed_url = '';
    $post_link = '';
    switch( $post_format ){
        case 'gallery':
            $images = get_post_meta(get_the_ID(), '_w_gallery_images', true);
        break;
        case 'link':
            $post_link = get_post_meta(get_the_ID(), '_w_post_link', true);
        break;
        case 'audio':
        case 'video':
            $embed_url = esc_url( get_post_meta(get_the_ID(), '_w_embed_url', true ) );
        break;
    }

    $post_media = 'no-cover';  
    $cover_id = ''; 
    $link_attrs = array();
    $media_button = false;    
    $quote_content_attrs = array();
    $quote_content_attrs['class'] = 'post-content';
    if( $has_cover || $images || !empty( $embed_url ) ){  

        $post_media = 'has-cover';      

        $image_size = 'gogreen-fullwidth';       

        if($has_cover){

            $cover_id = get_post_thumbnail_id(get_the_ID());             
            
            if( $post_format == 'quote' ){
                $cover_image = wp_get_attachment_image_src($cover_id, $image_size ); 
                $quote_content_attrs['style'] = 'background-image:url('. esc_url($cover_image[0]).');';
            }                      
        }            

        if( !empty( $embed_url ) ){
            $link_attrs['href'] = gogreen_get_media_preview( $embed_url );
            $link_attrs['data-rel'] = 'prettyPhoto['. get_the_ID(). ']';
            $media_button = true;
        }else{
            $link_attrs['href'] = esc_url( get_permalink() );
        }
    }

?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_media); ?>>
<?php if( gogreen_get_option('blog_meta_date', true) ){ ?>
    <span class="post-date">
        <a href="<?php echo esc_url( get_day_link( get_the_date('Y'), get_the_date('m'), get_the_date('d') ) );?>">
            <span><?php echo get_the_date('M'); ?></span>
            <strong><?php echo get_the_date('d'); ?></strong>
            <span><?php echo get_the_date('Y'); ?></span>
        </a>
    </span>
<?php } ?>
<?php if( $post_format == 'quote' ){ ?>
    <div<?php echo gogreen_get_attributes($quote_content_attrs);?>>
        <?php gogreen_post_title(); ?>
        <div class="post-meta">
            <?php if( gogreen_get_option('blog_meta_category', true) ): ?>
            <span class="meta-category">
                <strong><?php echo esc_html__('In', 'gogreen'); ?></strong><?php echo gogreen_get_single_category(); ?>
            </span>  
            <?php endif; ?>
            <?php edit_post_link('', '<span class="meta-edit">', '</span>' ); ?>
        </div>
        <?php 
        if( gogreen_get_option('blog_meta_share', true) ){            
            gogreen_blog_share_buttons();
        }
        ?> 
    </div>    
<?php
    
}else{
    
    if( $has_cover || $images || !empty( $embed_url ) ): ?>      
    <div class="post-media">
        <?php if( $images ){ ?>
        <div class="w-gallery owl-carousel" data-auto-height="true" data-loop="true" data-auto-play="true">
        <?php } ?>
            <?php if( $cover_id ){ ?>
            <div>
                <a<?php echo gogreen_get_attributes( $link_attrs );?>>
                    <?php echo wp_get_attachment_image($cover_id, $image_size); ?>
                    <?php if( $media_button ){ ?>
                    <span class="post-media-icon"></span>
                    <?php } ?>
                </a>
            </div>
            <?php }elseif( !empty( $embed_url ) ){ ?>
            <div>                
                <?php echo do_shortcode( sprintf('[vc_video media_url="%s"]', $embed_url) ); ?>
            </div>
            <?php } ?>
            <?php 
            if( is_array($images) ){
                foreach( $images as $image_id => $image_url ){
            ?>
            <div>
                <a href="<?php echo esc_url( get_permalink() );?>">
                    <?php echo wp_get_attachment_image($image_id, $image_size); ?>
                </a>
            </div>
            <?php 
                } 
            }
            ?>
        <?php if( $images ){ ?>
        </div>
        <?php } ?>
    </div>
    <?php endif; ?>
    <div class="post-content">        
        <?php gogreen_post_title(); ?>
        <div class="post-meta">           
            <?php if( gogreen_get_option('blog_meta_author', true) ){?>
            <span class="meta-author">
                <strong><?php echo esc_html__('By', 'gogreen');?></strong><?php echo the_author_posts_link();?>
            </span>
            <?php }?>
            <?php if( gogreen_get_option('blog_meta_category', true) ){?>
            <span class="meta-category">
                <strong><?php echo esc_html__('In', 'gogreen');?></strong><?php echo gogreen_get_single_category(); ?>
            </span>  
            <?php }?>                       
            <?php if ( gogreen_get_option('blog_meta_comment', true) && ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
            <?php gogreen_blog_comments(); ?>
            <?php endif; ?>            
            <?php
            edit_post_link('', '<span class="meta-edit">', '</span>' );
            ?>            
        </div>
        <div class="post-summary clear">
        <?php
        if( !empty($post_link) ){
            $urls = parse_url($post_link);        
        ?>  
            <p class="post-external-link"><a href="<?php echo esc_url($post_link); ?>" target="_blank"><i class="gg-export"></i> <?php echo esc_url( $urls['host'] ); ?></a></p>
        <?php
        }

        if( $blog_excerpt ){            
            echo '<div class="post-excerpt">';
            echo gogreen_get_excerpt( $blog_excerpt_base, $blog_excerpt_length, false );   
            echo '</div>';         
        }else{
            the_content( esc_html__( 'Continue reading', 'gogreen' ) );
        }

        wp_link_pages(array( 'before' => '<div class="page-links clear">', 'after' => '</div>', 'link_before' => '<span>', 'link_after'  => '</span>' ));
        
        ?>
        </div>
        <div class="post-footer clear">
        <?php 
        if( $blog_excerpt_more ){
            echo gogreen_get_excerpt_more( $blog_excerpt_more );
        }
        if( gogreen_get_option('blog_meta_share', true) ){            
            gogreen_blog_share_buttons();
        }
        ?> 
        </div>
    </div>
<?php } ?>
</article>