<?php
/**
 * The template for displaying [vc_button].
 *
 * This template can be overridden by copying it to yourtheme/vc_templates/vc_button.php.
 *
 * @see https://kb.wpbakery.com/docs/developers-how-tos/change-shortcodes-html-output
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $color
 * @var $size
 * @var $icon
 * @var $target
 * @var $href
 * @var $el_class
 * @var $title
 * Shortcode class
 * @var WPBakeryShortCode_Vc_Button $this
 */
$color = $size = $icon = $target = $href = $el_class = $title = '';
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$a_class = '';

if ( '' !== $el_class ) {
	$tmp_class = explode( ' ', strtolower( $el_class ) );
	$tmp_class = str_replace( '.', '', $tmp_class );
	if ( in_array( 'pull-right', $tmp_class, true ) && '' !== $href ) {
		$a_class .= ' pull-right';
		$el_class = str_ireplace( 'pull-right', '', $el_class );
	}
	if ( in_array( 'pull-left', $tmp_class, true ) && '' !== $href ) {
		$a_class .= ' pull-left';
		$el_class = str_ireplace( 'pull-left', '', $el_class );
	}
}

if ( 'same' === $target || '_self' === $target ) {
	$target = '';
}
$target = ( '' !== $target ) ? ' target="' . esc_attr( $target ) . '"' : '';

$color = ( '' !== $color ) ? ' wpb_' . $color : '';
$size = ( '' !== $size && 'wpb_regularsize' !== $size ) ? ' wpb_' . $size : ' ' . $size;
$icon = ( '' !== $icon && 'none' !== $icon ) ? ' ' . $icon : '';
$i_icon = ( '' !== $icon ) ? ' <i class="icon"> </i>' : '';
$el_class = $this->getExtraClass( $el_class );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_button ' . $color . $size . $icon . $el_class, $this->settings['base'], $atts );

if ( '' !== $href ) {
	$output .= '<span class="' . esc_attr( $css_class ) . '">' . $title . $i_icon . '</span>';
	$output = '<a class="wpb_button_a' . esc_attr( $a_class ) . '" title="' . esc_attr( $title ) . '" href="' . esc_url( $href ) . '"' . $target . '>' . $output . '</a>';
} else {
	$output .= '<button class="' . esc_attr( $css_class ) . '">' . $title . $i_icon . '</button>';

}

return $output;
