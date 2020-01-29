<?php
/*****************************************
*   THEME FUNCTIONS
/*****************************************/
/* Get theme option value */
function gogreen_get_option( $option = '', $default = '' ){
    global $gogreen_options;
    
    if( !empty($option) && isset( $gogreen_options[$option] ) ) 
        return $gogreen_options[$option];
    else
        return $default;

}

/* Apply attributes to HTML tags */
function gogreen_get_attributes( $attributes = array() ) {

    $attrs = array();
    foreach ( $attributes as $name => $value ) {
        if( !empty($name) ){
            $attrs[] = !empty( $value ) ? sprintf( '%s="%s"', esc_html( $name ), esc_attr( $value ) ) : esc_html( "{$name}" );
        }
    }
    
    $output = '';
    if( count($attrs) ){
        $output = ' '.implode(' ', $attrs);
    } 

    return $output;

}

/* Remove shortcodes from content */
function gogreen_remove_shortcode( $m ) {

    if ( $m[2] == 'vc_row' ) {        
        return  preg_replace("/\[[^\]]*\]/", '', $m[5]);
    }

    return $m[1] . $m[6];
}

/* Get column class name from the number of columns */
function gogreen_get_column_name( $columns = 1 ){
    $col_name = '';
    if( intval($columns) == 5 ){
        $col_name = 'five-cols';
    }else{
        $col_name = 'col-'.  absint( floor( 12 / intval( $columns ) ) ); 
    }
    return $col_name;
}

/* Convert column width to column CSS class name */
function gogreen_get_column_class( $width, $offset = '' ){
    
    $classes = array();

    $classes[] = gogreen_get_column_name_from_width($width);

    if( $offset ){
        $offset_class = gogreen_get_column_offset($offset);
        if( !empty($offset_class) ){
            $classes[] = $offset_class;
        }
    }  

    return implode(' ', $classes);
}

/* Get column name */
function gogreen_get_column_name_from_width( $width, $prefix = '' ){
    $col_name = '';
    if ( preg_match( '/^(\d{1,2})\/12$/', $width, $match ) ) {
        $col_name = 'col-'. $prefix . $match[1];
    } else {
        $col_name = 'col-'. $prefix;
        switch ( $width ) {
            case "1/6" :
                $col_name .= '2';
                break;
            case "1/4" :
                $col_name .= '3';
                break;
            case "1/3" :
                $col_name .= '4';
                break;
            case "1/2" :
                $col_name .= '6';
                break;
            case "2/3" :
                $col_name .= '8';
                break;
            case "3/4" :
                $col_name .= '9';
                break;
            case "5/6" :
                $col_name .= '10';
                break;
            case "1/1" :
                $col_name .= '12';
                break;
            case "1/5" :
                $col_name = 'five-cols';
                break;
            default :
                $col_name = 'col-'. $prefix . $width;
        }
    }

    return $col_name;
}

/* Get column offset class */
function gogreen_get_column_offset( $offset ){
    if( !empty($offset) ){
        return str_replace('vc_', '', $offset);
    }else{
        return $offset;
    }
}

/* Set theme option value */
function gogreen_set_option( $option = '', $value = '' ){
    global $gogreen_options;
    
    if( $option ) $gogreen_options[$option] = $value;

}

/* Convert string to underscore name */
function gogreen_string_to_underscore_name( $string )
{
    $string = preg_replace('/[\'"]/', '', $string);
    $string = preg_replace('/[^a-zA-Z0-9]+/', '_', $string);
    $string = trim($string, '_');
    $string = strtolower($string);
    
    return $string;
}

/* Add stylesheet inside body tag */
function gogreen_add_body_style( $handle, $src ){
    if( function_exists('wyde_add_body_style' ) ){
        wyde_add_body_style( $handle, $src );
    } 
}

/* Get current page/post id for styling the page title area and the page background */
function gogreen_get_current_page(){

    $page_id = get_the_ID(); 

    if( is_home() ){
            
        $blog_page_id = get_option('page_for_posts');
        if( $blog_page_id ){
            $page_id = $blog_page_id;
        }else{
            $page_id = '';
        }

    }elseif( class_exists('WooCommerce') && ( is_shop() || is_product_category() || is_product_tag() ) ){        
        $page_id = wc_get_page_id( 'shop' );
    }elseif( is_archive() || is_search() ){
        $page_id = '';
    }

    return $page_id;
}

/* Predefined Colors */
function gogreen_predifined_colors(){

    return apply_filters('gogreen_predifined_colors', array(
        '1' => '#3ab54a',
        '2' => '#b9a06f',
        '3' => '#ce8477',
        '4' => '#619187',
        '5' => '#3b6299',
        '6' => '#bba0ce',
        '7' => '#99c4cb',
        '8' => '#f26c69',
        '9' => '#93afd6',
        '10' => '#efa7a5',
    ) );

}

/* Get color from settings */
function gogreen_get_color_scheme(){
    if( !gogreen_get_option('custom_color') ){
        $colors = gogreen_predifined_colors();
        $selected_color = gogreen_get_option('predefined_color');
        if( isset($colors[$selected_color]) && !empty($colors[$selected_color]) ) $color_scheme = $colors[$selected_color];
        else $color_scheme = $colors[1];
    }else{
        $color_scheme = gogreen_get_option('color_scheme');
    }

    return $color_scheme;
}

/* Get current color scheme */
function gogreen_get_color(){
    return gogreen_get_color_scheme();
}

