<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" name="s" id="s" placeholder="<?php echo esc_attr__( 'Search &hellip;', 'gogreen' ); ?>" value="<?php the_search_query(); ?>" class="keyword" />
    <button type="submit" class="button"><i class="gg-search"></i></button>
</form>