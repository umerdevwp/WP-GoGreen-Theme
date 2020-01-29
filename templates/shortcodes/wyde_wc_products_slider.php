<?php

    if ( !class_exists( 'WooCommerce' ) ) {  
        return;
    }

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    
    $attrs = array();
    
    $classes = array();
    
    $classes[] = 'w-products-slider';
    
    $slider_attrs = array();

    $columns = intval( $visible_items );
          
    $classes[] = 'grid-'.$columns.'-cols';
    $slider_attrs['class'] = 'owl-carousel products';        
    $slider_attrs['data-items'] = $columns;
    $slider_attrs['data-navigation'] = ($show_navigation == 'true' ? 'true':'false');
    $slider_attrs['data-pagination'] = ($show_pagination == 'true' ? 'true':'false');
    $slider_attrs['data-loop'] = ($slide_loop == 'true' ? 'true':'false');
    if( $columns === 1 && !empty($transition) ) $slider_attrs['data-transition'] = $transition;

            
    if( $auto_play == 'true' ){
        $slider_attrs['data-auto-play'] = 'true';
        $slider_attrs['data-speed'] = $speed;
    }else{
        $slider_attrs['data-auto-play'] = 'false';
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


    if ( $count != '' && ! is_numeric( $count ) ) $count = - 1;   

    list( $query_args, $loop ) = vc_build_loop_query( $posts_query );

    $query_args['post_type'] = 'product';
    $query_args['post_status'] = 'publish';
    $query_args['ignore_sticky_posts'] = 1;
    $query_args['posts_per_page'] = intval( $count );
    $query_args['meta_query'] = WC()->query->get_meta_query();


    global $woocommerce_loop;

    $products                    = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $query_args, $atts, '' ) );
    $woocommerce_loop['columns'] = 1;
    $woocommerce_loop['name'] = '';

?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <div<?php echo gogreen_get_attributes( $slider_attrs ); ?>>

        <?php while ( $products->have_posts() ) : $products->the_post(); ?>

            <?php

            global $product;

            // Ensure visibility
            if ( empty( $product ) || ! $product->is_visible() ) {
                return;
            }
            ?>
            <div <?php post_class(); ?>>
                <?php
                /**
                 * woocommerce_before_shop_loop_item hook.
                 *
                 * @hooked woocommerce_template_loop_product_link_open - 10
                 */
                do_action( 'woocommerce_before_shop_loop_item' );

                /**
                 * woocommerce_before_shop_loop_item_title hook.
                 *
                 * @hooked woocommerce_show_product_loop_sale_flash - 10
                 * @hooked woocommerce_template_loop_product_thumbnail - 10
                 */
                do_action( 'woocommerce_before_shop_loop_item_title' );

                /**
                 * woocommerce_shop_loop_item_title hook.
                 *
                 * @hooked woocommerce_template_loop_product_title - 10
                 */
                do_action( 'woocommerce_shop_loop_item_title' );

                /**
                 * woocommerce_after_shop_loop_item_title hook.
                 *
                 * @hooked woocommerce_template_loop_rating - 5
                 * @hooked woocommerce_template_loop_price - 10
                 */
                do_action( 'woocommerce_after_shop_loop_item_title' );

                /**
                 * woocommerce_after_shop_loop_item hook.
                 *
                 * @hooked woocommerce_template_loop_product_link_close - 5
                 * @hooked woocommerce_template_loop_add_to_cart - 10
                 */
                do_action( 'woocommerce_after_shop_loop_item' );
                ?>
            </div>

        <?php endwhile; // end of the loop. ?>

        <?php
        woocommerce_reset_loop();
        wp_reset_postdata();
        ?>

    </div>
</div>