/*****************************************
*   HEADER & NAV
/*****************************************/
/* Get current navigation layout */
function gogreen_get_nav_layout(){
    return gogreen_get_option('nav_layout') ? gogreen_get_option('nav_layout') : 'classic';
}

/* Get current header background style */
function gogreen_get_header_style(){
    return gogreen_get_option('header_style') ? gogreen_get_option('header_style') : 'light';;
}

/* Get header display state */
function gogreen_has_header( $page_id = '' ){    

    $page_header = true; 

    if( empty($page_id) ) $page_id = gogreen_get_current_page();

    if( get_post_meta( $page_id, '_w_page_header', true ) == 'hide' ){
        $page_header = false;        
    }

    return $page_header;
}

/* Get header top bar display state */
function gogreen_has_top_bar( $page_id = '' ){    

    $header_top = false;
    
    if( empty($page_id) ) $page_id = gogreen_get_current_page();

    $header_top = get_post_meta( $page_id, '_w_header_top', true );

    if( empty($header_top) ){
        $header_top = gogreen_get_option('header_top');
    }else{
        $header_top = $header_top !== 'hide';
    }  

    return $header_top;
}

/* Get current title area display state */
function gogreen_has_title_area( $page_id = '' ){
    
    $title_area = false;

    if( empty($page_id) ) $page_id = gogreen_get_current_page();    

    if( is_search() ){
        
        $title_area = apply_filters('gogreen_search_title_area', false);

    }elseif( is_archive() && !( is_post_type_archive( 'product' ) || is_page( get_option('woocommerce_shop_page_id') ) ) ){        
        
        $post_type = get_post_type( get_the_ID() );
        switch ( $post_type ) {
            case 'post':
                $title_area = gogreen_get_option('blog_archive_page_title') ? true : false;
                break;
            case 'wyde_portfolio':
                $title_area = gogreen_get_option('portfolio_archive_page_title') ? true : false;
                break;
            default:
                $title_area = true;
                break;
        }    

    }else{


        if( is_page() ){
            $title_area = ( get_post_meta( $page_id, '_w_title_area', true ) != 'hide' );
        }else{
            $title_area = ( get_post_meta( $page_id, '_w_title_area', true ) == 'show' );
        }      

        if( is_single() ){

            if( get_post_meta( $page_id, '_w_post_custom_title', true ) != 'on' ){
                $title_area = false;
            }

        }
            
    }

    return $title_area;
}

/* Get current header overlay state */
function gogreen_header_overlay( $page_id = '' ){
    if( empty($page_id) ) $page_id = gogreen_get_current_page();
    return ( $page_id && get_post_meta( $page_id, '_w_header_transparent', true ) === 'true' ); 
}

/* Top logo */
function gogreen_logo(){

    $home_url = home_url();
    $home_url = apply_filters('gogreen_home_url', $home_url);
    ?>
    <span id="header-logo">  
        <a href="<?php echo esc_url( $home_url ); ?>">
            <?php
            /* Dark Logo */
            $logo = gogreen_get_option('header_logo_dark', array( 'url' => get_template_directory_uri() .'/images/logo/logo.png') );
            if( is_array($logo) && !empty($logo['url']) ):
                $logo_attrs = array();
                $logo_attrs['class'] = 'dark-logo';                
                if( !empty($logo['url']) ) $logo_attrs['src'] = $logo['url'];
                if( !empty($logo['width']) ) $logo_attrs['width'] = absint( intval( $logo['width'] ) / 2 );
                if( !empty($logo['height']) ) $logo_attrs['height'] = absint( intval( $logo['height'] ) / 2 );
                $logo_attrs['alt'] = get_bloginfo('name');                      
            ?>
            <img<?php echo gogreen_get_attributes( $logo_attrs );?> />
            <?php endif; ?>

            <?php 
            /* Dark Sticky Logo */
            $sticky =  gogreen_get_option('header_logo_dark_sticky', array( 'url' => get_template_directory_uri() .'/images/logo/logo-sticky.png') );
            if( is_array($sticky) && !empty($sticky['url']) ): 
                $logo_attrs = array();
                $logo_attrs['class'] = 'dark-sticky';                
                if( !empty($sticky['url']) ) $logo_attrs['src'] = $sticky['url'];
                if( !empty($sticky['width']) ) $logo_attrs['width'] = absint( intval( $sticky['width'] ) / 2 );
                if( !empty($sticky['height']) ) $logo_attrs['height'] = absint( intval( $sticky['height'] ) / 2 );
                $logo_attrs['alt'] = get_bloginfo('name');
            ?>
            <img<?php echo gogreen_get_attributes( $logo_attrs );?> />
            <?php endif; ?>

            <?php 
            /* Light Logo */
            $light_logo = gogreen_get_option('header_logo_light', array( 'url' => get_template_directory_uri() .'/images/logo/logo-light.png') );
            if( is_array($light_logo) && !empty($light_logo['url']) ):             
                $logo_attrs = array();
                $logo_attrs['class'] = 'light-logo';                
                if( !empty($light_logo['url']) ) $logo_attrs['src'] = $light_logo['url'];
                if( !empty($light_logo['width']) ) $logo_attrs['width'] = absint( intval( $light_logo['width'] ) / 2 );
                if( !empty($light_logo['height']) ) $logo_attrs['height'] = absint( intval( $light_logo['height'] ) / 2 );
                $logo_attrs['alt'] = get_bloginfo('name');
            ?>
            <img<?php echo gogreen_get_attributes( $logo_attrs );?> />
            <?php endif; ?>

            <?php 
            /* Light Sticky Logo */
            $light_sticky =  gogreen_get_option('header_logo_light_sticky', array( 'url' => get_template_directory_uri() .'/images/logo/logo-light-sticky.png') );
            if( is_array($light_sticky) && !empty($light_sticky['url']) ): 
                $logo_attrs = array();
                $logo_attrs['class'] = 'light-sticky';                
                if( !empty($light_sticky['url']) ) $logo_attrs['src'] = $light_sticky['url'];
                if( !empty($light_sticky['width']) ) $logo_attrs['width'] = absint( intval( $light_sticky['width'] ) / 2 );
                if( !empty($light_sticky['height']) ) $logo_attrs['height'] = absint( intval( $light_sticky['height'] ) / 2 );
                $logo_attrs['alt'] = get_bloginfo('name');
            ?>
            <img<?php echo gogreen_get_attributes( $logo_attrs );?> />
            <?php endif; ?>
        </a>
    </span>
    <?php
}

