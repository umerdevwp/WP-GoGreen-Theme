<?php

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();
    
    $classes = array();

    $classes[] = 'w-flickr';

    if( !empty($el_class) ){
        $classes[] = $el_class;
    }

    $attrs['class'] = implode(' ', $classes);

    $attrs['data-id'] = $flickr_id;
    $attrs['data-type'] = $type;
    $attrs['data-count'] = intval($count);
    $attrs['data-columns'] = intval($columns);

?>
<div<?php echo gogreen_get_attributes($attrs);?>>
    <?php if( !empty($title) ): ?>
    <div class="w-header">
        <h3>
            <i class="gg-flickr"></i>
            <span><?php echo esc_html($title); ?></span>
        </h3>
    </div>
    <?php endif; ?>
    <div class="w-content">
        <div class="w-loader"></div>
    </div>
</div>