<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $source
 * @var $image
 * @var $custom_src
 * @var $onclick
 * @var $img_size
 * @var $external_img_size
 * @var $caption
 * @var $img_link_large
 * @var $link
 * @var $img_link_target
 * @var $alignment
 * @var $el_class
 * @var $css_animation
 * @var $style
 * @var $external_style
 * @var $border_color
 * @var $css
 *
 * KLEO ADDED
 * @var $animation
 * @var $full_width
 * @var $box_shadow
 * @var $visibility
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Single_image
 */

$animation = $full_width = $box_shadow = '';

/* END KLEO ADDED */

$title = $source = $image = $custom_src = $onclick = $img_size = $external_img_size = $external_border_color =
$caption = $img_link_large = $link = $img_link_target = $alignment = $el_class = $css_animation = $style = $external_style = $border_color = $css = '';
$atts  = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$default_src = vc_asset_url( 'vc/no_image.png' );

/* backward compatibility */
if ( empty( $source ) ) {
	$source = 'media_library';
}
if ( empty( $add_caption ) ) {
	$add_caption = '';
}
if ( empty( $css ) ) {
	$css = '';
}


// backward compatibility. since 4.6
if ( empty( $onclick ) && isset( $img_link_large ) && 'yes' === $img_link_large ) {
	$onclick = 'img_link_large';
} elseif ( empty( $atts['onclick'] ) && ( ! isset( $atts['img_link_large'] ) || 'yes' !== $atts['img_link_large'] ) ) {
	$onclick = 'custom_link';
}

if ( 'external_link' === $source ) {
	$style        = $external_style;
	$border_color = $external_border_color;
}

$border_color = ( '' !== $border_color ) ? ' vc_box_border_' . $border_color : '';

$img = false;

switch ( $source ) {
	case 'media_library':
	case 'featured_image':

		if ( 'featured_image' === $source ) {
			$post_id = get_the_ID();
			if ( $post_id && has_post_thumbnail( $post_id ) ) {
				$img_id = get_post_thumbnail_id( $post_id );
			} else {
				$img_id = 0;
			}
		} else {
			if ( is_numeric( $image ) ) {
				$img_id = preg_replace( '/[^\d]/', '', $image );
			} else {
				$img_id = attachment_url_to_postid( $image );
			}
		}

		// set rectangular
		if ( preg_match( '/_circle_2$/', $style ) ) {
			$style    = preg_replace( '/_circle_2$/', '_circle', $style );
			$img_size = $this->getImageSquareSize( $img_id, $img_size );
		}

		if ( ! $img_size ) {
			$img_size = 'medium';
		}


		$img_path = wp_get_attachment_image_src( $img_id, 'full' );
		if ( null != $img_path ) {
			add_filter( 'wp_get_attachment_image_attributes', 'kleo_vc_single_img_title_fix', 10, 2 );

			$img = wpb_getImageBySize( array(
				'attach_id'  => $img_id,
				'thumb_size' => $img_size,
				'class'      => 'vc_single_image-img',
			) );

			remove_filter( 'wp_get_attachment_image_attributes', 'kleo_vc_single_img_title_fix', 10 );

		} else {
			$img = null;
		}

		// don't show placeholder in public version if post doesn't have featured image
		if ( 'featured_image' === $source ) {
			if ( ! $img && 'page' === vc_manager()->mode() ) {
				return;
			}
		}

		break;

	case 'external_link':
		$dimensions = vcExtractDimensions( $external_img_size );
		$hwstring   = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';

		$custom_src = $custom_src ? esc_attr( $custom_src ) : $default_src;

		$img = array(
			'thumbnail' => '<img class="vc_single_image-img" ' . $hwstring . ' src="' . $custom_src . '" />',
		);
		break;

	default:
		$img = false;
}

if ( ! $img ) {
	$img['thumbnail'] = '<img class="vc_img-placeholder vc_single_image-img" src="' . $default_src . '" />';
}

$el_class = $this->getExtraClass( $el_class );

// backward compatibility
if ( vc_has_class( 'prettyphoto', $el_class ) ) {
	$onclick = 'link_image';
}

