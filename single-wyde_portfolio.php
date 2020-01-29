<?php get_header(); ?>
<div id="content">
    <?php

    if( have_posts() ) : 
    
    the_post();

    gogreen_page_title();

    $portfolio_layout_id = get_post_meta( get_the_ID(), '_w_portfolio_layout', true );
        
    $portfolio_layout = '';

    $sidebar_position = '1';

    switch( intval( $portfolio_layout_id ) ){
        case 1:
            $portfolio_layout = 'masonry';
            $sidebar_position = '1';
            break;
        case 2:
            $portfolio_layout = 'gallery';
            $sidebar_position = '1';
            break;
        case 3:
            $portfolio_layout = 'slider';
            $sidebar_position = '3';
            break;
        case 4:
            $portfolio_layout = 'grid';
            $sidebar_position = '3';
            break;
        case 5:
            $portfolio_layout = '';
            $sidebar_position = '3';
            break;       
    }   

    $classes = array();

    $classes[] = gogreen_get_layout_class('boxed', $sidebar_position);

    if( !empty($portfolio_layout) ) $classes[] = 'portfolio-'. $portfolio_layout;
    else $classes[] = 'portfolio-vertical';
    ?>
    <div class="<?php echo esc_attr( implode(' ', $classes) ); ?>">
        <?php gogreen_page_background(); ?>
        <?php
        if(post_password_required(get_the_ID())){
            the_content();
        }else{  
            get_template_part('templates/portfolio/single', $portfolio_layout);
        } 
        ?>
    </div>
    <?php endif; ?>
</div>
<?php get_footer(); ?>