/* Primary Menu */
function gogreen_primary_menu(){
    if( gogreen_get_option('onepage') ){
        wp_nav_menu(array('theme_location' => 'primary', 'depth' => 0, 'container' => false, 'walker'=> class_exists( 'GoGreen_Walker_OnePage_Nav' ) ? new GoGreen_Walker_OnePage_Nav : null, 'items_wrap' => '%3$s', 'fallback_cb'  => false) );                
    }else{
        wp_nav_menu(array('theme_location' => 'primary', 'depth' => 0, 'container' => false, 'walker'=> class_exists( 'GoGreen_Walker_MegaMenu_Nav' ) ? new GoGreen_Walker_MegaMenu_Nav : null, 'items_wrap' => '%3$s', 'fallback_cb' => false));
    }
}

/* Vertical Menu */
function gogreen_vertical_menu(){
    if( gogreen_get_option('onepage') ){
        wp_nav_menu(array('theme_location' => 'primary', 'depth' => 0, 'container' => false, 'walker'=> class_exists( 'GoGreen_Walker_OnePage_Vertical_Nav' ) ? new GoGreen_Walker_OnePage_Vertical_Nav : null, 'items_wrap' => '%3$s', 'link_after' => '<span></span>', 'fallback_cb'  => false) );                
    }else{
        wp_nav_menu(array('theme_location' => 'primary', 'depth' => 0, 'container' => false, 'walker'=> class_exists( 'GoGreen_Walker_Vertical_Nav' ) ? new GoGreen_Walker_Vertical_Nav : null, 'items_wrap' => '%3$s', 'link_after' => '<span></span>', 'fallback_cb' => false));
    }
}

/* Fullscreen Menu */
function gogreen_fullscreen_menu(){
    add_filter( 'nav_menu_item_id', 'gogreen_get_fullscreen_menu_id', 50, 4 );
    gogreen_vertical_menu();
}

/* Top Bar Menu */
function gogreen_top_bar( $type = '' ){
    switch ( $type ) {
        case 'contact':
            gogreen_contact_info();
            break;
        case 'social':
            gogreen_social_icons();
            break;        
    }
}

/* Extra Menu */
function gogreen_extra_menu(){    
    if( gogreen_get_option('menu_shop_cart') && function_exists('gogreen_woocommerce_dropdown_menu')):
        echo gogreen_woocommerce_dropdown_menu();
    endif;
    if( gogreen_get_option('menu_search_icon')): 
    ?>
        <li class="menu-item-search">
            <a class="live-search-button" href="#"><i class="gg-search"></i></a>
        </li>
    <?php 
    endif;
    if( gogreen_get_option('slidingbar')): 
    ?>
        <li class="menu-item-slidingbar">
            <a href="#"><i class="sliding-icon"></i></a>
        </li>
    <?php 
    endif;
}

/* Get Fullscreen Menu Item ID */
function gogreen_get_fullscreen_menu_id($id, $item, $args, $depth){
    $id = 'fullscreen-menu-item-'.$item->ID;
    return $id;
}

/* Default Menu */
function gogreen_menu( $location = '', $depth = 1){
    wp_nav_menu( array('theme_location' => $location, 'depth' => $depth, 'container' => false, 'walker'=> class_exists( 'GoGreen_Walker_MegaMenu_Nav' ) ? new GoGreen_Walker_MegaMenu_Nav : null, 'items_wrap' => '%3$s', 'fallback_cb' => false) );
}

/*****************************************
*   FOOTER
/*****************************************/
/* Get footer content state */
function gogreen_show_footer_content(){

    $footer_content = get_post_meta( gogreen_get_current_page(), '_w_page_footer_content', true ) != 'hide';

    if( $footer_content ) $footer_content = gogreen_get_option('footer_content');    
 
    return $footer_content;
    
}

/* Get footer bar state */
function gogreen_show_footer_bar(){

    $page_id = gogreen_get_current_page();

    $footer_bar = get_post_meta( gogreen_get_current_page(), '_w_page_footer', true ) != 'hide';  

    if( $footer_bar ) $footer_bar = gogreen_get_option('footer_bar');     

    return $footer_bar;
}

