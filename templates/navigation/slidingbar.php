<?php if( gogreen_get_option('slidingbar') ):?>
<div id="slidingbar" class="w-<?php echo esc_attr( gogreen_get_header_style() ); ?>">
    <a href="#" class="sliding-remove-button"><i class="gg-cancel"></i></a>
    <div class="slidingbar-wrapper">
        <?php if ( is_active_sidebar('slidingbar') ) : ?>
        <div class="sliding-widgets">
            <?php dynamic_sidebar('slidingbar'); ?>
        </div>
        <?php endif; ?>
        <?php 
        if( gogreen_get_option('menu_contact') ) {
        	gogreen_contact_info(); 
        }
        if( gogreen_get_option('menu_social_icon') ) {
        	gogreen_social_icons(); 
        }
        ?>
    </div>
</div>
<?php endif; ?>