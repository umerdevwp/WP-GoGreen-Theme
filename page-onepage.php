<div class="<?php echo esc_attr( gogreen_get_layout_class('wide', '1') ); ?>">    
    <?php       
    if ( ($locations = get_nav_menu_locations()) && $locations['primary'] ) {
        $menu = wp_get_nav_menu_object( $locations['primary'] );
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        $page_ids = array();

        foreach($menu_items as $item) {
            if($item->object == 'page' && $item->menu_item_parent == 0 && !(strpos($item->url, '#') === 0))
                $page_ids[] = $item->object_id;
        }

        $page_posts = new WP_Query( array( 'post_type' => 'page','post__in' => $page_ids, 'posts_per_page' => count($page_ids), 'orderby' => 'post__in' ) );

        while ( $page_posts->have_posts() ) : 

                $page_posts->the_post();
    ?>  
    <div id="<?php echo esc_attr( $post->post_name );?>" class="page-wrapper">
        <?php 
        $post_custom_css = get_post_meta( get_the_ID(), '_wpb_post_custom_css', true );
        if ( ! empty( $post_custom_css ) ) {
            echo '<style type="text/css" data-type="vc_custom-css" scoped>'.$post_custom_css.'</style>';
        }

        $shortcodes_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
        if ( ! empty( $shortcodes_custom_css ) ) {
            echo '<style type="text/css" data-type="vc_shortcodes-custom-css" scoped>'.$shortcodes_custom_css.'</style>';
        }

        ?>
        <?php the_content(); ?>    
    </div>
    <?php
        endwhile;
        wp_reset_postdata();    
    }
    ?>      
</div>