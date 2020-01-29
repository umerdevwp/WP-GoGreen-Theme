<?php

    $tags = get_the_tags();
    
    if ( is_array($tags) ) {
        
        $tag_ids = array();

        foreach($tags as $tag){
            $tag_ids[] = $tag->term_id;
        } 

        $columns = intval( gogreen_get_option('blog_single_related_posts') );
    
        $args=array(
            'tag__in' => $tag_ids,
            'post__not_in' => array( get_the_ID() ),
            'posts_per_page'    => $columns,
            'ignore_sticky_posts'   => 1
        );

        $post_query = new WP_Query( $args );
         
        if( $post_query->have_posts() ) {


        $col_name = gogreen_get_column_name($columns);
        
        
?>
<div class="related-posts">
    <h3><?php echo esc_html__('Related Posts', 'gogreen' );?></h3>
    <ul class="row">
    <?php
    
    $image_size = 'gogreen-medium';

    while( $post_query->have_posts() ) :

	    $post_query->the_post();
        
        $cover_id = get_post_thumbnail_id(get_the_ID());

	?>
	    <li class="col <?php echo esc_attr($col_name);?>">            
            <h4>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>
            <?php if( $cover_id ) : ?>
            <span class="thumb">
                <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
                    <?php echo wp_get_attachment_image($cover_id, $image_size); ?>
                </a>
            </span>
            <?php endif; ?>
            <span class="post-category"><strong><?php echo esc_html__('In', 'gogreen'); ?></strong><?php echo gogreen_get_single_category(); ?></span>
		</li>
	<?php endwhile; ?>
    </ul>
</div>
<?php
	    }
	wp_reset_postdata();
    }