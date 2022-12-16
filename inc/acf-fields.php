<?php
/**
 * Adds and modifies the admin columns for the post type.
 *
 * @package kebbet-cpt-selectedworks
 */

namespace cpt\kebbet\selectedworks\acf_fields;

if ( class_exists( 'ACF' ) ) :
	/**
	 * Add field group for post type meta data
	 *
	 * @return void
	 */
	function add_group() {
		acf_add_local_field_group( options() );
	}
	add_action( 'acf/init', __NAMESPACE__ . '\add_group' );

	/**
	 * Return the options for the field group
	 *
	 * @return array
	 */
	function options() {
		return array(
			'key'                   => 'group_63076c2d54dff',
			'title'                 => __( 'Relation to project', 'kebbet-cpt-selectedworks' ),
			'fields'                => array(
				array(
					'key'               => 'field_63076c382db1a',
					'label'             => 'Relation',
					'name'              => 'project_relation',
					'type'              => 'relationship',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'post_type'         => array(
						0 => 'project',
					),
					'taxonomy'          => '',
					'filters'           => array(
						0 => 'search',
					),
					'elements'          => '',
					'min'               => '',
					'max'               => 1,
					'return_format'     => 'object',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'selected-works',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => '',
			'show_in_rest'          => 0,
		);
	};
endif;
