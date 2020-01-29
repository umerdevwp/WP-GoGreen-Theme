<?php
       
    $attrs = array();
    
    $attrs['id'] = 'header';
    
    $classes = array();    

    $classes[] = 'w-'. gogreen_get_header_style();    

    $page_id = gogreen_get_current_page();   
    
    $header_sticky = gogreen_get_option('header_sticky', true);
    if( $header_sticky ){
        $classes[] = 'w-sticky';
    }
     
    if( gogreen_get_option('header_fullwidth') ){
        $classes[] = 'w-full';
    }
       
    if( gogreen_header_overlay() ){
        $classes[] = 'w-transparent';
    }

    $text_style = get_post_meta( $page_id, '_w_header_text_style', true );
    if( empty( $text_style ) ){
        if( gogreen_get_header_style() == 'dark' ){
            $text_style = 'light';
        }else{
            $text_style = 'dark';
        }
    }

    $classes[] = 'w-text-'.$text_style;  
    
    $attrs['class'] = implode(' ', $classes);
    
?>
<header <?php echo gogreen_get_attributes( $attrs );?>> 
    <?php if( gogreen_has_top_bar() ): ?>
    <div id="top-bar">
        <div class="container">
            <?php if( gogreen_get_option('header_top_left') !== 'none' ): ?>
            <div class="top-bar-left">
                <?php gogreen_top_bar( gogreen_get_option('header_top_left') ) ;?>
            </div>
            <?php endif; ?>
            <?php if( gogreen_get_option('header_top_right') !== 'none' ): ?>
            <div class="top-bar-right">
                <?php gogreen_top_bar( gogreen_get_option('header_top_right') ) ;?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="container">       
        <span class="mobile-nav-icon">
            <i class="menu-icon"></i>
        </span>
        <?php 
        if( gogreen_get_option('header_logo', true) ){
            gogreen_logo();
        }
        ?>
        <nav id="top-nav" class="dropdown-nav">
            <ul class="top-menu">
                <?php 
                gogreen_primary_menu();
                
                if( gogreen_get_nav_layout() != 'center' ){
                    gogreen_extra_menu();
                }
                ?>    
            </ul>
            <?php if( gogreen_get_nav_layout() == 'center' ):?>
            <ul class="ex-menu">
                <?php gogreen_extra_menu(); ?>
            </ul>
            <?php endif;?>
        </nav>        
    </div>
</header>