<?php
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $attrs['id'] = $tab_id;

    $attrs['class'] = 'w-tab';
?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
    <?php if( !empty($title) ):?>
    <h3><?php echo esc_html($title); ?></h3>
    <?php endif; ?>
    <div class="w-tab-content">
    <?php echo wpb_js_remove_wpautop($content);?> 
    </div>
</div>