<?php
/**
 * The template for List Blog entry
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array( "post-item" ) ); ?>>
    <div class="row post-content animated animate-when-almost-visible el-appear">

        <div class="col-sm-3">
			<?php
			global $kleo_config;
			$kleo_post_format = get_post_format();

			/* For portfolio post type */
			if ( get_post_type() === 'portfolio' ) {
				if ( get_cfield( 'media_type' ) && get_cfield( 'media_type' ) != '' ) {
					$media_type = get_cfield( 'media_type' );
					switch ( $media_type ) {
						case 'slider':
							$kleo_post_format = 'gallery';
							break;

						case 'video':
						case 'hosted_video':
							$kleo_post_format = 'video';
							break;
					}
				}
			}

			switch ( $kleo_post_format ) {

				case 'video':

					//oEmbed video
					$video = get_cfield( 'embed' );
					// video bg self hosted
					$bg_video_args = array();

					if ( get_cfield( 'video_mp4' ) ) {
						$bg_video_args['mp4'] = esc_attr( get_cfield( 'video_mp4' ) );
					}
					if ( get_cfield( 'video_ogv' ) ) {
						$bg_video_args['ogv'] = esc_attr( get_cfield( 'video_ogv' ) );
					}
					if ( get_cfield( 'video_webm' ) ) {
						$bg_video_args['webm'] = esc_attr( get_cfield( 'video_webm' ) );
					}

					if ( ! empty( $bg_video_args ) ) {
						$attr_strings = array(
							'preload="none"'
						);

						if ( get_cfield( 'video_poster' ) ) {
							$attr_strings[] = 'poster="' . esc_attr( get_cfield( 'video_poster' ) ) . '"';
						}

						?>
						<div class="kleo-video-wrap">
							<video <?php echo join( ' ', $attr_strings ); ?> controls="controls" class="kleo-video" style="width: 100%; height: 100%;">
								<?php
								$source = '<source type="%s" src="%s" />';
								foreach ( $bg_video_args as $video_type => $video_src ) {
									$video_type = wp_check_filetype( $video_src, wp_get_mime_types() );
									echo sprintf( $source, $video_type['type'], esc_url( $video_src ) );
								}
								?>
							</video>
						</div>
						<?php
					} // oEmbed
                    elseif ( ! empty( $video ) ) {
						global $wp_embed;
						echo apply_filters( 'kleo_oembed_video', $video );
					}

					break;

				case 'audio':

					$audio = get_cfield( 'audio' );
					if ( ! empty( $audio ) ) { ?>
                        <div class="post-audio">
                            <audio preload="none" class="kleo-audio" id="audio_<?php the_id(); ?>" style="width:100%;"
                                   src="<?php echo esc_attr( $audio ); ?>"></audio>
                        </div>
						<?php
					}
					break;

				case 'gallery':

					$slides = get_cfield( 'slider' );
					echo '<div class="kleo-banner-slider">'
					     . '<div class="kleo-banner-items modal-gallery">';
					if ( $slides ) {
						foreach ( $slides as $slide ) {
							if ( $slide ) {
								$image = aq_resize( $slide, $kleo_config['post_gallery_img_width'], $kleo_config['post_gallery_img_height'], true, true, true );
								//small hack for non-hosted images
								if ( ! $image ) {
									$image = $slide;
								}
								echo '<article>
								<a href="' . $slide . '" data-rel="modalPhoto[inner-gallery]">
									<img src="' . $image . '" alt="' . get_the_title() . '">'
								     . kleo_get_img_overlay()
								     . '</a>
							</article>';
							}
						}
					}

					echo '</div>'
					     . '<a href="#" class="kleo-banner-prev"><i class="icon-angle-left"></i></a>'
					     . '<a href="#" class="kleo-banner-next"><i class="icon-angle-right"></i></a>'
					     . '<div class="kleo-banner-features-pager carousel-pager"></div>'
					     . '</div>';

					break;


				case 'aside':
					echo '<div class="post-format-icon"><i class="icon icon-doc"></i></div>';
					break;

				case 'link':
					echo '<div class="post-format-icon"><i class="icon icon-link"></i></div>';
					break;

				case 'quote':
					echo '<div class="post-format-icon"><i class="icon icon-quote-right"></i></div>';
					break;

				case 'image':
				default:
					if ( kleo_get_post_thumbnail_url() != '' ) {
						echo '<div class="post-image">';

						$image = kleo_get_post_thumbnail( null, 'kleo-post-small-thumb' );

						echo '<a href="' . get_permalink() . '" class="element-wrap">'
						     . $image
						     . kleo_get_img_overlay()
						     . '</a>';

						echo '</div><!--end post-image-->';
					} else {
						$post_icon = $kleo_post_format === 'image' ? 'picture' : 'doc';
						echo '<div class="post-format-icon"><i class="icon icon-' . $post_icon . '"></i></div>';
					}

					break;

			}
			?>
        </div>
        <div class="col-sm-9">

			<?php if ( ! in_array( $kleo_post_format, array( 'status', 'quote', 'link' ) ) ): ?>
                <div class="post-header">

                    <h3 class="post-title entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>

                    <span class="post-meta">
                    <?php kleo_entry_meta(); ?>
                </span>

                </div><!--end post-header-->
			<?php endif; ?>

			<?php if ( kleo_excerpt() !== '<p></p>' ) : ?>
                <div class="post-info">

                    <div class="entry-summary">
						<?php if ( ! in_array( $kleo_post_format, array( 'status', 'quote', 'link' ) ) ): ?>
							<?php echo kleo_excerpt(); ?>
						<?php else : ?>
							<?php the_content(); ?>
						<?php endif; ?>
                    </div><!-- .entry-summary -->

                </div><!--end post-info-->
			<?php endif; ?>

            <div class="post-footer">
                <small>
					<?php do_action( 'kleo_post_footer' ); ?>

					<?php if ( $kleo_post_format === 'link' ): ?>
                        <a href="<?php echo sq_get_url_link( get_the_content(), get_permalink() ); ?>" target="_blank">
                            <span class="muted pull-right"><?php esc_html_e( "Read more", 'kleo' ); ?></span>
                        </a>
					<?php else: ?>
                        <a href="<?php the_permalink(); ?>"><span class="muted pull-right">
						<?php esc_html_e( "Read more", 'kleo' ); ?></span>
                        </a>
					<?php endif; ?>
                </small>
            </div><!--end post-footer-->
        </div>


    </div><!--end post-content-->
</article>