/* Footer logo */
function gogreen_footer_logo(){

    $home_url = home_url();
    $home_url = apply_filters('gogreen_home_url', $home_url);    
    ?>
    <div id="footer-logo">
        <a href="<?php echo esc_url( $home_url ); ?>">
            <?php 
            $logo = gogreen_get_option('footer_logo_image');
            if( is_array($logo) && !empty($logo['url']) ):
                $logo_attrs = array();
                $logo_attrs['class'] = 'footer-logo';                
                if( !empty($logo['url']) ) $logo_attrs['src'] = $logo['url'];
                if( !empty($logo['width']) ) $logo_attrs['width'] = absint( intval( $logo['width'] ) / 2 );
                if( !empty($logo['height']) ) $logo_attrs['height'] = absint( intval( $logo['height'] ) / 2 );
                $logo_attrs['alt'] = get_bloginfo('name');                      
            ?>
            <img<?php echo gogreen_get_attributes( $logo_attrs );?> />
            <?php endif; ?>
        </a>
    </div>
    <?php
}

/*****************************************
*   PAGE
/*****************************************/
/* Get loader animation */
function gogreen_get_page_loader( $loader = '' ){
    $output = '';
    if( !empty($loader) && $loader !== 'none' ){
        ob_start();
        ?>
        <div id="loading-animation" class="loader-<?php echo esc_attr( gogreen_get_option('page_loader') );?>">
        <?php get_template_part('templates/loaders/loader', gogreen_get_option('page_loader')); ?>
        </div>
        <?php
        $output = ob_get_clean();
    }
    return $output;
}

/* Get current page layout */
function gogreen_get_page_layout( $page_id = '' ){    

    if( empty($page_id) ) $page_id = gogreen_get_current_page();

    $page_layout = get_post_meta( $page_id, '_w_layout', true );
    if( empty($page_layout) ){
        $page_layout = 'boxed';        
    }    

    return apply_filters('gogreen_page_layout', $page_layout);
}

/* Get current sidebar position */
function gogreen_get_sidebar_position( $page_id = '' ){
    
    $sidebar_position = '';      

    if( empty($page_id) ) $page_id = gogreen_get_current_page(); 

    if( is_single() ){

        if( get_post_type( get_the_ID() ) == 'post' ){

            if( get_post_meta( $page_id, '_w_post_custom_sidebar', true ) == 'on'){
                $sidebar_position = get_post_meta( $page_id, '_w_sidebar_position', true );
            }

            if( empty($sidebar_position) ) $sidebar_position = gogreen_get_option('blog_single_sidebar', '3');

        }elseif( get_post_type( get_the_ID() ) == 'product' ){
            $sidebar_position = gogreen_get_option('shop_single_sidebar');
        }          
        
    }else{

        $sidebar_position = get_post_meta( $page_id, '_w_sidebar_position', true );
        if( empty($sidebar_position) ) {
            $sidebar_position = '1';
        }        
        
    }    

    return $sidebar_position;
}

/* Get page layout classes */
function gogreen_get_layout_class( $page_layout = '', $sidebar_position = ''){ 

    if( empty($page_layout) ){
        $page_layout = gogreen_get_page_layout();       
    }    

    if( empty($sidebar_position) ){
        $sidebar_position = gogreen_get_sidebar_position();
    }

    $classes = array();
    $classes[] = 'main-content';
    if( $page_layout == 'wide' ){
        $classes[] = 'full-width'; 
    }
    
    switch ($sidebar_position) {
        case '2':
            $classes[] = 'left-sidebar';
            break;
        case '3':
            $classes[] = 'right-sidebar';
            break;
        default:
            $classes[] = 'no-sidebar';
            break;
    } 

    if( gogreen_has_header() && !gogreen_has_title_area() && !gogreen_header_overlay() ) $classes[] = 'header-space';

    return apply_filters('gogreen_get_layout_class', implode(' ', $classes) );
}

/* Get main content classes */
function gogreen_get_main_class( $sidebar_position = '' ){

    if( empty($sidebar_position) ){
        $sidebar_position = gogreen_get_sidebar_position();
    }

    $classes = array();
    $classes[] = 'w-main';
    if( $sidebar_position == '1' ){
        $classes[] = 'col-12';
    }else{
        $classes[] = 'col-9';
    }

    return apply_filters('gogreen_get_main_class', implode(' ', $classes) );    
}

/* Get current sidebar style */
function gogreen_get_sidebar_style( $page_id = '' ){
    if( is_single() ) return '';

    if( empty($page_id) ) $page_id = gogreen_get_current_page();   
           
    return get_post_meta( $page_id, '_w_sidebar_style', true );    
}

/* Sidebar */
function gogreen_sidebar( $name = 'blog', $sidebar_position = '', $sidebar_style = '' ){
    
    $sidebar = get_post_meta( gogreen_get_current_page(), '_w_sidebar_name', true );

    if( empty( $sidebar ) ){
        $sidebar = $name;
    }

    if( empty( $sidebar_style ) ){
        $sidebar_style = gogreen_get_sidebar_style();
    }

    $attrs = array();
    $attrs['id'] = ( $sidebar_position == '3' ? 'right' : 'left') .'-sidebar';

    $classes = array();
    $classes[] = 'w-sidebar';
    $classes[] = 'col-3';

    if( !empty( $sidebar_style ) ){
        $classes[] = 'w-'.$sidebar_style;
    }

    $attrs['class'] = implode(' ', $classes);   

    if ( is_active_sidebar( $sidebar ) ) :
    ?>
    <aside<?php echo gogreen_get_attributes( $attrs ); ?>>
        <div class="col-inner">
        <?php dynamic_sidebar( $sidebar ); ?>
        </div>
    </aside>
    <?php
    endif;
}

