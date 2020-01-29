<?php
    
    $tags = get_the_terms( get_the_ID(), 'portfolio_tag' );
    if ( is_array($tags) ) {
        
        $tag_ids = array();

        foreach($tags as $tag){
            $tag_ids[] = $tag->term_id;
        } 
    
        $args = array(
            'post_type' => 'wyde_portfolio',
	        'tax_query' => array(
		        array(
			        'taxonomy' => 'portfolio_tag',
			        'field'    => 'id',
			        'terms'    => $tag_ids,
		        ),
	        ),
            'post__not_in' => array(get_the_ID()),
            'posts_per_page'    => intval( gogreen_get_option('portfolio_single_related_posts') ),
            'ignore_sticky_posts'   => 1
        );

        $post_query = new WP_Query( $args );
         
        if( $post_query->have_posts() ) {
?>
<div class="related-posts clear">
    <h3><?php echo esc_html__('Related Projects', 'gogreen' );?></h3>
    <ul class="row">
    <?php    
    $image_size = 'gogreen-medium';
    
    while( $post_query->have_posts() ) :

	    $post_query->the_post();

        $cover_id = get_post_thumbnail_id(get_the_ID());        
	?>
	    <li class="col col-2">
            <span class="thumb">
            <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
            <?php 
            if( $cover_id ) {
                echo wp_get_attachment_image($cover_id, $image_size);
            }else{
                $cover_image = gogreen_get_option('portfolio_placeholder_image');
                echo '<img src="'. esc_url( $cover_image['url'] ) .'" alt="'. esc_attr(get_the_title()) .'" />';
            }
            ?>
            </a>
            </span>
		</li>
	<?php endwhile; ?>
    </ul>
</div>
<?php
	    }
    wp_reset_postdata();
    }