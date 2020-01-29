<?php get_header(); ?>
<div id="content">
    <?php gogreen_page_title(); ?>
    <div class="<?php echo esc_attr( gogreen_get_layout_class( gogreen_get_option('search_page_layout'), gogreen_get_option('search_sidebar') ) ); ?>">
        <?php gogreen_page_background(); ?>
        <div class="page-content container">
            <?php 
            if( gogreen_get_option('search_sidebar') == '2'){
                gogreen_sidebar('blog', '2', gogreen_get_option('search_sidebar_style') );
            }
            ?>
            <div class="<?php echo esc_attr( gogreen_get_main_class( gogreen_get_option('search_sidebar') ) ); ?>">   
                <div class="col-inner">    
                    <?php get_search_form(); ?>    
                    <?php
                    global $wp_query; 
                    if ( have_posts() ) {
                        
                        $classes = array();
                        $classes[] = 'search-results';
                        if( gogreen_get_option('search_pagination') == '2'){
                            $classes[] = 'w-scrollmore';
                        }                   
                    ?>
                    <div class="<?php echo esc_attr( implode(' ', $classes) ) ;?>" data-trigger="0">
                        <p class="search-query">
                            <?php echo sprintf( esc_html__('About %s results', 'gogreen'), number_format_i18n( $wp_query->found_posts ) ); ?>      
                        </p>               
                        <div class="w-view clear">
                            <?php while( have_posts() ): the_post(); ?>
                            <div id="post-<?php the_ID(); ?>" class="w-item search-item clear">
                                <div class="item-header clear">
                                    <?php if( gogreen_get_option('search_show_image') ){ ?>
                                    <?php if( has_post_thumbnail() || get_post_type() =='post' ) {?>
                                    <span class="thumb">
                                        <a href="<?php echo esc_url( get_permalink() );?>" target="_blank">
                                        <?php echo gogreen_get_post_thumbnail(get_the_ID(), 'thumbnail');?>
                                        </a>
                                    </span>
                                    <?php }else{ ?>
                                    <span class="type-icon">
                                        <a href="<?php echo esc_url( get_permalink() );?>" target="_blank">
                                        <?php echo gogreen_get_type_icon();?>
                                            </a>
                                    </span>
                                    <?php } ?>
                                    <?php } ?>
                                    <h4>
                                        <a href="<?php echo esc_url( get_permalink() );?>"><?php the_title(); ?></a>
                                    </h4>
                                    <?php gogreen_search_meta();?>
                                </div>
                                <?php if( get_post_type() != 'page' ){ ?>
                                <div class="post-summary">
                                    <?php echo gogreen_get_excerpt( gogreen_get_option('blog_excerpt_base'),  gogreen_get_option('blog_excerpt_length'), gogreen_get_option('blog_excerpt_more') ); ?>
                                </div>
                                <?php } ?>
                            </div>       
                            <?php 
                            endwhile; 
                            wp_reset_postdata(); 
                            ?>
                        </div>
                        <?php gogreen_pagination( gogreen_get_option('search_pagination'), $wp_query->max_num_pages); ?>
                    </div>
                    <?php }else{ ?>
                    <p>
                    <?php echo esc_html__('No result found.', 'gogreen');?>
                    </p>
                    <?php } ?>
                </div>
            </div>
            <?php 
            if( gogreen_get_option('search_sidebar') == '3'){
                gogreen_sidebar('blog', '3', gogreen_get_option('search_sidebar_style') );
            }
            ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>