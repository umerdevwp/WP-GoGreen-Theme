<?php 

 	$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

    extract( $atts );

    $attrs = array();

    $classes = array();

    $classes[] = 'w-section-separator';

    $classes[] = 'w-'.$style;

    $classes[] = 'w-'.$overlap;

    $reflects = explode( ',', $reflect );

    if( count($reflects) ) $classes[] = implode(' ', $reflects);

    if( !empty($el_class) ){
        $classes[] = $el_class;
    }

    $attrs['class'] = implode(' ', $classes);

    if( empty($shape_color) ) $shape_color = gogreen_get_color();

?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <?php
    switch ($style) {        
        case '1':
            ?>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 50" preserveAspectRatio="none">
                <polygon fill="<?php echo esc_attr($shape_color) ?>" points="0,0 25,15 25,50 0,50" />
                <polygon fill="<?php echo esc_attr($shape_color) ?>" points="100,0 100,50 75,50" />
                <polygon fill="<?php echo esc_attr($background_color) ?>" points="0,50 25,15 75,48 100,30 100,50" />
            </svg>        
            <?php
            break; 
        case '2':
            ?>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 50" preserveAspectRatio="none">
                <polygon fill="<?php echo esc_attr($shape_color) ?>" points="0,25 40,0 60,48 0,50" />
                <polygon fill="<?php echo esc_attr($background_color) ?>" points="0,50 38,25 60,48 100,0 100,50" />
            </svg>           
            <?php
            break;
        case '3':
            ?>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 50" preserveAspectRatio="none">
                <polygon fill="<?php echo esc_attr($shape_color) ?>" points="0,20 30,10 70,30 100,0 100,50 0,50" />
                <polygon fill="<?php echo esc_attr($background_color) ?>" points="0,50 30,8 70,50 100,30 100,50" />
            </svg>          
            <?php
            break;  
        case '4':
            ?>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 50" preserveAspectRatio="none">
                <polygon fill="<?php echo esc_attr($shape_color) ?>" points="0,25 30,48 83,0 100,48 100,50 0,50" />
                <polygon fill="<?php echo esc_attr($background_color) ?>" points="0,50 15,35 30,48 80,20 100,50" />
            </svg>          
            <?php
            break;  
        case '5':
            ?>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 50" preserveAspectRatio="none">
                <polygon fill="<?php echo esc_attr($shape_color) ?>" points="0,0 50,48 100,0 100,50 0,50" />
                <polygon fill="<?php echo esc_attr($background_color) ?>" points="0,25 50,48 100,25 100,50 0,50" />
            </svg>          
            <?php
            break;       
    }
    ?>    
</div>