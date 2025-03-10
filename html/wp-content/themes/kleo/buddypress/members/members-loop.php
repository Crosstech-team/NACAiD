<?php

/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires before the display of the members loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_members_loop' ); ?>

<?php if ( bp_get_current_member_type() ) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message() ?></p>
<?php endif; ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) . '&per_page=' . sq_option( 'bp_members_perpage', 24 ) ) ) : ?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="member-dir-count-top">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-top">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<?php

	/**
	 * Fires before the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_members_list' ); ?>

	<ul id="members-list" class="item-list row kleo-isotope masonry" aria-live="assertive" aria-relevant="all">

		<?php while ( bp_members() ) : bp_the_member(); ?>

			<li <?php bp_member_class( [ 'kleo-masonry-item' ] ); ?>>
				<div class="member-inner-list animated animate-when-almost-visible bottom-to-top">
					<div class="item-avatar rounded">
						<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar( bp_nouveau_avatar_args() ); ?></a>
					</div>

					<div class="item">
						<div class="item-title">
							<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
						</div>

						<?php if ( function_exists( 'bp_core_iso8601_date' ) ) : ?>
							<div class="item-meta">
                                <span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_member_last_active( array( 'relative' => false ) ) ); ?>"><?php bp_member_last_active(); ?></span>
							</div>
						<?php else: ?>
							<div class="item-meta"><span class="activity"><?php bp_member_last_active(); ?></span></div>
						<?php endif; ?>

						<?php if ( bp_get_member_latest_update() ) : ?>
							<span class="update"> <?php bp_member_latest_update(); ?></span>
						<?php endif; ?>

						<?php

						/**
						 * Fires inside the display of a directory member item.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_directory_members_item' ); ?>

						<?php
						/***
						 * If you want to show specific profile fields here you can,
						 * but it'll add an extra query for each member in the loop
						 * (only one regardless of the number of fields you show):
						 *
						 * bp_member_profile_data( 'field=the field name' );
						 */
						?>
					</div>

					<div class="action">

						<?php

						/**
						 * Fires inside the members action HTML markup to display actions.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_directory_members_actions' ); ?>

					</div>

				</div><!--end member-inner-list-->
			</li>

		<?php endwhile; ?>

	</ul>

	<?php

	/**
	 * Fires after the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_members_list' ); ?>

	<?php bp_member_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-dir-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of the members loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_members_loop' ); ?>
