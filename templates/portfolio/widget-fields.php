<?php

    $custom_fields = get_post_meta( get_the_ID(), '_w_custom_fields', true );

?>
<?php if( is_array($custom_fields) && count($custom_fields) > 0 ): ?>
<?php foreach( $custom_fields as $key => $entry ) { ?>
<div class="custom-fields-widget widget">                    
<?php 
    $title = $value = '';  
    if ( isset( $entry['custom_field_title'] ) ){
        $title = $entry['custom_field_title'];
    }
    if ( isset( $entry['custom_field_value'] ) )
        $value = $entry['custom_field_value'];
?>
<?php if( !empty($title) ): ?>
<h4><?php echo esc_html($title); ?></h4>
<?php endif; ?>
<?php if( !empty($value) ): ?>
<?php echo wp_kses_post($value); ?>
<?php endif; ?>
</div>
<?php } ?>
<?php endif; ?>