// backward compatibility. will be removed in 4.7+
if ( ! empty( $atts['img_link'] ) ) {
	$link = $atts['img_link'];
	if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $link ) ) {
		$link = 'http://' . $link;
	}
}

// backward compatibility
if ( in_array( $link, array( 'none', 'link_no' ) ) ) {
	$link = '';
}

$a_attrs = array();

switch ( $onclick ) {
	case 'img_link_large':

		if ( 'external_link' === $source ) {
			$link = $custom_src;
		} else {
			$link = wp_get_attachment_image_src( $img_id, 'large' );
			$link = $link[0];
		}

		break;

	case 'link_image':

		$a_attrs['class'] = 'prettyphoto';
		$a_attrs['rel']   = 'prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']';

		// backward compatibility
		if ( vc_has_class( 'prettyphoto', $el_class ) ) {
			// $link is already defined
		} elseif ( 'external_link' === $source ) {
			$link = $custom_src;
		} else {
			$link = wp_get_attachment_image_src( $img_id, 'large' );
			$link = $link[0];
		}

		break;

	case 'custom_link':
		// $link is already defined
		break;

	case 'zoom':
		wp_enqueue_script( 'vc_image_zoom' );

		if ( 'external_link' === $source ) {
			$large_img_src = $custom_src;
		} else {
			$large_img_src = wp_get_attachment_image_src( $img_id, 'large' );
			if ( $large_img_src ) {
				$large_img_src = $large_img_src[0];
			}
		}

		$img['thumbnail'] = str_replace( '<img ', '<img data-vc-zoom="' . $large_img_src . '" ', $img['thumbnail'] );

		break;
}

// backward compatibility
if ( vc_has_class( 'prettyphoto', $el_class ) ) {
	$el_class = vc_remove_class( 'prettyphoto', $el_class );
}

$wrapperClass = 'vc_single_image-wrapper ' . $style . ' ' . $border_color;

/* KLEO ADDED */
if ( 'yes' == $box_shadow ) {
	$wrapperClass .= ' box-shadow';
} elseif ( 'zoom' == $box_shadow ) {
	$el_class .= ' zoomin-shd-singleimg';
}

$class_to_filter = 'wpb_single_image wpb_content_element vc_align_' . esc_attr( $alignment );
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );

if ( $animation != '' ) {
	wp_enqueue_script( 'waypoints' );
	$class_to_filter .= " animated {$animation} {$css_animation}";
}

if ( $full_width != '' ) {
	$class_to_filter .= ' img-full-width';
}

if ( $visibility != '' ) {
	$class_to_filter .= ' ' . str_replace( ',', ' ', $visibility );
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

if ( in_array( $source, array( 'media_library', 'featured_image' ) ) && 'yes' === $add_caption ) {
	$post    = get_post( $img_id );
	$caption = $post->post_excerpt;
} else {
	if ( 'external_link' === $source ) {
		$add_caption = 'yes';
	}
}

?>
<div class="<?php echo esc_attr( trim( $css_class ) ); ?>">
	<?php echo wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_singleimage_heading' ) ); ?>
	<figure class="wpb_wrapper vc_figure">
		<?php
		if ( $link ) {
			$a_attrs['href']   = $link;
			$a_attrs['target'] = $img_link_target;
			if ( ! empty( $a_attrs['class'] ) ) {
				$wrapperClass .= ' ' . $a_attrs['class'];
				unset( $a_attrs['class'] );
			}
			?>
			<a <?php echo vc_stringify_attributes( $a_attrs ); ?> class="<?php echo esc_attr( $wrapperClass ); ?>">
				<?php echo wp_kses_post( $img['thumbnail'] ); ?>
			</a>
			<?php
		} else {
			?>
			<div class="<?php echo esc_attr( $wrapperClass ); ?>">
				<?php echo wp_kses_post( $img['thumbnail'] ); ?>
			</div>
			<?php
		}
		?>
		<?php if ( 'yes' === $add_caption && '' !== $caption ) : ?>
			<figcaption class="vc_figure-caption"><?php echo esc_html( $caption ); ?></figcaption>
		<?php endif; ?>
	</figure>
</div>
