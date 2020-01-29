<?php

    $attrs = array();
    $attrs['id'] = 'side-nav';

    $menu_text_style = gogreen_get_option('side_nav_text_style');
    if( !empty($menu_text_style) ){
        $attrs['class'] = 'w-text-'.$menu_text_style;
    }
?>
<aside<?php echo gogreen_get_attributes( $attrs );?>>
    <?php 
    if( gogreen_get_option('side_nav_overlay_color') ):
        $opacity = '';
        if( gogreen_get_option('side_nav_overlay_opacity') ){
            $opacity = 'opacity:'. gogreen_get_option('side_nav_overlay_opacity') .';';
        }
    ?>
    <div class="bg-overlay" style="background-color: <?php echo esc_attr( gogreen_get_option('side_nav_overlay_color') ); ?>;<?php echo esc_attr( $opacity ); ?>"></div>
    <?php endif; ?>
    <div class="side-nav-wrapper">          
        <nav id="vertical-nav">
            <ul class="vertical-menu">
            <?php gogreen_vertical_menu(); ?>
            </ul>
        </nav>
        <ul id="side-menu">
            <?php if( gogreen_get_option('menu_shop_cart') && function_exists('gogreen_woocommerce_menu') ){ ?>
            <?php echo gogreen_woocommerce_menu();   ?>
            <?php } ?>
            <?php if( gogreen_get_option('menu_search_icon') ){ ?>
            <li class="menu-item-search">
                <a class="live-search-button" href="#"><i class="gg-search"></i><?php echo esc_html__('Search', 'gogreen');?></a>
            </li>
            <?php } ?>
        </ul>
        <?php 
        if( gogreen_get_option('menu_contact') ) {
            gogreen_contact_info(); 
        }
        if( gogreen_get_option('menu_social_icon') ) {
            gogreen_social_icons(); 
        }
        ?>
    </div>
</aside>