<?php

if( function_exists('wyde_include_mega_menu') ) {
    wyde_include_mega_menu();
}

if( !class_exists( 'gogreen_walker_megamenu_nav' ) ){

    class gogreen_walker_megamenu_nav extends Walker_Nav_Menu
    {
        function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			
			if( isset( $item->megamenu ) && !empty( $item->megamenu ) ){
				$classes[] = 'megamenu grid-'.$item->megamenu.'-cols';
            } 

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        	$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names .'>';

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$icon = '';
			if( isset( $item->icon ) && !empty( $item->icon ) ){
				$icon = '<i class="'. $item->icon .'"></i>';
			}

			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . $icon . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;
	
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }
}

if( !class_exists( 'gogreen_walker_onepage_nav' ) ) {  
     
    class gogreen_walker_onepage_nav extends Walker_Nav_Menu{
        
        function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			
			if( isset( $item->megamenu ) && !empty( $item->megamenu ) ){
				$classes[] = 'megamenu grid-'.$item->megamenu.'-cols';
            } 

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        	$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names .'>';
          
            $atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			
			if($item->object == 'page' && $depth == 0)
            {
                $page_item = get_post($item->object_id);
                if( is_front_page() ){
                    $atts['href'] = '#'. esc_attr( $page_item->post_name ) ;
                }else{
                    $atts['href'] = esc_url( home_url() .'/#' . $page_item->post_name );
                }

            }else{
                $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
            }

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$icon = '';
			if( isset( $item->icon ) && !empty( $item->icon ) ){
				$icon = '<i class="'. $item->icon .'"></i>';
			}

			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';

			$item_output .= $args->link_before . $icon . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;
	
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }

}

if( !class_exists( 'gogreen_walker_vertical_nav' ) ) {  
     
    class gogreen_walker_vertical_nav extends Walker_Nav_Menu{
        
        function start_lvl( &$output, $depth = 0, $args = array() ) {
            $output .= "\n<ul class=\"sub-menu\">\n";
            $output .= "\n<li class=\"back-to-parent\"><span>". esc_html__('Back', 'gogreen') ."</span></li>\n";
        }

        function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$id = apply_filters( 'nav_menu_item_id', 'vertical-menu-item-'. $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names .'>';

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$icon = '';
			if( isset( $item->icon ) && !empty( $item->icon ) ){
				$icon = '<i class="'. $item->icon .'"></i>';
			}

			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';

			$item_output .= $args->link_before . $icon . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

    }

}

if( !class_exists( 'gogreen_walker_onepage_vertical_nav' ) ) {  
     
    class gogreen_walker_onepage_vertical_nav extends Walker_Nav_Menu{
        
        function start_lvl( &$output, $depth = 0, $args = array() ) {
            $output .= "\n<ul class=\"sub-menu\">\n";
            $output .= "\n<li class=\"back-to-parent\"><span>". esc_html__('Back', 'gogreen') ."</span></li>\n";
        }

        function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		   
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
		    $classes[] = 'menu-item-' . $item->ID;
            
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
            $class_names = ' class="'. esc_attr( $class_names ) . '"';

			$id = apply_filters( 'nav_menu_item_id', 'vertical-menu-item-'. $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names .'>';
          
            $atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			
			if($item->object == 'page' && $depth == 0)
            {
                $page_item = get_post($item->object_id);
                if( is_front_page() ){
                    $atts['href'] = '#'. esc_attr( $page_item->post_name ) ;
                }else{
                    $atts['href'] = esc_url( home_url() .'/#' . $page_item->post_name );
                }

            }else{
                $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
            }

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$icon = '';
			if( isset( $item->icon ) && !empty( $item->icon ) ){
				$icon = '<i class="'. $item->icon .'"></i>';
			}

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before . $icon . apply_filters( 'the_title', $item->title, $item->ID );
            $item_output .= $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }


    }

}