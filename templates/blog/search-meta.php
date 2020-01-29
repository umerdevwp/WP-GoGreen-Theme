<div class="post-meta">
    <?php if( gogreen_get_option('search_show_date') ){?>
    <span class="post-datetime">
        <a href="<?php echo esc_url( get_day_link( get_the_date('Y'), get_the_date('m'), get_the_date('d') ) );?>">
        <?php echo get_the_date();?>
        </a>
    </span>
    <?php }?>
    <?php if( gogreen_get_option('search_show_author') ){?>
    <span>
        <?php echo the_author_posts_link();?>
    </span>
    <?php }?>
</div>