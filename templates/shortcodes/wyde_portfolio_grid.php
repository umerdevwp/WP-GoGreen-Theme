<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $classes = array();    
        
    $current_page = 1;       
    if( is_front_page() || is_home() ) {
        $current_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
    } else {
        $current_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    }

          
    if ( $count != '' && ! is_numeric( $count ) ) $count = 12;
        

    list( $query_args, $loop ) = vc_build_loop_query( $posts_query );

    $query_args['post_type'] = 'wyde_portfolio';
    $query_args['paged'] = intval( $current_page );
    $query_args['has_password'] = false;
    $query_args['posts_per_page'] = intval( $count );

    $post_query = new WP_Query( $query_args );
    $item_index = (intval($current_page)-1 ) * intval( $count );
     
    $masonry_layout = array();
    $layout_count = 0;
    $col_name = '';
    $classes[] = 'w-portfolio-grid';
    switch( $view ){        
        case 'grid':
        case 'grid-space':
            $columns = intval( $columns );
            $classes[] = 'w-'. $view;
            $classes[] = 'grid-'. $columns .'-cols';
            $col_name = gogreen_get_column_name($columns);
        break; 
        default:
            $classes[] = 'w-masonry w-'.$view;    
            if( $view == 'photoset' ){
                $columns = intval( $columns );
                $classes[] = 'grid-'. $columns .'-cols';
            }
            $masonry_layout = $this->get_masonry_layout( $view ); 
            $layout_count = count( $masonry_layout );   
        break;
    }

    if( $pagination !== 'hide' ){
        $classes[] = 'w-scrollmore';
    }else{
        $classes[] = 'w-hide-more';
    }

    if($hide_filter != 'true'){
        $classes[] = 'w-filterable';
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

    if( $pagination == '2' ){
        $attrs['data-trigger'] = "0";
    }

    $hover_effect_class = '';
    if( $view != 'photoset' && !empty($hover_effect) ) $hover_effect_class = ' w-effect-'. $hover_effect;
    
    
?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <?php if( $hide_filter != 'true' ): ?>
    <ul class="w-filter clear">
        <li class="active"><a href="#all" title=""><?php echo esc_html__('All', 'gogreen'); ?></a></li>
        <?php   
        $terms = array();
        if( isset( $query_args['tax_query'] ) && is_array( $query_args['tax_query'] ) ){
            foreach( $query_args['tax_query'] as $tax){
                if( isset( $tax['taxonomy'] ) &&  $tax['taxonomy'] == 'portfolio_category'){                   
                    $terms = $tax['terms'];
                }
            }
        }

        $filters = get_terms('portfolio_category', array('include' => $terms ) );
        if ( is_array($filters) )
        {   
            foreach ( $filters as $filter ) {
                echo sprintf('<li><a href="#c-%s" title="">%s</a></li>', esc_attr( urldecode($filter->slug) ), esc_html( $filter->name ));
            }
        }
        ?>
    </ul>
    <?php endif; ?>
    <ul class="w-view<?php echo esc_attr($hover_effect_class); ?> clear">
    <?php 
    while ( $post_query->have_posts() ) : 
            
        $post_query->the_post();

        $item_classes = array();   
        if( $view == 'masonry-1' || $view == 'masonry-2' || $view == 'photoset' ){
            $key = ($item_index % $layout_count);
            if( isset($masonry_layout[$key]) ){
                $item_masonry_class = $masonry_layout[$key];
                $item_classes[] = $item_masonry_class;                
            }     
            if($view == 'photoset'){
                $item_classes[] = $col_name;
            }   
        }else{
            $item_classes[] = 'w-item';
            if( !empty($col_name) ){
                $item_classes[] = $col_name;
            }            
        }
   
        $cate_names = array();   
      
        $categories = get_the_terms( get_the_ID(), 'portfolio_category' );
            
        if (is_array( $categories )) { 
            foreach ( $categories as $item ) 
            {
                $item_classes[] = urldecode('c-'.$item->slug);
                $cate_names[] = $item->name;
            }
        }                
        ?>
        <li class="<?php echo esc_attr( implode(' ', $item_classes) ); ?>">
            <?php gogreen_portfolio_content($view, $item_index, $item_classes); ?>
        </li>        
    <?php
    $item_index++;
    endwhile;
    wp_reset_postdata();
    ?>            
    </ul>
    <?php 
    if( $pagination != 'hide' ){ 
        gogreen_infinitescroll($post_query->max_num_pages, $current_page);
    } 
    ?>
</div>