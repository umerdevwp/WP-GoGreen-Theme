<?php

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

    $home_button_url = '';

    if( gogreen_get_option('blog_home') ) {
    
        if( gogreen_get_option('blog_home_page') == 'default'){
            if( get_option( 'show_on_front' ) == 'page' )
                $home_button_url = get_permalink( get_option('page_for_posts' ) );
            else 
                $home_button_url =  home_url();
        }else{
            $home_button_url = gogreen_get_option('blog_home_url');            
        }

    }

?>
<nav class="post-nav clear">
    <div class="prev-post">
    <?php
		if($previous){
            $prev_thumbnail = gogreen_get_post_thumbnail($previous->ID);
            previous_post_link('%link', '');
            echo '<div class="post-link clear">';
            previous_post_link('<span>%link</span>', $prev_thumbnail);
            previous_post_link('<h4>%link</h4>');
            echo '</div>';
		} 
    ?>
    </div>
    <div class="next-post">
    <?php
		if($next){
            $next_thumbnail = gogreen_get_post_thumbnail($next->ID);
            next_post_link('%link', '');
            echo '<div class="post-link clear">';            
            next_post_link('<h4>%link</h4>');
            next_post_link('<span>%link</span>', $next_thumbnail);
            echo '</div>';
		} 
    ?>
    </div>
    <?php if(!empty($home_button_url)):?>
    <div class="nav-home">
        <a href="<?php echo esc_url( $home_button_url );?>"><i class="gg-list"></i></a>
    </div>
    <?php endif; ?>
</nav>