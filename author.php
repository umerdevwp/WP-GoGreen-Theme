<?php get_header(); ?>
<div id="content">
    <?php   
    gogreen_page_title();
    
    $author_id = get_the_author_meta('ID');
    $avatar = get_avatar( get_the_author_meta('email', $author_id), '100' );
    ?>
    <div class="<?php echo esc_attr( gogreen_get_layout_class( gogreen_get_option('blog_archive_page_layout'), gogreen_get_option('blog_archive_sidebar') ) ); ?>">
        <?php gogreen_page_background(); ?>
        <div class="author-avatar">
            <?php echo sprintf('<a href="%s">%s</a>', get_author_posts_url($author_id), $avatar); ?>
        </div>
        <div class="page-content container">
            <?php 
            if( gogreen_get_option('blog_archive_sidebar') == '2' ){
                gogreen_sidebar( 'blog', '2', gogreen_get_option('blog_archive_sidebar_style') );
            }
            ?>
            <div class="<?php echo esc_attr( gogreen_get_main_class( gogreen_get_option('blog_archive_sidebar') ) ); ?>">
                <div class="col-inner">               
                    <?php gogreen_blog_archive(); ?>
                </div>
            </div>
            <?php 
            if( gogreen_get_option('blog_archive_sidebar') == '3'){
                gogreen_sidebar( 'blog', '3', gogreen_get_option('blog_archive_sidebar_style') );
            }
            ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>