<?php
/**
 * Shortcode attributes
 *
 * @todo add $icon_... defaults
 * @todo add $icon_typicons and etc
 *
 * @var $atts
 * @var $el_class
 * @var $message_box_style
 * @var $style
 * @var $color
 * @var $message_box_color
 * @var $css_animation
 * @var $icon_type
 * @var $icon_fontawesome
 * @var $content - shortcode content
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Message
 */

$atts = $this->convertAttributesToMessageBox2( $atts );
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$elementClass = array(
	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_message_box', $this->settings['base'], $atts ),
	'style' => 'vc_message_box-' . $message_box_style,
	'shape' => 'vc_message_box-' . $style,
	'color' => ( strlen( $color ) > 0 && strpos( 'alert', $color ) === false ) ? 'vc_color-' . $color : 'vc_color-' . $message_box_color
);

$class_to_filter = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );

if( !empty($icon_set) ){
	$icon = isset( ${"icon_" . $icon_set} )? ${"icon_" . $icon_set} : '';
} 

switch ( $color ) {
	case 'info':
		$icon_set = 'fontawesome';
		$icon = 'fa fa-info-circle';
		break;
	case 'alert-info':
		$icon_set = 'pixelicons';
		$icon = 'vc_pixel_icon vc_pixel_icon-info';
		break;
	case 'success':
		$icon_set = 'fontawesome';
		$icon = 'fa fa-check';
		break;
	case 'alert-success':
		$icon_set = 'pixelicons';
		$icon = 'vc_pixel_icon vc_pixel_icon-tick';
		break;
	case 'warning':
		$icon_set = 'fontawesome';
		$icon = 'fa fa-exclamation-triangle';
		break;
	case 'alert-warning':
		$icon_set = 'pixelicons';
		$icon = 'vc_pixel_icon vc_pixel_icon-alert';
		break;
	case 'danger':
		$icon_set = 'fontawesome';
		$icon = 'fa fa-times';
		break;
	case 'alert-danger':
		$icon_set = 'pixelicons';
		$icon = 'vc_pixel_icon vc_pixel_icon-explanation';
		break;
	case 'alert-custom':
	default:
		break;
}

$attrs = array();
$classes = array();

$classes[] = $class_to_filter;

if( $animation ){
    $classes[] = 'w-animation';
    $attrs['data-animation'] = $animation;
    if( $animation_delay ) $attrs['data-animation-delay'] = floatval( $animation_delay );
} 

$attrs['class'] = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ', $classes), $this->settings['base'], $atts ) );

?>
<div<?php echo gogreen_get_attributes( $attrs );?>>
	<div class="vc_message_box-icon"><i class="<?php echo esc_attr( $icon ); ?>"></i></div>
	<?php echo wpb_js_remove_wpautop( $content, true );	?>
</div>