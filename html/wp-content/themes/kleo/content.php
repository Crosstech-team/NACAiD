<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */
?>

<?php
/* Helper variables for this template */
$is_single          = is_single();
$post_meta_enabled  = kleo_postmeta_enabled();
$post_media_enabled = ( kleo_postmedia_enabled() && kleo_get_post_thumbnail() != '' );
/* Check if we need an extra container for meta and media */
$show_extra_container = $is_single && sq_kleo()->get_option( 'has_vc_shortcode' ) && $post_media_enabled;

$post_class = 'clearfix';
if ( $is_single && get_cfield( 'centered_text' ) == 1 ) {
	$post_class .= ' text-center';
}

?>

<!-- Begin Article -->
<article id="post-<?php the_ID(); ?>" <?php post_class( array( $post_class ) ); ?>>

	<?php if ( ! $is_single ) : ?>
		<h2 class="article-title entry-title">
			<a href="<?php the_permalink(); ?>"
			   title="<?php echo esc_attr( sprintf( esc_html__( 'Permalink to %s', 'kleo' ), the_title_attribute( 'echo=0' ) ) ); ?>"
			   rel="bookmark"><?php the_title(); ?></a>
		</h2>
	<?php endif; //! is_single() ?>

	<?php if ( $show_extra_container ) : /* Small fix for full width layout to center media and meta */ ?>
	<div class="container">
		<?php endif; ?>

		<?php if ( $post_meta_enabled ) :
			$meta_class = 'article-meta';
			if ( sq_kleo()->get_option( 'has_vc_shortcode' ) ) {
				$meta_class .= ' container';
			}
            ?>
			<div class="<?php echo esc_attr( $meta_class ); ?>">
				<span class="post-meta">
				    <?php kleo_entry_meta(); ?>
				</span>
				<?php edit_post_link( esc_html__( 'Edit', 'kleo' ), '<span class="edit-link">', '</span>' ); ?>
			</div><!--end article-meta-->

		<?php endif; ?>

		<?php if ( $post_media_enabled ) : ?>
			<div class="article-media">
				<?php echo kleo_get_post_thumbnail( null, 'kleo-full-width' ); ?>
			</div><!--end article-media-->
		<?php endif; ?>

		<?php if ( $show_extra_container ) : /* Small fix for full width layout to center media and meta */ ?>
	</div>
<?php endif; ?>

	<div class="article-content">

		<?php do_action( 'kleo_before_inner_article_loop' ); ?>

		<?php if ( ! $is_single ) : // Only display Excerpts for Search ?>

			<?php echo kleo_excerpt( 50 ); ?>
			<p class="kleo-continue">
				<a class="btn btn-default" href="<?php the_permalink() ?>"><?php kleo_continue_reading(); ?></a>
			</p>

		<?php else : ?>

			<?php the_content( kleo_get_continue_reading() ); ?>
			<?php wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kleo' ),
				'after'  => '</div>',
			) ); ?>

		<?php endif; ?>

		<?php do_action( 'kleo_after_inner_article_loop' ); ?>

	</div><!--end article-content-->

</article><!--end article-->
