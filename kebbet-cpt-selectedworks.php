<?php
/**
 * Plugin Name: Kebbet plugins - Custom Post Type: Selected works
 * Plugin URI:  https://github.com/kebbet/kebbet-cpt-selectedworks
 * Description: Registers a Custom Post Type.
 * Version:     1.2.0
 * Author:      Erik Betshammar
 * Author URI:  https://verkan.se
 * Update URI:  false
 *
 * @package kebbet-cpt-selectedworks
 * @author Erik Betshammar
*/

namespace cpt\kebbet\selectedworks;

const POSTTYPE    = 'selected-works';
const SLUG        = 'works';
const ICON        = 'format-image';
const MENUPOS     = 29;
const THUMBNAIL   = true;

/**
 * Link to ICONS
 *
 * @link https://developer.wordpress.org/resource/dashicons/
 */

/**
 * Hook into the 'init' action
 */
function init() {
	load_textdomain();
	register();
	if ( true === THUMBNAIL ) {
		add_theme_support( 'post-thumbnails' );
	}
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ .'\enqueue_scripts' );
}
add_action( 'init', __NAMESPACE__ . '\init', 0 );

/**
 * Flush rewrite rules on registration.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 */
function activation_hook() {
	register();
	\flush_rewrite_rules();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\activation_hook' );

/**
 * Deactivation hook.
 */
function deactivation_hook() {
    \unregister_post_type( POSTTYPE );
    \flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . 'deactivation_hook' );

/**
 * Load plugin textdomain.
 */
function load_textdomain() {
	load_plugin_textdomain( 'kebbet-cpt-selectedworks', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Register Custom Post Type
 */
function register() {
	$labels_args       = array(
		'name'                     => _x( 'Selected works', 'Post Type General Name', 'kebbet-cpt-selectedworks' ),
		'singular_name'            => _x( 'Selected work', 'Post Type Singular Name', 'kebbet-cpt-selectedworks' ),
		'menu_name'                => _x( 'Selected works', 'Menu name', 'kebbet-cpt-selectedworks' ),
		'name_admin_bar'           => __( 'Selected work post', 'kebbet-cpt-selectedworks' ),
		'all_items'                => __( 'All posts', 'kebbet-cpt-selectedworks' ),
		'add_new_item'             => __( 'New post', 'kebbet-cpt-selectedworks' ),
		'add_new'                  => __( 'Add new post', 'kebbet-cpt-selectedworks' ),
		'new_item'                 => __( 'New post', 'kebbet-cpt-selectedworks' ),
		'edit_item'                => __( 'Edit post', 'kebbet-cpt-selectedworks' ),
		'update_item'              => __( 'Update post', 'kebbet-cpt-selectedworks' ),
		'view_item'                => __( 'View post', 'kebbet-cpt-selectedworks' ),
		'view_items'               => __( 'View posts', 'kebbet-cpt-selectedworks' ),
		'search_items'             => __( 'Search posts', 'kebbet-cpt-selectedworks' ),
		'not_found'                => __( 'Not found', 'kebbet-cpt-selectedworks' ),
		'not_found_in_trash'       => __( 'No posts found in Trash', 'kebbet-cpt-selectedworks' ),
		'featured_image'           => __( 'Post image', 'kebbet-cpt-selectedworks' ),
		'set_featured_image'       => __( 'Set post image', 'kebbet-cpt-selectedworks' ),
		'remove_featured_image'    => __( 'Remove post image', 'kebbet-cpt-selectedworks' ),
		'use_featured_image'       => __( 'Use as post image', 'kebbet-cpt-selectedworks' ),
		'insert_into_item'         => __( 'Insert into item', 'kebbet-cpt-selectedworks' ),
		'uploaded_to_this_item'    => __( 'Uploaded to this post', 'kebbet-cpt-selectedworks' ),
		'items_list'               => __( 'Items list', 'kebbet-cpt-selectedworks' ),
		'items_list_navigation'    => __( 'Items list navigation', 'kebbet-cpt-selectedworks' ),
		'filter_items_list'        => __( 'Filter items list', 'kebbet-cpt-selectedworks' ),
		'item_published'           => __( 'Post published', 'kebbet-cpt-selectedworks' ),
		'item_published_privately' => __( 'Post published privately', 'kebbet-cpt-selectedworks' ),
		'item_reverted_to_draft'   => __( 'Post reverted to Draft', 'kebbet-cpt-selectedworks' ),
		'item_scheduled'           => __( 'Post scheduled', 'kebbet-cpt-selectedworks' ),
		'item_updated'             => __( 'Post updated', 'kebbet-cpt-selectedworks' ),
		// 5.7 + 5.8
		'filter_by_date'           => __( 'Filter posts by date', 'kebbet-cpt-selectedworks' ),
		'item_link'                => __( 'Posts link', 'kebbet-cpt-selectedworks' ),
		'item_link_description'    => __( 'A link to a selected work post', 'kebbet-cpt-selectedworks' ),
	);

	$supports_args = array(
		// 'editor',
		'title',
		'page-attributes',
	);

	if ( true === THUMBNAIL ) {
		$supports_args = array_merge( $supports_args, array( 'thumbnail' ) );
	}

	$rewrite_args      = array(
		'slug'       => SLUG,
		'with_front' => false,
		'pages'      => false,
		'feeds'      => true,
	);
	$capabilities_args = \cpt\kebbet\selectedworks\roles\capabilities();
	$post_type_args    = array(
		'label'               => __( 'Selected works post type', 'kebbet-cpt-selectedworks' ),
		'description'         => __( 'Custom post type for selected works', 'kebbet-cpt-selectedworks' ),
		'labels'              => $labels_args,
		'supports'            => $supports_args,
		'taxonomies'          => array(),
		'hierarchical'        => true,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => MENUPOS,
		'menu_icon'           => 'dashicons-' . ICON,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'rewrite'             => $rewrite_args,
		'capabilities'        => $capabilities_args,
		// 'template'            => array( array( 'core/quote', array( 'className' => 'is-selected-work' ) ) ),
		'template_lock'       => 'all',
		// Adding map_meta_cap will map the meta correctly.
		'show_in_rest'        => true,
		'map_meta_cap'        => true,
	);
	register_post_type( POSTTYPE, $post_type_args );
}

/**
 * Enqueue plugin scripts and styles.
 *
 * @since 1.2.0
 *
 * @param string $page The page/file name.
 * @return void
 */
function enqueue_scripts( $page ) {
	$assets_pages = array(
		'index.php',
	);
	if ( in_array( $page, $assets_pages, true ) || 'edit-' . POSTTYPE === get_current_screen()->id ) {
		wp_enqueue_style( POSTTYPE . '_scripts', plugin_dir_url( __FILE__ ) . 'assets/css/style.css', array(), '1.2.0' );
	}
}

/**
 * Add the fields.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/acf-fields.php';

/**
 * Add the content to the `At a glance`-widget.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/at-a-glance.php';

/**
 * Adds and modifies the admin columns for the post type.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/admin-columns.php';

/**
 * Adds admin messages for the post type.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/admin-messages.php';

/**
 * Adjust roles and capabilities for post type
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/roles.php';
