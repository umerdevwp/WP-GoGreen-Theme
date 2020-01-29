<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>        
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="<?php echo esc_attr( gogreen_get_viewport() ); ?>" />        
        <?php 
        if ( !( function_exists( 'has_site_icon' ) && has_site_icon() ) ) {
            gogreen_custom_favicon();
        } 
        ?>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <?php gogreen_page_loader(); ?>
        <?php gogreen_nav(); ?>