<?php
/**
 * BuddyPress - Groups Cover Image Header.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
?>

	<div id="header-cover-image"></div>

	<?php

/**
 * Fires before the display of a group's header.
 *
 * @since 1.2.0
 */
	do_action( 'bp_before_group_header' ); ?>

	<div id="item-header-avatar" class="rounded">
		<a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>">

			<?php bp_group_avatar(); ?>

		</a>
	</div><!-- #item-header-avatar -->


	<div id="item-header-content" <?php if (isset($_COOKIE['bp-profile-header']) && $_COOKIE['bp-profile-header'] == 'small') {echo 'style="display:none;"';} ?>>

		<?php if ( sq_option( 'bp_title_location', 'breadcrumb' ) == 'disabled' ) : ?>
			<h4 class="highlight hover-tip click-tip"><?php bp_group_name(); ?></h4>
		<?php else: ?>
			<h4 class="highlight"><?php bp_group_type(); ?></h4>
		<?php endif; ?>

		<?php if(function_exists( 'bp_core_iso8601_date' )) : ?>
			<span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_group_last_active( 0, array( 'relative' => false ) ) ); ?>"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span>
		<?php else: ?>
			<span class="activity"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span>
		<?php endif; ?>

		<div id="item-actions">
			<div class="row">
				<?php if ( bp_group_is_visible() ) : ?>
					<div class="group-admins <?php if ( bp_group_has_moderators() ) { echo 'col-sm-6'; } else { echo 'col-sm-12'; } ?>">

						<h3><?php _e( 'Group Admins', 'buddypress' ); ?></h3>

						<?php bp_group_list_admins();

						/**
						 * Fires after the display of the group's administrators.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_after_group_menu_admins' );

						?>
					</div>
					<?php
					if ( bp_group_has_moderators() ) : ?>
						<div class="group-mods col-xs-6 col-sm-6">


							<?php
							/**
							 * Fires before the display of the group's moderators, if there are any.
							 *
							 * @since 1.1.0
							 */

							do_action( 'bp_before_group_menu_mods' ); ?>
							<h3><?php _e( 'Group Mods' , 'buddypress' ); ?></h3>

							<?php bp_group_list_mods();

							/**
							 * Fires after the display of the group's moderators, if there are any.
							 *
							 * @since 1.1.0
							 */
							do_action( 'bp_after_group_menu_mods' );
							?>
						</div>
						<?php
					endif;

				endif; ?>
			</div>
		</div><!-- #item-actions -->


		<?php do_action( 'bp_before_group_header_meta' ); ?>

		<div id="item-meta">

			<?php bp_group_description(); ?>

			<?php
			if (version_compare( BP_VERSION, '2.7', '>=' )) {
				bp_group_type_list();
			}
			?>

			<div id="item-buttons">

				<?php do_action( 'bp_group_header_actions' ); ?>

			</div><!-- #item-buttons -->

			<?php do_action( 'bp_group_header_meta' ); ?>

		</div>
	</div><!-- #item-header-content -->

<?php

/**
 * Fires after the display of a group's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_group_header' ); ?>

<?php if ( sq_option( 'bp_nav_overlay', 0 ) == 1 ) : ?>

	<div id="item-nav">
		<div class="item-list-tabs no-ajax" id="object-nav" aria-label="<?php esc_attr_e( 'Group primary navigation', 'buddypress' ); ?>" role="navigation">
			<ul class="responsive-tabs">
				
				<?php bp_get_options_nav(); ?>
				
				<?php
				
				/**
				 * Fires after the display of group options navigation.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_group_options_nav' ); ?>

			</ul>
		</div>
	</div><!-- #item-nav -->
	
<?php endif; ?>

<div id="template-notices" role="alert" aria-atomic="true">
	<?php

	/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
	do_action( 'template_notices' ); ?>
</div>
