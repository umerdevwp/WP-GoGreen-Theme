<?php
    
if( ! defined( 'ABSPATH' ) ) {
    die;
}

if( ! class_exists( 'Gogreen_Woocommerce_Template' ) ) {

    class Gogreen_Woocommerce_Template {

        function __construct() {
                       
            // Breadcrumb
            add_filter( 'woocommerce_show_page_title', array( $this, 'shop_title'), 10 );
            add_filter( 'woocommerce_breadcrumb_home_url', array( $this, 'shop_page_url') );
            
            // Page Container
            remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
            add_action( 'woocommerce_before_main_content', array( $this, 'shop_breadcrumb'), 20 );

            add_action( 'woocommerce_before_cart', array( $this, 'shop_breadcrumb'), 1 );
            add_action( 'woocommerce_before_checkout_form', array( $this, 'shop_breadcrumb'), 1 );
            
            remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
            remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
            add_action( 'woocommerce_before_main_content', array( $this, 'before_container' ), 10 );
            add_action( 'woocommerce_after_main_content', array( $this, 'after_container' ), 10 );

            remove_action( 'woocommerce_sidebar' , 'woocommerce_get_sidebar', 10 );
            add_action( 'woocommerce_sidebar', array($this, 'add_sidebar'), 10);

            add_filter( 'post_class', array($this, 'get_product_class'), 100 );
            add_filter( 'product_cat_class', array($this, 'get_product_class'), 100 );

            // Before shop loop            
            remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
            remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
            remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

            add_action( 'woocommerce_before_shop_loop_item', array( $this, 'before_shop_loop_item' ), 0 );
            add_action( 'woocommerce_before_shop_loop_item', array( $this, 'product_thumbnail_wrapper_start' ), 0 );
            add_action( 'woocommerce_before_shop_loop_item', array( $this, 'loop_product_thumbnails' ), 0 );             
            add_action( 'woocommerce_before_shop_loop_item', array( $this, 'product_stock_status'), 10 );
            add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 50 ); 
            add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_rating', 50 ); 

            add_action( 'woocommerce_before_shop_loop_item', array( $this, 'product_thumbnail_wrapper_end' ), 9999 );

            add_action( 'woocommerce_before_shop_loop_item_title', array($this, 'product_title_wrapper_start'), 9999 );
            
           
            // After shop loop
            remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );            
            add_action( 'woocommerce_after_shop_loop_item_title', array($this, 'product_title_wrapper_end'), 9999 );
            add_action( 'woocommerce_after_shop_loop_item', array($this, 'after_shop_loop_item'), 9999 );
           
            
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
            add_action( 'woocommerce_after_single_product_summary', array($this, 'upsell_display'), 15 );

            remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
            
            add_filter( 'loop_shop_per_page', array($this, 'loop_shop_per_page'), 20 );

            add_filter( 'loop_shop_columns', array($this, 'loop_shop_columns') );

            add_filter( 'woocommerce_output_related_products_args', array($this, 'output_related_products_args') );

            add_filter( 'woocommerce_thankyou_order_received_text', array($this, 'order_received_text') );

            remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

            add_action( 'woocommerce_product_thumbnails', array($this, 'product_thumbnails_before'), 0 );

            add_action( 'woocommerce_product_thumbnails', array($this, 'product_thumbnails_before'), 100 );

            add_filter( 'woocommerce_product_description_heading', array($this, 'product_description_heading'), 9999 );

            remove_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating', 10 );
            add_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating', 10 );

        }        

        public function product_stock_status(){
            global $product;
            echo '<div class="w-product-status">';
            woocommerce_show_product_loop_sale_flash();
            if ( !$product->is_in_stock() ) {
                echo '<div class="w-outofstock"><span>' . esc_html__( 'Out of stock', 'gogreen' ) . '</span></div>';
            } 
            echo '</div>';
        }

        // Change number or products per page
        public function loop_shop_per_page(){
            return intval( gogreen_get_option('shop_product_items') );
        }

        // Change number or products per row
        public function loop_shop_columns() {
            return intval( gogreen_get_option('shop_product_columns') );
        }
        
        // Related Products
        public function output_related_products_args( $args ) {
            $args['posts_per_page'] = intval( gogreen_get_option('related_product_items') ); 
            $args['columns'] =  intval( gogreen_get_option('related_product_columns') ); 
            return $args;
        }  

        function shop_title() {
            return false;
        }

        function shop_page_url(){
            $shop_id = wc_get_page_id( 'shop' );
            if( $shop_id == -1 ){
                if( get_option('show_on_front')  == 'page' ){
                    $shop_id = get_option('page_on_front');
                }
            } 
            return get_permalink( $shop_id );
        }

        function shop_breadcrumb( $args = array() ){
            if(is_shop() && !is_product_category()) return;

            $args = wp_parse_args( $args, apply_filters( 'woocommerce_breadcrumb_defaults', array(
                'delimiter'   => ' / ',
                'wrap_before' => '<nav class="woocommerce-breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>',
                'wrap_after'  => '</nav>',
                'before'      => '',
                'after'       => '',
                'home'        => esc_html__( 'Shop', 'gogreen' )
            ) ) );

            $breadcrumbs = new WC_Breadcrumb();

            if ( $args['home'] && (is_product_category() || is_single() || is_cart() || is_checkout() || is_account_page() )) {
                $breadcrumbs->add_crumb( $args['home'], apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) );
            }

            $args['breadcrumb'] = $breadcrumbs->generate();

            wc_get_template( 'global/breadcrumb.php', $args );
        }
    
        function before_container() {
            ?>
            <div id="content">
                <?php 
                gogreen_page_title(); 
                $page_layout = gogreen_get_page_layout();
                $sidebar_position = gogreen_get_sidebar_position();
                ?>
                <div class="<?php echo esc_attr( gogreen_get_layout_class($page_layout, $sidebar_position) ); ?>">
                    <?php gogreen_page_background(); ?>
                    <div class="page-content container">
                        <?php 
                        if( $sidebar_position == '2' ){
                            gogreen_sidebar('shop', '2');
                        }
                        ?>
                        <div class="<?php echo esc_attr( gogreen_get_main_class($sidebar_position) ); ?>">
                            <div class="col-inner">
                    <?php                                             
        }

        function after_container() {             
            echo '</div></div>';    
        }

        function add_sidebar(){
            if( gogreen_get_sidebar_position() == '3' ){
                gogreen_sidebar('shop', '3');
            }
            echo '</div></div></div>';            
        }

        function get_product_class( $classes ) {     

            global $woocommerce_loop;


            if( is_single() && !( isset( $woocommerce_loop['name'] ) && !empty($woocommerce_loop['name']) ) ){
                return $classes;
            }

            if( get_post_type( get_the_ID() ) == 'product' && $woocommerce_loop && isset( $woocommerce_loop['columns'] ) ){                

                $columns = intval( $woocommerce_loop['columns'] );

                // Extra post classes
                $classes[] = 'w-item';
                $classes[] = gogreen_get_column_name($columns);
                
            }
     
            return $classes;
        }

        function before_shop_loop_item(){
            echo '<figure>';
        }

        function product_thumbnail_wrapper_start(){
            echo '<div class="image-wrapper">';
        }

        function product_thumbnails_before(){
            echo '<div class="product-thumbnails">';
        }

        function product_thumbnails_after(){
            echo '</div>';
        }

        function loop_product_thumbnails(){
            $this->product_thumbnails();
        }

        function product_thumbnails( $size = 'shop_catalog' ) {
            global $product;

            $attrs = array();
            $attrs['href'] = get_permalink();

            $attachment_ids = $product->get_gallery_image_ids();
            if( is_array($attachment_ids) && count($attachment_ids) > 0 ){
                $attrs['class'] = 'w-fadeslider';
            }
            ?>
            <div class="cover-image">   
                <a<?php echo gogreen_get_attributes( $attrs );?>>
                <?php 
                    if ( has_post_thumbnail() ) {
                        echo get_the_post_thumbnail( get_the_ID(), $size );
                    } elseif ( wc_placeholder_img_src() ) {
                        echo wc_placeholder_img( $size );
                    }
                ?>
                <?php                
                foreach ( $attachment_ids as $attachment_id ) {
                    echo wp_get_attachment_image( $attachment_id, $size );
                }
                ?>
                </a>
            </div>
            <?php
        }

        function product_thumbnail_wrapper_end(){
            echo '</div>';
        }

        function product_title_wrapper_start(){
            echo '<figcaption>';
        }

        function product_title_wrapper_end(){
            echo '</figcaption>';
        }

        function after_shop_loop_item(){
            echo '</figure>';
        }         

        function upsell_display(){
           woocommerce_upsell_display(intval( gogreen_get_option('related_product_items') ), intval( gogreen_get_option('related_product_columns') ));
        }

        function order_received_text($message){
            return '<span class="order-received-text">'.$message.'</span>';
        }

        function product_description_heading($heading){
            $heading = '';
            return $heading;
        }
    }

}