/* Page Title Area */
function gogreen_page_title(){
    get_template_part('page', 'title'); 
}

/* Page Background */
function gogreen_page_background(){
    get_template_part('page', 'background'); 
}

/* Get embeded media preview */
function gogreen_get_media_preview( $media_url ){

    if( strpos($media_url, 'vimeo.com') === false && strpos($media_url, 'youtube.com') === false ){

        $embed_code = '';
        $embed_code = wp_oembed_get($media_url, array(
                'width'     => '1170',
                'height'    => '658'
        ));

        if( !empty($embed_code) && preg_match('/src="([^"]+)"/', $embed_code, $match) ){
            return add_query_arg( array(
                'iframe' => 'true',
                'width' => '1170',
                'height' => '658'
            ), $match[1]); 
        }
    }

    return $media_url;

}

/*****************************************
*   BLOG
/*****************************************/
/* Set post view */
function gogreen_set_post_views($post_id) {
    $count_key = '_w_post_views';
    $count = get_post_meta($post_id, $count_key, true);
    if($count == ''){
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    }else{
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

/* Get post type icon */
function gogreen_get_type_icon($post_id=''){
    if($post_id =='') $post_id = get_the_ID();
    $thumbnail = '';
    switch(get_post_type($post_id)){
        case 'page':
            $thumbnail = '<i class="gg-book-open"></i>';
            break;
        case 'portfolio':
            $thumbnail = '<i class="gg-folder-open"></i>';
            break;
        case 'product':
            $thumbnail = '<i class="gg-cart-1"></i>';
            break;
        default:
            $thumbnail = '<i class="gg-book-open"></i>';
            break;
    }
    return $thumbnail;
}

/* Get post thumbnail */
function gogreen_get_post_thumbnail($post_id = '', $size = '', $link = ''){
    if( $post_id == '' ) $post_id = get_the_ID();
    if( $size == '' ) $size = 'thumbnail';

    $thumbnail_id = get_post_thumbnail_id($post_id);
    if( $thumbnail_id ){
        $thumbnail = wp_get_attachment_image($thumbnail_id, $size);
    }else{
        $format = get_post_format($post_id);
        $post_formats = get_theme_support( 'post-formats' );
        if( is_array($post_formats) && !in_array($format, $post_formats[0] ) ){
            $format = 'standard';
        } 
        $thumbnail = '<span class="post-thumb post-icon-'.$format.'"></span>';
    }

    if($link == ''){
        return $thumbnail;
    }else{
        return sprintf('<a href="%s" title="">%s</a>', esc_url( $link ), $thumbnail);
    }
}

/* Get post title */
function gogreen_post_title( $link = '' ){

    $title_tag = apply_filters( 'gogreen_blog_post_title_tag', is_single() ? 'h2' : 'h3' );    

    switch ( get_post_format() ) {
        case 'link':
            if( is_single() ){
                the_title( '<'.$title_tag.' class="post-title">', '</'.$title_tag.'>');
            }else{

                if(!$link){
                    $link = get_permalink();
                    the_title( '<'.$title_tag.' class="post-title"><a href="' . esc_url( $link ) . '">', '</a></'.$title_tag.'>');
                }else{
                    the_title( '<'.$title_tag.' class="post-title"><a href="' . esc_url( $link ).'" target="_blank">', '</a></'.$title_tag.'>');
                }
            }
            break;
        case 'quote':

            $quote = get_post_meta(get_the_ID(), '_w_post_quote', true );

            if( empty($quote) ) $quote = get_the_title();

            $author = get_post_meta(get_the_ID(), '_w_post_quote_author', true );

            if( !empty( $author ) ) $author = '<span class="quote-author">' . esc_html( $author ) . '</span>';

            if(is_single()){
                echo '<'.$title_tag.' class="post-title">'. esc_html( $quote ) . $author .'</'.$title_tag.'>';
            }else{
                echo '<'.$title_tag.' class="post-title"><a href="' . esc_url( get_permalink() ) .'">'. esc_html( $quote ). '</a></'.$title_tag.'>'. $author;
            }

            break;
        default:

            if(is_single()){
                the_title( '<'.$title_tag.' class="post-title">', '</'.$title_tag.'>');
            }else{
                the_title( '<'.$title_tag.' class="post-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></'.$title_tag.'>');
            }

            break;
    }
    
}

/* Get single category name */
function gogreen_get_single_category(){

    $categories = get_the_category(); 
    $category_names = array();
    if($categories){
        foreach($categories as $category) {
            $category_names[] = esc_html($category->name);
        }

        if($categories[0]){
            return '<a href="'. esc_url( get_category_link($categories[0]->term_id ) ) .'" title="'. esc_attr( implode(', ', $category_names) ) .'">'. esc_html( $categories[0]->name ) .'</a>';
        }
    }
    return '';
}

/* Get excerpt more */
function gogreen_get_excerpt_more( $excerpt_more = '' ){
    $readmore = ' [&hellip;]';

    if( $excerpt_more ){
        $readmore = apply_filters('excerpt_more', sprintf('<span class="readmore-link"><a href="%s">%s</a></span>', esc_url(get_permalink(get_the_ID())), esc_html__('Read more', 'gogreen')));
    }

    return $readmore;
}

/** Get custom excerpt **/
function gogreen_get_excerpt( $excerpt_base = '', $excerpt_length = 0, $excerpt_more = '' ) {
    
    $content = '';

    if( !$excerpt_length ){       
        $excerpt_length = apply_filters('excerpt_length', $excerpt_length);
    }

    $readmore = gogreen_get_excerpt_more($excerpt_more);
    
    $custom_excerpt = false;
     
    $blog_post = get_post(get_the_ID());

    $pos = strpos($blog_post->post_content, '<!--more-->'); 

    $raw_content = strip_tags( $blog_post->post_content ); 

    if( !$excerpt_length ){
        return $raw_content;
    }

    if( $blog_post->post_excerpt || $pos !== false ) {
        if( $pos !== false ){
            $raw_content  =  wp_strip_all_tags( rtrim( get_the_excerpt(), '[&hellip;]' ), '<p>' ) . $readmore;
        }
        $custom_excerpt = true;
    }
           
    if( $raw_content && !$custom_excerpt ) {

        $pattern = get_shortcode_regex();

        $content = preg_replace_callback("/$pattern/s", 'gogreen_remove_shortcode', $raw_content);

        $content = wp_strip_all_tags( do_shortcode($content) );  

        //$content = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $content); // strip shortcode and keep the content 

        if( $excerpt_base ) {

            $content = mb_substr($content, 0, $excerpt_length);   
            $content .= $readmore;         

        }else{

            $words = explode(' ', $content, $excerpt_length + 1);

            if( count($words) > $excerpt_length ) {
                array_pop($words);
                $content = implode(' ', $words);
                $content .= $readmore;
            } else {
                $content = implode(' ', $words);
            }  
        }     

        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);

        return $content;

    }

    if( $custom_excerpt == true ){

        $pattern = get_shortcode_regex();

        $content = preg_replace_callback("/$pattern/s", 'gogreen_remove_shortcode', $raw_content);     
        
        $content = do_shortcode($content);           

        $content = str_replace(']]>', ']]&gt;', $content);            
    }    

    if( has_excerpt() ) {        
        $content = do_shortcode( get_the_excerpt() );            
        $content = wp_strip_all_tags( $content );   
    }   
  

    return $content;
}

/* Blog post template */
function gogreen_post_content( $view = '', $item_index = 0, $blog_excerpt = 1, $blog_excerpt_base = '', $blog_excerpt_length = 0, $blog_excerpt_more = ''){    

    if( function_exists('wyde_get_template') ){
        
        wyde_get_template( 'templates/blog/content', $view, array( 
                'item_index' => $item_index, 
                'blog_excerpt' => $blog_excerpt, 
                'blog_excerpt_base' => $blog_excerpt_base, 
                'blog_excerpt_length' => $blog_excerpt_length, 
                'blog_excerpt_more' => $blog_excerpt_more
            ) 
        );

    }else{
        get_template_part('templates/blog/content');
    }    

}

/* Blog comments */
function gogreen_blog_comments(){
    get_template_part('templates/blog/comments');
}

/* Blog share icons */
function gogreen_blog_share_buttons(){
    get_template_part('templates/blog/share-buttons');
}

/* Blog navigation */
function gogreen_post_nav(){  
    get_template_part('templates/blog/nav');
}

/* Blog author box */
function gogreen_post_author(){
    get_template_part('templates/blog/author');
}

/* Blog related posts */
function gogreen_related_posts(){
    get_template_part('templates/blog/related');
}

/* Blog search meta */
function gogreen_search_meta(){
    get_template_part('templates/blog/search', 'meta');
}

/* Blog comment template */
function gogreen_comment($comment, $args, $depth) { 
    $add_below = ''; 
?>
<li <?php comment_class();?>>
    <article id="comment-<?php comment_ID() ?>" class="clear">        
        <div class="comment-box clear">
            <div class="avatar">
            <?php echo get_avatar($comment, $args['avatar_size']); ?>
            </div>
            <h4 class="name"><?php echo get_comment_author_link(); ?></h4>
            <div class="post-meta"><span class="comment-date"><?php printf('%1$s %2$s', get_comment_date(),  get_comment_time()) ?></span><?php edit_comment_link(esc_html__('Edit', 'gogreen'),'  ','') ?><?php comment_reply_link(array_merge( $args, array('reply_text' => esc_html__('Reply', 'gogreen'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>        
        </div>
        <div class="post-content">
            <?php if ($comment->comment_approved == '0') : ?>
            <em><?php echo esc_html__('Your comment is awaiting moderation.', 'gogreen') ?></em>
            <?php endif; ?>
            <?php comment_text(); ?>
        </div>
    </article>
<?php
}

/* Blog pagination */
function gogreen_pagination( $type = '', $pages = '', $current_page = '', $range = 2 ){  
    global $wp_query, $paged;
    
    if( !$type){
        $type = gogreen_get_option('blog_pagination');
    }

    if( $type == 'hide' ){
        return;
    }

    if( !$pages )
    {            
        $pages = $wp_query->max_num_pages;
        if(!$pages)
        {
            $pages = 1;
        }
    }

    if( !$current_page ){
        $current_page = $paged;
    }

    if( $current_page === 0 ) $current_page = 1;

    if($type == '1'){
        gogreen_numberic_pagination($pages, $current_page, $range);
    }elseif($type == '2'){
        gogreen_infinitescroll($pages, $current_page, $range);
    }else{      

        if($pages != 1)
        {
            echo '<div class="pagination clear">';
            echo '<span class="w-previous">';
            previous_posts_link( esc_html__('Newer Entries', 'gogreen') );
            echo '</span>';
            echo '<span class="w-next">';
            next_posts_link( esc_html__('Older Entries', 'gogreen'), $pages );
            echo '</span>';
            echo '</div>';
        }
    }
    
}

/* Blog numeric pagination */
function gogreen_numberic_pagination($pages = 1, $current_page = 1, $range = 2)
{   

    $show_items = ($range * 2)+1;  

    if($pages != 1)
    {

        echo '<div class="pagination numberic clear">';
        echo '<ul>';
        if( $current_page == 1 ){
            echo '<li class="w-first disabled"><span><i class="gg-arrow-double-left"></i></span></li>';         
            echo '<li class="w-prev disabled"><span><i class="gg-left"></i></span></li>';         
        }else{
            echo '<li class="w-first"><a href="'. get_pagenum_link(1).'"><i class="gg-arrow-double-left"></i></a></li>';
            echo '<li class="w-prev"><a href="'. get_pagenum_link($current_page - 1) .'"><i class="gg-left"></i></a></li>';
        } 

        for ($i = 1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= ($current_page + $range + 1) || $i <= ( $current_page - $range - 1) ) || $pages <= $show_items ))
            {
                echo ( $current_page == $i ) ? '<li><span class="current">'.$i.'</span></li>' : '<li><a href="'. get_pagenum_link($i).'">'.$i.'</a></li>';
            }
        }

        if( $current_page == $pages ){
            echo '<li class="w-next disabled"><span><i class="gg-right"></i></span></li>';
            echo '<li class="w-last disabled"><span><i class="gg-arrow-double-right"></i></span></li>';
        }else{
            echo '<li class="w-next"><a href="'. get_pagenum_link($current_page + 1) .'"><i class="gg-right"></i></a></li>';
            echo '<li class="w-last"><a href="'. get_pagenum_link($pages) .'"><i class="gg-arrow-double-right"></i></a></li>';
        } 

        echo '</ul>';
        echo '</div>';
    }
}

/* Blog infinite scroll pagination */
function gogreen_infinitescroll($pages = '', $current_page = 1, $range = 2) {  
     if($pages != 1 && $current_page != $pages)
     {
         echo '<div class="w-showmore clear">';
         echo '<a href="'. get_pagenum_link($current_page + 1).'" class="w-next">'. esc_html__('Show More', 'gogreen') .'</a>';
         echo '</div>';
     }
}

/* Blog archive posts */
function gogreen_blog_archive() {
    global $wp_query;

    $blog_layout = gogreen_get_option('blog_layout');  

    $columns = intval( gogreen_get_option('blog_columns') );

    $blog_excerpt = gogreen_get_option('blog_excerpt');

    $blog_excerpt_base = gogreen_get_option('blog_excerpt_base');

    $blog_excerpt_length = gogreen_get_option('blog_excerpt_length');

    $blog_excerpt_more = gogreen_get_option('blog_excerpt_more');

    $pagination = gogreen_get_option('blog_pagination');  

    if( !is_home() && is_archive() ){
        $blog_layout = gogreen_get_option('blog_archive_layout');
        $columns = intval( gogreen_get_option('blog_archive_columns') );
        $pagination = gogreen_get_option('blog_archive_pagination');  
    } 

    $attrs = array();

    $classes = array();

    $classes[] = 'w-blog-posts';

    $col_name = '';
    $view = $blog_layout;
    switch( $view ){
        case 'masonry':
            $classes[] = 'w-masonry';            
            $classes[] = 'grid-'. $columns .'-cols';
            $col_name = gogreen_get_column_name($columns);
            break;
        case 'list':
            $classes[] = 'w-list';
            break;            
        default:
            $classes[] = 'w-large';
            break;
    }

    if($pagination == '2'){
        $classes[] = 'w-scrollmore';
    }

    if( !empty($el_class) ){
        $classes[] = $el_class;
    }
        
    $attrs['class'] = implode(' ', $classes);

    $current_page = 1;
    if( is_front_page() || is_home() ) {
        $current_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
    } else {
        $current_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    }

    $count = get_option('posts_per_page');                

    $item_index = (intval($current_page) -1 ) * intval( $count );


    ?>      
    <div<?php echo gogreen_get_attributes($attrs);?>>
        <ul class="w-view clear">
        <?php 
        while ( have_posts() ) :

            the_post();
            
            $item_classes = array();           
            $item_classes[] = 'w-item';      
            $item_classes[] = 'item-'.$item_index;        
            if( !empty($col_name) ){
                $item_classes[] = $col_name;
            }                      
        ?>
            <li class="<?php echo esc_attr( implode(' ', $item_classes) ); ?>">
            <?php gogreen_post_content( $view, $item_index, $blog_excerpt, $blog_excerpt_base, $blog_excerpt_length, $blog_excerpt_more ); ?>    
            </li>
        <?php 
        $item_index++;
        endwhile; 
        wp_reset_postdata(); 
        ?>
        </ul>
        <?php 
        if( $pagination != 'hide' ){
            gogreen_pagination($pagination, $wp_query->max_num_pages, $current_page); 
        }
        ?>
    </div>
    <?php wp_link_pages(array( 'before' => '<div class="page-links">', 'after' => '</div>', 'link_before' => '<span>', 'link_after'  => '</span>' )); ?>
    <?php 
    if ( gogreen_get_option('page_comments') && !is_front_page() && ( comments_open() || get_comments_number() ) && !is_woocommerce() ) {
        comments_template();
    } 
}

/*****************************************
*   PORTFOLIO
/*****************************************/
/* Portfolio posts template */
function gogreen_portfolio_content( $view = '', $item_index = 0, $item_classes = array() ){    

    $template_file = '';

    $masonry_classes = array();

    switch ( $view ) {
        case 'masonry-1':
        case 'masonry-2':
            $view = 'masonry';
            $masonry_classes = explode(' ', $item_classes[0] );
            break;
        case 'photoset':
            $view = 'photoset';
            break;        
        default:
            $view = '';
            break;
    }
    
    if ( !empty($view) ) {
        $template_file = locate_template('templates/portfolio/content-' . $view . '.php');
    }

    if( empty($template_file) ){
        $template_file = locate_template('templates/portfolio/content.php');
    } 

    if( function_exists('wyde_get_template') ){
        
        wyde_get_template( 'templates/portfolio/content', $view, array( 
                'item_index' => $item_index, 
                'item_classes' => $item_classes, 
                'masonry_classes' => $masonry_classes               
            ) 
        );

    }else{
        get_template_part('templates/portfolio/content', $view);
    }   
}

/* Portfolio sidebar */
function gogreen_portfolio_sidebar(){
    gogreen_portfolio_widget('categories');
    gogreen_portfolio_widget('skills');
    gogreen_portfolio_widget('clients');
    gogreen_portfolio_widget('fields');
    gogreen_portfolio_widget('meta');
    gogreen_portfolio_widget('share');
}

/* Portfolio widgets */
function gogreen_portfolio_widget( $name = 'meta' ){
    get_template_part('templates/portfolio/widget', $name);
}

/* Portfolio related posts */
function gogreen_portfolio_related(){
    get_template_part('templates/portfolio/related');
}

/* Portfolio post navigation */
function gogreen_portfolio_nav(){
    get_template_part('templates/portfolio/nav');
}

/* Portfolio thumbnail */
function gogreen_get_portfolio_thumbnail($post_id='', $size='', $link=''){
    $thumbnail = '';
    if($post_id =='') $post_id = get_the_ID();
    if($size =='') $size = 'thumbnail';

    $image =  wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
    if( $image ){
        $thumbnail = sprintf('<img src="%s" alt="%s" class="post-thumb" />', esc_url($image[0]), get_the_title() );
    }else{
        $thumbnail = '<span class="post-thumb"></span>';
    }

    if($link == ''){
        return $thumbnail;
    }else{
        return sprintf('<a href="%s" title="">%s</a>', esc_url( $link ), $thumbnail);
    }
}

/* Portfolio archive posts */
function gogreen_portfolio_archive(){

    $view = gogreen_get_option('portfolio_archive_layout');
    $columns = gogreen_get_option('portfolio_archive_grid_columns');
    $pagination = gogreen_get_option('portfolio_archive_pagination');

    $term = get_queried_object();
    $term_id = '';
    if($term) $term_id = $term->term_id;

    echo do_shortcode( sprintf('[wyde_portfolio_grid view="%s" columns="%s" pagination="%s" hide_filter="true" posts_query="tax_query:%s"]', esc_attr($view), esc_attr($columns), esc_attr($pagination), esc_attr($term_id) ) );
}

/* Social icons */
function gogreen_social_icons(){

    $social_icons = gogreen_get_social_icons();

    echo '<ul class="social-icons">';     
    foreach($social_icons as $key => $value){
        $social_url = gogreen_get_option( 'social_'. gogreen_string_to_underscore_name($value) );
        if( !empty( $social_url ) ){
            echo sprintf('<li><a href="%s" target="_blank" title="%s"><i class="%s"></i></a></li>', esc_url( $social_url ), esc_attr( $value ), esc_attr( $key ));    
        }
    }
    echo '</ul>';
}

/* Contact info */
function gogreen_contact_info(){
    ?>
    <ul class="contact-info">        
        <?php gogreen_menu('contact'); ?>
    </ul>
    <?php 
}

/* Social links & icons */
function gogreen_get_social_icons(){
    
    $icons = array(
            'gg-behance'            => 'Behance',
            'gg-deviantart'         => 'DeviantArt',
            'gg-digg'               => 'Digg',
            'gg-dribbble'           => 'Dribbble',
            'gg-dropbox'            => 'Dropbox',
            'gg-facebook'           => 'Facebook',
            'gg-flickr'             => 'Flickr',
            'gg-github'             => 'Github',
            'gg-gplus'              => 'Google+',
            'gg-instagram'          => 'Instagram',
            'gg-linkedin'           => 'LinkedIn',
            'gg-pinterest'          => 'Pinterest',
            'gg-reddit'             => 'Reddit',
            'gg-rss'                => 'RSS',
            'gg-skype'              => 'Skype',
            'gg-soundcloud'         => 'Soundcloud',
            'gg-tumbler'            => 'Tumblr',
            'gg-twitter'            => 'Twitter',
            'gg-vimeo'              => 'Vimeo',
            'gg-vkontakte'          => 'VK',
            'gg-yahoo'              => 'Yahoo',
            'gg-youtube'            => 'Youtube',
    );

    return apply_filters('gogreen_get_social_icons', $icons);
}