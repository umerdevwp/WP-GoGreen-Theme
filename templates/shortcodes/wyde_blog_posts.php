<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );

    extract( $atts );
            
    $attrs = array();

    $classes = array();

    $classes[] = 'w-blog-posts';

    $col_name = '';
    switch( $view ){
        case 'masonry':
            $columns = intval( $columns );
            $blog_layout = 'masonry';
            $classes[] = 'w-masonry';
            $classes[] = 'grid-'. $columns .'-cols';
            $col_name = gogreen_get_column_name($columns);
            break;
        case 'list':
            $blog_layout = 'list';
            $classes[] = 'w-list';
            break;            
        default:
            $blog_layout = '';
            $classes[] = 'w-large';
            break;
    }

    if($pagination == '2'){
        $classes[] = 'w-scrollmore';
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


    $current_page = 1;
    if( is_front_page() || is_home() ) {
        $current_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
    } else {
        $current_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    }

    $query_args = array();

    list( $query_args, $loop ) = vc_build_loop_query( $posts_query );

    $query_args['paged'] = intval( $current_page );
    $query_args['has_password'] = false;
    $query_args['posts_per_page'] = intval( $count );

    $post_query = new WP_Query( $query_args );
      
    $item_index = (intval($current_page) -1 ) * intval( $count );

?>      
<div<?php echo gogreen_get_attributes($attrs);?>>
    <ul class="w-view clear">
    <?php 
    while ( $post_query->have_posts() ) : 
        $post_query->the_post();
        
        $item_classes = array();           
        $item_classes[] = 'w-item';      
        $item_classes[] = 'item-'.$item_index;        
        if( !empty($col_name) ){
            $item_classes[] = $col_name;
        }                      
    ?>
        <li class="<?php echo esc_attr( implode(' ', $item_classes) ); ?>">
        <?php gogreen_post_content( $view, $item_index, 1, $excerpt_base, $excerpt_length, $excerpt_more ); ?>    
        </li>
    <?php 
    $item_index++;
    endwhile; 
    wp_reset_postdata(); 
    ?>
    </ul>
    <?php 
    if( $pagination != 'hide' ){
        gogreen_pagination($pagination, $post_query->max_num_pages, $current_page); 
    }
    ?>
</div>