<?php
/**
 * Our generic admin setup.
 *
 * @package MinimumViableMeta
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Start our engines.
 */
class MinimumViableMeta_Admin {

	/**
	 * Call our hooks.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'admin_enqueue_scripts',        array( $this, 'load_admin_assets'       ),  10      );
	}

	/**
	 * Load our admin side JS and CSS.
	 *
	 * @todo add conditional loading for the assets.
	 *
	 * @return void
	 */
	public function load_admin_assets( $hook ) {

		// Bail without the screen object function.
		if ( ! function_exists( 'get_current_screen' ) ) {
			return;
		}

		// Fetch current screen object.
		$screen = get_current_screen();

		// Bail if we aren't on the right part, or the screen object is fucked.
		if ( ! is_object( $screen ) || empty( $screen->base ) ) {
			return;
		}

		// Set my post type.
		$ptype  = ! empty( $screen->post_type ) ? $screen->post_type : false;

		// We fit the requirement, so let's do it.
		if ( 'appearance_page_minshare-meta-settings' === $screen->base || 'post' === $screen->base && in_array( $screen->base, minshare_meta()->supported_types() ) ) {

			// Set a file suffix structure based on whether or not we want a minified version.
			$file   = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? 'minshare-meta-admin' : 'minshare-meta-admin.min';

			// Set a version for whether or not we're debugging.
			$vers   = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? time() : MINSHARE_META_VERS;

			// Load our CSS file.
			wp_enqueue_style( 'minshare-meta-admin', MINSHARE_META_ASSETS_URL . '/css/' . $file . '.css', false, $vers, 'all' );

			// And our JS.
			wp_enqueue_media();
			wp_enqueue_script( 'minshare-meta-admin', MINSHARE_META_ASSETS_URL . '/js/' . $file . '.js', array( 'jquery' ), $vers, true );
		}
	}


	// End our class.
}

// Call our class.
$MinimumViableMeta_Admin = new MinimumViableMeta_Admin();
$MinimumViableMeta_Admin->init();