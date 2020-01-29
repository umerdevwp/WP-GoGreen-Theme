<?php

    if( gogreen_has_title_area() ):

        $page_id = gogreen_get_current_page();

        $attrs = array();
        $classes = array();
        $background_attrs = array();
        $title_color = '';
        $title_bg_color = '';
        $title_bg_video = '';

        $title_overlay_color = '';
        $title_overlay_opacity = '';
        $title_scroll_effect = '';

        $classes[] = 'title-wrapper';

        $title_align = get_post_meta( $page_id, '_w_title_align', true );
        if( empty($title_align) ) $title_align =  gogreen_get_option('title_align');
        if( $title_align != 'none' ) $classes[] = 'text-'. $title_align;
        
        $title_size = get_post_meta( $page_id, '_w_title_size', true );
        if( empty($title_size) ) $title_size =  gogreen_get_option('title_size');
        $classes[] = 'w-size-'. $title_size;
    
        $title_color = get_post_meta( $page_id, '_w_title_color', true );
        if( empty($title_color) ) $title_color = gogreen_get_option('title_color');

        $title_bg = get_post_meta( $page_id, '_w_title_background', true );
        $title_bg_image_size = '';
        if($title_bg != ''){ //title background
            
            if($title_bg !== 'none'){               
               
                if($title_bg === 'image'){

                    $title_bg_image =   get_post_meta( $page_id, '_w_title_background_image', true ); 
                    
                    $title_bg_image_size = get_post_meta( $page_id, '_w_title_background_size', true );   

                    $title_bg_effect = get_post_meta( $page_id, '_w_title_background_effect', true );                 

                }elseif($title_bg === 'video'){

                    $title_bg_image =   get_post_meta( $page_id, '_w_title_background_image', true ); 

                    $title_bg_video =   get_post_meta( $page_id, '_w_title_background_video', true ); 

                    $title_bg_effect = get_post_meta( $page_id, '_w_title_background_effect', true );
                    
                }

                $title_bg_color = get_post_meta( $page_id, '_w_title_background_color', true );
    
                $title_overlay_color = get_post_meta( $page_id, '_w_title_overlay_color', true ); 
                $title_overlay_opacity = get_post_meta( $page_id, '_w_title_overlay_opacity', true ); 

            }

        }else{ // Use default theme options
                
            $title_bg = gogreen_get_option('title_background_mode');

            if($title_bg !== 'none'){   
                

                if($title_bg == 'image'){   

                    $title_bg_image = gogreen_get_option('title_background_image');
                    if( is_array( $title_bg_image ) && isset( $title_bg_image['background-image'] )){
                        $title_bg_image = $title_bg_image['background-image'];
                    }
                    
                    $title_bg_image_size = gogreen_get_option('title_background_image');

                    if( is_array( $title_bg_image_size ) && isset( $title_bg_image_size['background-size'] ) ){
                        $title_bg_image_size = $title_bg_image_size['background-size'];
                    }

                    $title_bg_effect = gogreen_get_option('title_background_effect');

                }else if($title_bg == 'video'){

                    $title_bg_image = gogreen_get_option('title_background_image');
                    if( is_array( $title_bg_image ) && isset( $title_bg_image['background-image'] )){
                        $title_bg_image = $title_bg_image['background-image'];
                    }
                    
                    $title_bg_video = gogreen_get_option('title_background_video');
                    if( is_array( $title_bg_video ) && isset( $title_bg_video['url'] )){
                        $title_bg_video = $title_bg_video['url'];
                    } 

                    $title_bg_effect = gogreen_get_option('title_background_effect');

                }

                $title_bg_color = gogreen_get_option('title_background_color');
                
                $title_overlay_color = gogreen_get_option('title_overlay_color'); 
                $title_overlay_opacity = gogreen_get_option('title_overlay_opacity'); 
            }

        }
      
    
        if( !empty($title_bg_effect) && $title_bg_effect !== 'none' ){           
            $classes[] = 'w-'. $title_bg_effect;
        }  

        $attrs['class'] = implode(' ', $classes);

        $styles = array();

        if( !empty($title_color) ){
            $styles[] = 'color:'. $title_color;
        }

        if( !empty($title_bg_color) ){
            $styles[] = 'background-color:'. $title_bg_color;
        }

        $attrs['style'] = implode(';', $styles);  


        $title_scroll_effect = get_post_meta( $page_id, '_w_title_scroll_effect', true );
        if( $title_scroll_effect == '') $title_scroll_effect = gogreen_get_option('title_scroll_effect');
    
        if( $title_scroll_effect !== 'none' ){           
            $attrs['data-effect'] = $title_scroll_effect;
        }        

        $background_attrs['class'] = 'bg-image';
        if( !empty($title_bg_image) ){
            if( !empty($title_bg_image_size) ) $background_attrs['class'] .= ' w-bg-size-'. $title_bg_image_size;
            $background_attrs['style'] = 'background-image: url('. esc_url( $title_bg_image ). ');';
        }

        if( !empty($title_bg_image_size) ){
            $title_bg_image_size = ' ' . $title_bg_image_size;
        }        

        $container_class = gogreen_get_option('header_fullwidth') ? ' w-full' : '';
