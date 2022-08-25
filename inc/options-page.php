<?php
/**
 * Adds an option page for ACF to post type.
 *
 * @since 1.1.0
 *
 * @package kebbet-cpt-selectedworks
 */

namespace cpt\kebbet\selectedworks\optionspage;

use const cpt\kebbet\selectedworks\POSTTYPE;

if ( function_exists( 'acf_add_options_page' ) ) {
	/**
	 * Add an option page for the post type.
	 */
	function add_options_page() {
		$page_options = array(
			'page_title' => __( 'Selected work settings', 'kebbet-cpt-selectedworks' ),
			'menu_title' => __( 'Selected work settings', 'kebbet-cpt-selectedworks' ),
			'parent'     => 'edit.php?post_type=' . POSTTYPE,
			'post_id'    => POSTTYPE,
			'slug'       => 'options', // Since title is translated.
		);
		acf_add_options_sub_page( $page_options );
	}
	add_action( 'acf/init', __NAMESPACE__ . '\add_options_page',  );
}
