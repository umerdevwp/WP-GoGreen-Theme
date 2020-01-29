<?php get_header(); ?>
<div id="content">
<?php 

if( gogreen_get_option('onepage') && is_front_page() ){
    get_template_part('page', 'onepage');
}else{
      
    if( have_posts() ): 

        the_post();

        gogreen_page_title();    

        $page_layout = gogreen_get_page_layout();

        $sidebar_position = gogreen_get_sidebar_position();

    ?>
    <div class="<?php echo esc_attr( gogreen_get_layout_class($page_layout, $sidebar_position) ); ?>">
        <?php
        gogreen_page_background();
        if( $page_layout == 'wide' && $sidebar_position == '1' ){            
            the_content();
        }else{
        ?>
        <div class="page-content container">
            <?php 
            if( $sidebar_position == '2' ){
                gogreen_sidebar('blog', '2');
            }
            ?>
            <div class="<?php echo esc_attr( gogreen_get_main_class( $sidebar_position ) ); ?>"> 
                <div class="col-inner"> 
                    <?php the_content(); ?>
                    <?php wp_link_pages(array( 'before' => '<div class="page-links">', 'after' => '</div>', 'link_before' => '<span>', 'link_after'  => '</span>' )); ?>
                    <?php 
                    if ( gogreen_get_option('page_comments', true) && !is_front_page() && ( comments_open() || get_comments_number() ) && !is_woocommerce() ) {
                        comments_template();
                    } 
                    ?>
                </div>
            </div>
            <?php 
            if( $sidebar_position == '3' ){
                gogreen_sidebar('blog', '3');
            }
            ?>
        </div>
        <?php } ?>
    </div>
    <?php 
    endif;
    }
    ?>
</div>
<?php get_footer(); ?>