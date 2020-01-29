<?php
   
    $tags = get_the_terms( get_the_ID(), 'portfolio_tag' );
    $project_url = get_post_meta(get_the_ID(), '_w_project_url', true );
    $post_date = gogreen_get_option('portfolio_single_date');
    if( $tags || $project_url || $post_date ):
?>
<div class="portfolio-meta-widget widget">
    <?php if( is_array($tags) && count($tags) > 0 ): ?>
    <p class="portfolio-tags">
        <?php $tag_links = array(); ?>
        <?php 
        foreach ( $tags as $item ){
            $tag_links[] = sprintf('<a href="%s">%s</a>', esc_url( get_term_link($item) ), esc_html( $item->name ));
        } 
        echo '<span><i class="gg-tag"></i>'.implode(', ', $tag_links).'</span>';
        ?>  
    </p>
    <?php endif; ?>  
    <?php if( !empty( $project_url )): ?>
    <p class="portfolio-external-link"><i class="gg-link"></i> <a href="<?php echo esc_url( $project_url );?>" title="<?php echo esc_attr__('Visit Site', 'gogreen'); ?>" class="launch-project" target="_blank"><?php echo esc_html__('Visit Site', 'gogreen'); ?></a></p>
    <?php endif; ?>
    <?php if( $post_date ): ?>
    <p class="portfolio-date"><i class="gg-calendar"></i><?php echo esc_html__('Published', 'gogreen').': '. get_the_date();?></p>
    <?php endif; ?>
    <?php if( gogreen_get_option('portfolio_single_share') ): ?>
    <p class="portfolio-share">
    <?php
    
    $share_links = array(
        'gg-facebook' => 'http://www.facebook.com/sharer/sharer.php?u='. urlencode( get_permalink() ),
        'gg-twitter'    => 'https://twitter.com/intent/tweet?source=webclient&amp;url='. urlencode( get_permalink() ).'&amp;text='. urlencode( get_the_title() ),
        'gg-gplus' => 'https://plus.google.com/share?url='. urlencode( get_permalink() ),
    );

    $share_links = apply_filters('gogreen_portfolio_share_links', $share_links);

    foreach ($share_links as $icon => $link) {
        echo sprintf('<a href="%s" target="_blank"><i class="%s"></i></a>', $link, $icon);
    }
    ?>  
    </p>
    <?php endif; ?>
</div>
<?php endif; ?>  