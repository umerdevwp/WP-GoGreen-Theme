<?php
	
	if ( !class_exists( 'WooCommerce' ) ) {  
		return;
	}

	global $woocommerce_loop;

 	$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

    extract( $atts );

 	if( is_front_page() || is_home() ) {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
	} else {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	}

	if( isset( $_GET['orderby'] ) && $_GET['orderby'] != '' ){
		$orderby = wc_clean( $_GET['orderby'] );
	}

	$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
	$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
		'' 	=> esc_html__( 'Default sorting', 'woocommerce' ),
		'popularity' 	=> esc_html__( 'Sort by popularity', 'woocommerce' ),
		'rating'     	=> esc_html__( 'Sort by average rating', 'woocommerce' ),
		'date'       	=> esc_html__( 'Sort by newness', 'woocommerce' ),
		'price'      	=> esc_html__( 'Sort by price: low to high', 'woocommerce' ),
		'price-desc' 	=> esc_html__( 'Sort by price: high to low', 'woocommerce' )
	) );

	if ( ! $show_default_orderby ) {
		unset( $catalog_orderby_options['menu_order'] );
	}

	if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
		unset( $catalog_orderby_options['rating'] );
	}
            
	$query_args = array(
		'post_type'           	=> 'product',
		'post_status'         	=> 'publish',
		'ignore_sticky_posts' 	=> 1,
		'paged'					=> intval( $paged ),
		'orderby'             	=> $orderby,
		'order'               	=> $order,
		'posts_per_page'      	=> $per_page,
		'meta_query'          	=> WC()->query->get_meta_query()
	);


	$products                    = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $query_args, $atts ) );
	$columns                     = absint( $columns );
	$woocommerce_loop['columns'] = $columns;


    $attrs = array();

    $classes = array();

    $classes[] = 'woocommerce';   

 	$classes[] = 'columns-'. $columns;

 	if($pagination == '2'){
        $classes[] = 'w-scrollmore';
    }


	$attrs['class'] = implode(' ', $classes);

?>
<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

	<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

<?php endif; ?>

<?php
	/**
	 * woocommerce_archive_description hook
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
?>
<?php
if ( $products->have_posts() ) : ?>

	<p class="woocommerce-result-count">
		<?php
		$total    = $products->found_posts;
		$first    = ( $per_page * $paged ) - $per_page + 1;
		$last     = min( $total, $products->get( 'posts_per_page' ) * $paged );

		if ( 1 == $total ) {
			_e( 'Showing the single result', 'woocommerce' );
		} elseif ( $total <= $per_page || -1 == $per_page ) {
			printf( esc_html__( 'Showing all %d results', 'woocommerce' ), $total );
		} else {
			printf( _x( 'Showing %1$d&ndash;%2$d of %3$d results', '%1$d = first, %2$d = last, %3$d = total', 'woocommerce' ), $first, $last, $total );
		}
		?>
	</p>

	<?php
		wc_get_template( 'loop/orderby.php', array( 'catalog_orderby_options' => $catalog_orderby_options, 'orderby' => $orderby, 'show_default_orderby' => $show_default_orderby ) );
	?>

	<?php do_action( 'woocommerce_before_shop_loop' ); ?>

	<div<?php echo gogreen_get_attributes( $attrs );?>>			

		<?php woocommerce_product_loop_start(); ?>

			<?php woocommerce_product_subcategories(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>
		<?php
		woocommerce_reset_loop();
		wp_reset_postdata();

	    if( $pagination != 'hide' ){
	        gogreen_pagination($pagination, $products->max_num_pages); 
	    }
	    ?>			

	</div>
	<?php do_action( 'woocommerce_after_shop_loop' ); ?>

<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
	<?php wc_get_template( 'loop/no-products-found.php' ); ?>
<?php endif; ?>