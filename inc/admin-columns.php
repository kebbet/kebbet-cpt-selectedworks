<?php
/**
 * Adds and modifies the admin columns for the post type.
 *
 * @package kebbet-cpt-selectedworks
 */

namespace cpt\kebbet\selectedworks\admincolumns;

use const cpt\kebbet\selectedworks\POSTTYPE;
use const cpt\kebbet\selectedworks\THUMBNAIL;

/**
 * Column orders (set image first)
 *
 * @param array $columns The columns in the table.
 * @return array $columns The columns, in the new order.
 */
function column_order( $columns ) {
	$n_columns = array();
	// Move thumbnail to before title column.
	$before = 'title';

	foreach ( $columns as $key => $column_value ) {
		if ( $key === $before && true === THUMBNAIL ) {
			$n_columns['thumbnail'] = '';
		}
		$n_columns[ $key ] = $column_value;
	}
	return $n_columns;
}
add_filter( 'manage_' . POSTTYPE . '_posts_columns', __NAMESPACE__ . '\column_order' );

/**
 * Add additional admin column.
 *
 * @param array $columns The existing columns.
 */
function set_admin_column_list( $columns ) {
	$columns['modified']  = __( 'Last modified', 'kebbet-cpt-selectedworks' );
	if ( true === THUMBNAIL ) {
		$columns['thumbnail'] = __( 'Post image', 'kebbet-cpt-selectedworks' );
	}
	return $columns;
}
add_filter( 'manage_' . POSTTYPE . '_posts_columns', __NAMESPACE__ . '\set_admin_column_list' );

/**
 * Add data to each row.
 *
 * @param string $column The column slug.
 * @param int    $post_id The post ID for the row.
 */
function populate_custom_columns( $column, $post_id ) {
	if ( 'modified' === $column ) {
		$format   = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
		$modified = get_the_modified_date( $format );
		if ( $modified ) {
			echo esc_html( $modified );
		}
	}
	if ( 'thumbnail' === $column && true === THUMBNAIL ) {
		$thumbnail = get_the_post_thumbnail(
			$post_id,
			'thumbnail',
			array()
		);
		if ( $thumbnail ) {
			echo $thumbnail;
		} else {
			echo __( 'No image is set.', 'kebbet-cpt-selectedworks' );
		}
	}
}
add_action( 'manage_' . POSTTYPE . '_posts_custom_column', __NAMESPACE__ . '\populate_custom_columns', 10, 2 );

/**
 * Make additional admin column sortable.
 *
 * @param array $columns The existing columns.
 */
function define_admin_sortable_columns( $columns ) {
	$columns['modified'] = 'modified';
	return $columns;
}
add_filter( 'manage_edit-' . POSTTYPE . '_sortable_columns', __NAMESPACE__ . '\define_admin_sortable_columns' );
