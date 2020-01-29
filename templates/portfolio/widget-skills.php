<?php

    $skills = get_the_terms( get_the_ID(), 'portfolio_skill' );

?>
<?php if( is_array($skills) && count($skills) > 0): ?>
<div class="portfolio-skill-widget widget">                    
    <h4><?php echo esc_html__('Skills', 'gogreen'); ?></h4>
    <ul>
    <?php foreach ( $skills as $item ) {?>
        <li><a href="<?php echo esc_url( get_term_link($item) ); ?>"><?php echo esc_html( $item->name );?></a></li>
    <?php } ?>  
    </ul>
</div>
<?php endif; ?>