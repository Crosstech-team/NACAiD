<?php
/**
 * Post custom layout template.
 *
 * @var string $location can be 'welcome' or 'settings'.
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$layout_manager = vc_modules_manager()->get_module( 'vc-post-custom-layout' );
?>
<div id="vc_ui-panel-post-custom-layout" class="vc_post-custom-layout-wrapper vc_selected-post-custom-layout-visible-ne">
	<a class="vc_post-custom-layout control-btn <?php echo $layout_manager->check_if_layout_active( 'default', $location ) ? 'vc-active-post-custom-layout' : ''; ?>"
		href="<?php echo esc_url( $layout_manager->get_layout_href_by_layout_name( 'default' ) ); ?>"
		data-post-custom-layout="default"
	>
		<svg xmlns="http://www.w3.org/2000/svg" width="88px" height="88px" viewBox="0 0 88 88">
			<g id="WPB-Editor" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				<g transform="translate(-922.000000, -587.000000)" fill="#BDCBD1" fill-rule="nonzero">
					<g id="wpb-blank-page" transform="translate(107.000000, 353.000000)">
						<g id="theme-layout-ico-copy" transform="translate(815.000000, 234.000000)">
							<path d="M82.6375,0 L5.3625,0 C2.475,0 0,2.475 0,5.3625 L0,82.6375 C0,85.525 2.475,88 5.3625,88 L82.6375,88 C85.6625,88 88,85.525 88,82.6375 L88,5.3625 C88,2.475 85.525,0 82.6375,0 Z M5.3625,2.75 L82.6375,2.75 C84.0125,2.75 85.25,3.9875 85.25,5.3625 L85.25,15.95 L2.75,15.95 L2.75,5.3625 C2.75,3.9875 3.9875,2.75 5.3625,2.75 Z M82.6375,85.25 L5.3625,85.25 C3.9875,85.25 2.75,84.0125 2.75,82.6375 L2.75,18.7 L85.25,18.7 L85.25,82.6375 C85.25,84.0125 84.0125,85.25 82.6375,85.25 Z" id="XMLID_393_"/>
							<path d="M10.175,11 L12.925,11 C13.75,11 14.3,10.56 14.3,9.9 C14.3,9.24 13.75,8.8 12.925,8.8 L10.175,8.8 C9.35,8.8 8.8,9.24 8.8,9.9 C8.8,10.56 9.35,11 10.175,11 Z" id="XMLID_454_"/>
							<path d="M18.975,11 L21.725,11 C22.55,11 23.1,10.56 23.1,9.9 C23.1,9.24 22.55,8.8 21.725,8.8 L18.975,8.8 C18.15,8.8 17.6,9.24 17.6,9.9 C17.6,10.56 18.15,11 18.975,11 L18.975,11 Z" id="XMLID_455_"/>
							<path d="M28.875,11 L31.625,11 C32.45,11 33,10.56 33,9.9 C33,9.24 32.45,8.8 31.625,8.8 L28.875,8.8 C28.05,8.8 27.5,9.24 27.5,9.9 C27.5,10.56 28.1875,11 28.875,11 Z" id="XMLID_456_"/>
							<g id="001-wordpress" transform="translate(26.000000, 33.000000)">
								<path d="M18,0 C8.07738693,0 0,8.07738693 0,18 C0,27.9226131 8.07738693,36 18,36 C27.9226131,36 36,27.9226131 36,18 C36,8.07738693 27.9226131,0 18,0 Z M18,2.57788945 C21.9979899,2.57788945 25.6522613,4.10653266 28.3929648,6.62110553 C27.9316583,6.53065327 27.4703518,6.54874372 27.0180905,6.70251256 C25.7698492,7.13668342 24.7025126,8.94572864 25.4894472,10.4653266 C25.8512563,11.161809 26.5748744,12.1567839 27.361809,13.1969849 C27.8683417,13.8753769 28.9718593,16.3356784 28.0221106,19.9537688 C27.3527638,22.5135678 25.9507538,26.918593 25.9507538,26.918593 L20.3517588,10.6281407 L22.1155779,10.6281407 C22.4773869,10.6281407 22.7668342,10.3386935 22.7668342,9.97688442 C22.7668342,9.61507538 22.4773869,9.32562814 22.1155779,9.32562814 L13.558794,9.32562814 C13.1969849,9.32562814 12.9075377,9.61507538 12.9075377,9.97688442 C12.9075377,10.3386935 13.1969849,10.6281407 13.558794,10.6281407 L15.0331658,10.6281407 L17.5929648,17.2944724 L14.2733668,27.198995 L8.70150754,10.6281407 L10.4653266,10.6281407 C10.8271357,10.6281407 11.1165829,10.3386935 11.1165829,9.97688442 C11.1165829,9.61507538 10.8271357,9.32562814 10.4653266,9.32562814 L5.25527638,9.32562814 C8.04120603,5.25527638 12.7175879,2.57788945 18,2.57788945 L18,2.57788945 Z M2.57788945,18 C2.57788945,15.8020101 3.03919598,13.7125628 3.87135678,11.8221106 L11.2974874,31.8844221 C6.14170854,29.3879397 2.57788945,24.1055276 2.57788945,18 L2.57788945,18 Z M13.5226131,32.7527638 L18.3346734,19.4291457 L23.1557789,32.5356784 C21.5457286,33.1055276 19.8090452,33.4221106 18.0090452,33.4221106 C16.4442211,33.4221106 14.9427136,33.1869347 13.5226131,32.7527638 L13.5226131,32.7527638 Z M26.1497487,31.0884422 C27.1175879,28.239196 30.4643216,18.2984925 31.0974874,16.3266332 C31.6944724,14.4723618 32.1738693,13.3869347 32.1376884,11.8492462 C32.960804,13.7396985 33.4221106,15.8201005 33.4221106,18 C33.4221106,23.5085427 30.5095477,28.3567839 26.1497487,31.0884422 Z" id="Shape"/>
							</g>
						</g>
					</g>
				</g>
			</g>
		</svg>
		<strong class="vc_layout-label"><?php esc_html_e( 'Default Layout', 'js_composer' ); ?></strong>
		<p class="vc_layout-description"><?php esc_html_e( 'A blank page with your theme header and footer', 'js_composer' ); ?></p>
	</a>
	<a class="vc_post-custom-layout control-btn <?php echo $layout_manager->check_if_layout_active( 'blank', $location ) ? 'vc-active-post-custom-layout' : ''; ?>"
		href="<?php echo esc_url( $layout_manager->get_layout_href_by_layout_name( 'blank' ) ); ?>"
		data-post-custom-layout="blank"
	>
		<svg xmlns="http://www.w3.org/2000/svg" width="88px" height="88px" viewBox="0 0 88 88">
			<g id="WPB-Editor" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				<g transform="translate(-510.000000, -587.000000)" fill="#BDCBD1" fill-rule="nonzero">
					<g id="wpb-blank-page" transform="translate(107.000000, 353.000000)">
						<g id="blank-page-ico" transform="translate(403.000000, 234.000000)">
							<path d="M82.6375,0 L5.3625,0 C2.475,0 0,2.475 0,5.3625 L0,82.6375 C0,85.525 2.475,88 5.3625,88 L82.6375,88 C85.6625,88 88,85.525 88,82.6375 L88,5.3625 C88,2.475 85.525,0 82.6375,0 Z M5.3625,2.75 L82.6375,2.75 C84.0125,2.75 85.25,3.9875 85.25,5.3625 L85.25,15.95 L2.75,15.95 L2.75,5.3625 C2.75,3.9875 3.9875,2.75 5.3625,2.75 Z M82.6375,85.25 L5.3625,85.25 C3.9875,85.25 2.75,84.0125 2.75,82.6375 L2.75,18.7 L85.25,18.7 L85.25,82.6375 C85.25,84.0125 84.0125,85.25 82.6375,85.25 Z" id="XMLID_393_"/>
							<path d="M10.175,11 L12.925,11 C13.75,11 14.3,10.56 14.3,9.9 C14.3,9.24 13.75,8.8 12.925,8.8 L10.175,8.8 C9.35,8.8 8.8,9.24 8.8,9.9 C8.8,10.56 9.35,11 10.175,11 Z" id="XMLID_454_"/>
							<path d="M18.975,11 L21.725,11 C22.55,11 23.1,10.56 23.1,9.9 C23.1,9.24 22.55,8.8 21.725,8.8 L18.975,8.8 C18.15,8.8 17.6,9.24 17.6,9.9 C17.6,10.56 18.15,11 18.975,11 L18.975,11 Z" id="XMLID_455_"/>
							<path d="M28.875,11 L31.625,11 C32.45,11 33,10.56 33,9.9 C33,9.24 32.45,8.8 31.625,8.8 L28.875,8.8 C28.05,8.8 27.5,9.24 27.5,9.9 C27.5,10.56 28.1875,11 28.875,11 Z" id="XMLID_456_"/>
						</g>
					</g>
				</g>
			</g>
		</svg>
		<strong class="vc_layout-label"><?php esc_html_e( 'Blank Layout', 'js_composer' ); ?></strong>
		<p class="vc_layout-description"><?php esc_html_e( 'A completely blank page without a header and footer', 'js_composer' ); ?></p>
	</a>

</div>
