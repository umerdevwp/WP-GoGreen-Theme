<?php

$classes = array();
$classes[] = 'footer-v2';
if(gogreen_get_option('footer_bar_full')) $classes[] = 'w-full';

?>
<div id="footer-bottom" class="<?php echo esc_attr( implode(' ', $classes) ); ?>">
    <div class="container">
        <div id="footer-nav" class="col-6">
            <?php if( gogreen_get_option('footer_menu') ): ?>
            <ul class="footer-menu">
                <?php gogreen_menu('footer', 1); ?>
            </ul>
            <?php endif; ?>
            <?php if( gogreen_get_option('footer_social') ): ?>
            <?php gogreen_social_icons(); ?>
            <?php endif; ?>
        </div>
        <div class="col-6">
            <?php if( gogreen_get_option('footer_logo') ): ?>        
            <?php gogreen_footer_logo(); ?>           
            <?php endif; ?>
            <?php if( gogreen_get_option('footer_text') ): ?>
            <div id="footer-text">
            <?php echo wp_kses_post(gogreen_get_option('footer_text_content')); ?>
            </div>
            <?php endif; ?>
        </div>      
    </div>
    <?php if( gogreen_get_option('totop_button') ): ?>
    <div id="toplink-wrapper">
        <a href="#"><i class="gg-up"></i></a>
    </div>
    <?php endif; ?>
</div>