?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <?php if( !empty($title_bg_image) || !empty($title_bg_video) ): ?>
    <div class="title-background">
        <div<?php echo gogreen_get_attributes( $background_attrs );?>>
            <?php if( !empty($title_bg_video) ): ?>
            <div class="bg-video">
                <video class="videobg" autoplay loop muted poster="<?php echo esc_url( $title_bg_image ); ?>">
                    <source src="<?php echo esc_url( $title_bg_video ); ?>" type="video/mp4" />
                </video>
            </div>
            <?php endif; ?>
        </div>    
        <?php if( !empty($title_overlay_color) ) : ?>
        <?php 
            $opacity = '';
            if( !empty($title_overlay_opacity) ){
                $opacity = 'opacity:'.$title_overlay_opacity.';';
            }
        ?>
        <div class="bg-overlay" style="background-color: <?php echo esc_attr( $title_overlay_color ); ?>;<?php echo esc_attr( $opacity ); ?>"></div>
        <?php endif; ?>
        <?php if( $title_bg_effect === 'gradient' ): ?>
        <div class="bg-gradient"></div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="container<?php echo esc_attr( $container_class ); ?>">
        <?php 

        $title = get_post_meta( $page_id, '_w_page_title', true );
        
        $sub_title = get_post_meta( $page_id, '_w_subtitle', true );

        if( empty($title) ){

            if( is_woocommerce() && !is_product() ) {              
                $title = esc_html( woocommerce_page_title( false ) );   
            }

        }
        
        if( is_search() ) {
            $title = esc_html__('Search', 'gogreen');
            $sub_title = esc_html__('Search Results for', 'gogreen') .' : <strong>'. get_search_query().'</strong>';
        }

        if( is_404() ) {
            $title = esc_html__('Error 404', 'gogreen');
            $sub_title = esc_html__('Page not found', 'gogreen');
        }

        if( is_archive() && !is_woocommerce() ) {
                
            if ( is_day() ) {
                $title = esc_html__( 'Daily Archives', 'gogreen' );
                $sub_title = get_the_date();
            } else if ( is_month() ) {
                $title = esc_html__( 'Monthly Archives', 'gogreen' );
                $sub_title = get_the_date('F Y');
            } elseif ( is_year() ) {
                $title = esc_html__( 'Yearly Archives', 'gogreen' );
                $sub_title = get_the_date('Y');
            } elseif ( is_author() ) {

                $author = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $_GET['author_name'] ) : get_user_by(  'id', get_the_author_meta('ID') );                

                $title = $author->display_name;

                $description  = get_the_author_meta('description', $author->ID);

                if( empty($description) ) {
                    $sub_title = sprintf( esc_html__( '%s has created %s entries', 'gogreen' ), $author->display_name, count_user_posts( $author->ID ) );
                }   
            } else {
                $title = single_cat_title( '', false );
                $sub_title = category_description();
            }

        }

        if( empty($title) ){
            $title = get_the_title();
        } 
        ?>
        <?php if($title_size == 'm' && !empty($sub_title) ): ?>
        <h4 class="subtitle"><?php echo wp_kses_post( $sub_title );?></h4>
        <?php endif; ?>
        <h1 class="title">
            <?php echo wp_kses_post( $title );?>
        </h1>        
        <?php if($title_size != 'm' && !empty($sub_title) ): ?>
        <h4 class="subtitle"><?php echo wp_kses_post( $sub_title );?></h4>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>