new Gogreen_Woocommerce_Template();

function gogreen_woocommerce_dropdown_menu(){
    global $woocommerce;

    $menu_content = sprintf('<li class="menu-item-cart align-right">
        <a href="%s">%s</a>
        <ul class="menu-cart">
        <li class="menu-item-mini-cart woocommerce">
            <div class="shopping-cart-content">%s</div>
            %s            
        </li>        
        %s
        </ul>
        </li>', 

        esc_url( $woocommerce->cart->get_cart_url() ), 
        gogreen_dropdown_cart_items(),
        gogreen_dropdown_cart_contents(),   
        gogreen_dropdown_cart_total(),        
        gogreen_dropdown_account_items()
    );

    return $menu_content;
}

function gogreen_dropdown_account_items(){
      
    $items = array();
    if( is_user_logged_in() ){

        $items[] = sprintf('<li class="menu-item-account"><div>
            <a href="%s" class="menu-item-my-account">%s</a>
            <a href="%s" class="menu-item-logout">%s</a>
            </div></li>',
            esc_url( wc_get_page_permalink( 'myaccount' ) ),
            esc_html__('Account', 'gogreen'),
            esc_url( wc_logout_url() ),
            esc_html__('Sign out', 'gogreen')
        );
            

    }else{
        $items[] = sprintf('<li class="menu-item-login"><a href="%s">%s</a></li>',
            esc_url( wc_get_page_permalink( 'myaccount' ) ),
            esc_html__('Sign in', 'gogreen')
        );
    }
    
    $items = apply_filters('gogreen_dropdown_account_items', $items);

    $output = implode('', $items);

    return $output;
}

