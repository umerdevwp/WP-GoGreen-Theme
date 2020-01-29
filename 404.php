<?php get_header(); ?>
<div id="content">
    <?php gogreen_page_title(); ?>
    <div class="<?php echo esc_attr( gogreen_get_layout_class('boxed', '1') ); ?>">    
        <?php gogreen_page_background(); ?>
        <div class="page-content container">
            <div class="<?php echo esc_attr( gogreen_get_main_class('1') ); ?>">       
                <div class="col-inner">           
                    <div class="page-error-wrapper">
                        <h5 class="page-error-code"><?php echo esc_html__('404', 'gogreen');?></h5>
                        <h4 class="page-error-title"><?php echo esc_html__('Page not found', 'gogreen'); ?></h4>
                        <h5 class="page-error-text"><?php echo esc_html__( 'It looks like nothing was found at this location. Maybe try a search?', 'gogreen' ); ?></h5>
                    </div> 
                    <?php get_search_form(); ?>
                </div>              
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>