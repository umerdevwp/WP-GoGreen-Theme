<?php

	$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

    extract( $atts );
            
    $attrs = array();

    $classes = array();

    $classes[] = 'w-popular-posts';

   if( !empty($el_class) ){
        $classes[] = $el_class;
    }   

    $attrs['class'] = implode(' ', $classes);

    if ( $count != '' && ! is_numeric( $count ) ) $count = - 1;

	$post_query = new WP_Query( array(
			    'posts_per_page'      => intval( $count ),
	            'has_password' => false,
			    'ignore_sticky_posts' => true,
	            'meta_key' => '_w_post_views', 
	            'orderby' => 'meta_value_num', 
	            'order' => 'DESC'
	        ) );
	
?>
<div<?php echo gogreen_get_attributes( $attrs ); ?>>
    <ul class="w-posts">
    <?php while ( $post_query->have_posts() ) : ?>
    	<?php $post_query->the_post(); ?>
	    <li>
            <span class="thumb">
            <?php echo gogreen_get_post_thumbnail(get_the_ID(), 'thumbnail', get_permalink());?>
            </span>
            <p>
                <a href="<?php the_permalink(); ?>"><?php  the_title(); ?></a>
	        <?php if ( $show_date ) : ?>
		        <span><?php echo get_the_date(); ?></span>
	        <?php endif; ?>
            </p>
	    </li>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    </ul>
</div>