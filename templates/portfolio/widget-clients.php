<?php

    $client_name =  get_post_meta(get_the_ID(), '_w_client_name', true );
    $client_detail = get_post_meta(get_the_ID(), '_w_client_detail', true );
    $client_website = get_post_meta(get_the_ID(), '_w_client_website', true );

?>
<?php if( !empty( $client_name )): ?>
<div class="portfolio-client-widget widget">                    
    <h4><?php echo esc_html__('Client', 'gogreen'); ?></h4>
    <?php if( !empty( $client_website )){ ?> 
    <p><a href="<?php echo esc_url( $client_website );?>" title="<?php echo esc_attr( $client_name ); ?>" target="_blank" class="tooltip-item"><strong><?php echo esc_html( $client_name ); ?></strong></a><p>
    <?php }else{ ?>
    <p><strong><?php echo esc_html( $client_name ); ?></strong></p>
    <?php } ?>
    <?php echo wp_kses_post( $client_detail ); ?>
</div>
<?php endif; ?>