function gogreen_dropdown_cart_items(){
    global $woocommerce;
    return sprintf('<span class="cart-items%s">%s</span>',
        ($woocommerce->cart->cart_contents_count > 0 )? '':' empty',
        number_format($woocommerce->cart->cart_contents_count, 0, '.', ',')
        );
}

function gogreen_dropdown_cart_items_fragment( $fragments ) {
    $fragments['.cart-items'] = gogreen_dropdown_cart_items();
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'gogreen_dropdown_cart_items_fragment');

function gogreen_dropdown_cart_contents(){

    ob_start();
    ?>

    <ul class="mini-cart-list">

    <?php if ( ! WC()->cart->is_empty() ) : ?>

        <?php
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

                    $product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
                    $thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                    $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                    ?>
                    <li>
                        <?php
                        echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                            '<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                            esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
                            esc_html__( 'Remove this item', 'gogreen' ),
                            esc_attr( $product_id ),
                            esc_attr( $_product->get_sku() )
                        ), $cart_item_key );
                        ?>
                        <?php if ( ! $_product->is_visible() ) : ?>
                            <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . '<span>'. $product_name .'</span>'; ?>
                        <?php else : ?>
                            <a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>" class="product-thumb">
                                <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . '<span>'. $product_name .'</span>'; ?>
                            </a>
                        <?php endif; ?>
                        <?php echo WC()->cart->get_item_data( $cart_item ); ?>

                        <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
                    </li>
                    <?php
                }
            }
        ?>    
    <?php else : ?>

        <li class="empty"><?php echo esc_html__( 'Your cart is empty.', 'gogreen' ); ?></li>

    <?php endif; ?>
    </ul>    
    <?php

    $mini_cart = ob_get_clean();
    
    return $mini_cart;
}

function gogreen_dropdown_cart_contents_fragment( $fragments ) {
    $fragments['.mini-cart-list'] = gogreen_dropdown_cart_contents();
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'gogreen_dropdown_cart_contents_fragment');

function gogreen_dropdown_cart_total(){
    $output = '';
    if ( ! WC()->cart->is_empty() ) : 
        $output = sprintf('<p class="subtotal"><strong>%s</strong><span>%s</span></p>
            <p class="buttons"><a href="%s" class="button wc-viewcart">%s</a><a href="%s" class="button wc-checkout">%s</a></p>', 
            esc_html__( 'Subtotal', 'gogreen' ),
            WC()->cart->get_cart_subtotal(),
            esc_url( wc_get_cart_url() ),
            esc_html__( 'View Cart', 'gogreen' ),            
            esc_url( wc_get_checkout_url() ),
            esc_html__( 'Checkout', 'gogreen' )
        );
        
    endif;
    return '<div class="cart-total">'.$output.'</div>';
}


function gogreen_dropdown_cart_total_fragment( $fragments ) {
    $fragments['.cart-total'] = gogreen_dropdown_cart_total();
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'gogreen_dropdown_cart_total_fragment');

function gogreen_woocommerce_menu(){
    global $woocommerce;
    $menu_content= sprintf('<li class="menu-item-shop"><a href="%1$s"><i class="gg-shoppingcart"></i>%2$s<span class="cart-items%3$s">%4$s</span></a></li>', 
        esc_url( $woocommerce->cart->get_cart_url() ), 
        esc_html__('My Cart', 'gogreen'), 
        $woocommerce->cart->cart_contents_count > 0 ? '':' empty', 
        $woocommerce->cart->cart_contents_count 
    );
    return $menu_content;
}

function gogreen_add_to_cart_fragment( $fragments ) {
    $fragments['.menu-item-shop'] = gogreen_woocommerce_menu();
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'gogreen_add_to_cart_fragment');