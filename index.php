<?php get_header(); ?>
<div id="content">
    <?php gogreen_page_title(); ?>
    <div class="<?php echo esc_attr( gogreen_get_layout_class( gogreen_get_option('blog_page_layout'), gogreen_get_option('blog_sidebar') ) ); ?>">
        <?php gogreen_page_background(); ?>
        <div class="page-content container">
            <?php 
            if( gogreen_get_option('blog_sidebar') == '2' ){
                gogreen_sidebar('blog', '2', gogreen_get_option('blog_sidebar_style') );
            }
            ?>
            <div class="<?php echo esc_attr( gogreen_get_main_class( gogreen_get_option('blog_sidebar') ) ); ?>">  
                <div class="col-inner">
                    <?php gogreen_blog_archive(); ?>
                </div>
            </div>
            <?php 
            if( gogreen_get_option('blog_sidebar') == '3'){
                gogreen_sidebar('blog', '3', gogreen_get_option('blog_sidebar_style') );
            }
            ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>