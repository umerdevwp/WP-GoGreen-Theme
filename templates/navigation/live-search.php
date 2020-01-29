<?php

$search_types = array();

if( gogreen_get_option('ajax_search') ){
	
	$search_post_types = gogreen_get_option('search_post_type');
    if( is_array($search_post_types) ){
    	foreach ($search_post_types as $post_type => $value) {
    		if( $value == 1 ) $search_types[] = $post_type;
    	} 
    }

}

?>
<div id="live-search" class="w-<?php echo esc_attr( gogreen_get_header_style() ); ?>">
    <div class="container">
        <form id="live-search-form" class="live-search-form clear" action="<?php echo esc_url( get_site_url() );?>" method="get">
        	<input type="hidden" name="wyde_search_post_types" value="<?php echo esc_attr( implode(',', $search_types) );?>" />
        	<input type="hidden" name="wyde_search_suggestions" value="<?php echo esc_attr( gogreen_get_option('search_suggestion_items') );?>" />
            <input type="text" name="s" id="wyde-search-keyword" value="<?php the_search_query(); ?>" placeholder="<?php echo esc_html__('Start Typing...', 'gogreen'); ?>" />
            <a href="#" class="fullscreen-remove-button"><i class="gg-cancel"></i></a>
        </form>
    </div>
</div>