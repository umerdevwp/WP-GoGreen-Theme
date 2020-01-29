<?php

    $categories = get_the_terms( get_the_ID(), 'portfolio_category' );

?>
<?php if( is_array($categories) && count($categories) > 0 ): ?>
<div class="portfolio-category-widget widget">                    
    <h4><?php echo esc_html__('Categories', 'gogreen'); ?></h4>
    <ul>
    <?php foreach ( $categories as $item ) {?>
        <li><a href="<?php echo esc_url( get_term_link($item) ); ?>"><?php echo esc_html( $item->name );?></a></li>
    <?php } ?>  
    </ul>
</div>
<?php endif; ?>