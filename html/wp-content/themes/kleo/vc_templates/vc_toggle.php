<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $el_class
 * @var $style
 * @var $color
 * @var $size
 * @var $open
 * @var $css_animation
 * @var $el_id
 * @var $content - shortcode content
 * @var $css
 *
 * KLEO ADDED
 * @var $icon_closed
 * @var $icon_position
 * @var $tooltip
 * @var $tooltip_position
 * @var $tooltip_title
 * @var $tooltip_text
 * @var $tooltip_action
 * @var $animation
 *
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Toggle
 */
$title  = $el_class = $style = $color = $size = $open = $css_animation = $css = $el_id = '';
$output = '';

/* KLEO ADDED */
$use_custom_heading = '';

$inverted = false;
$atts     = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


/* compat */
if ( empty( $css ) ) {
	$css = '';
}

/**
 * @since 4.4
 */
$elementClass = array(
	'base'  => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_toggle', $this->settings['base'], $atts ),
	//'style' => 'vc_toggle_' . $style,
	//'color' => ( $color ) ? 'vc_toggle_color_' . $color : '',
	//'inverted' => ( $inverted ) ? 'vc_toggle_color_inverted' : '',
	//'size' => ( $size ) ? 'vc_toggle_size_' . $size : '',
	//'open' => ( $open === 'true' ) ? 'vc_toggle_active' : '',
	'extra' => $this->getExtraClass( $el_class ),
	//'css_animation' => $this->getCSSAnimation( $css_animation ),
);

$class_to_filter = trim( implode( ' ', $elementClass ) );
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' );
$css_class       = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$open = ( $open == 'true' ) ? ' in' : ' collapse';

if ( $animation != '' ) {
	wp_enqueue_script( 'waypoints' );
	$css_class .= " animated {$animation} {$css_animation}";
}

if ( $icon != '' ) {
	$icon = ' icon-' . $icon;
}
if ( $icon_closed != '' ) {
	$icon_closed = ' icon-' . $icon_closed;
} elseif ( $icon != '' ) {
	$icon_closed = ' icon-' . $icon;
}

$tooltip_class = '';
$tooltip_data  = [];
if ( $tooltip != '' ) {
	if ( $tooltip == 'popover' ) {
		$tooltip_class = ' ' . esc_attr( $tooltip_action ) . '-pop';
		$tooltip_data  = [
			'data-toggle' => 'popover',
			'data-container' => 'body',
			'data-title' => esc_attr( $tooltip_title ),
			'data-content' => esc_attr( $tooltip_text ),
			'data-placement' => esc_attr( $tooltip_position ),
		];

	} else {
		$tooltip_class .= ' ' . esc_attr( $tooltip_action ) . '-tip';
		$tooltip_data  = [
			'data-toggle' => 'tooltip',
			'data-original-title' => esc_attr( $tooltip_title ),
			'data-placement' => esc_attr( $tooltip_position ),
		];
	}
}

$icon_closed      .= $tooltip_class;

if ( $open == ' in' ) {
	$icon_closed .= ' hide';
}

$icon_position = $icon_position != '' ? ' icons-' . $icon_position : '';
$css_class     .= $icon_position;

$elem_id = kleo_vc_elem_increment();

if ( 'true' === $use_custom_heading ) {
	$custom_heading = visual_composer()->getShortCode( 'vc_custom_heading' );

	$data         = vc_map_integrate_parse_atts( $this->shortcode, 'vc_custom_heading', $atts, 'custom_' );
	$data['text'] = $atts['title'];
	$title        = $custom_heading->render( array_filter( $data ) );
}
?>

<div class="panel panel-default panel-toggle <?php echo esc_attr($css_class); ?>"
    <?php echo isset( $el_id ) && ! empty( $el_id ) ? " id='" . esc_attr( $el_id ) . "'" : ""; ?>>
    <div class="panel-heading">
        <div class="panel-title">
            <a class="accordion-toggle" data-toggle="collapse" href="#acc-<?php echo esc_attr( $elem_id ); ?>-d">
                <?php echo wp_kses_post( $title ); ?>
                <span class="icon-closed<?php echo esc_attr( $icon_closed ); ?>"<?php echo kleo_get_attributes_string($tooltip_data); ?>></span>
                <span class="icon-opened<?php echo ' in' != $open ? ' hide ' : ' '; echo esc_attr( $icon ); ?>"></span>
            </a>
        </div>
    </div>
    <div id="acc-<?php echo esc_attr( $elem_id ); ?>-d" class="panel-collapse<?php echo esc_attr( $open ); ?>">
        <div class="panel-body">
            <?php echo wpb_js_remove_wpautop( $content, true ); ?>
        </div>
    </div>
</div>
