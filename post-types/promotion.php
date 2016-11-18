<?php

function promotion_init() {
	register_post_type( 'promotion', array(
		'labels'            => array(
			'name'                => __( 'Promotions', 'soup2nuts' ),
			'singular_name'       => __( 'Promotion', 'soup2nuts' ),
			'all_items'           => __( 'All Promotions', 'soup2nuts' ),
			'new_item'            => __( 'New Promotion', 'soup2nuts' ),
			'add_new'             => __( 'Add New', 'soup2nuts' ),
			'add_new_item'        => __( 'Add New Promotion', 'soup2nuts' ),
			'edit_item'           => __( 'Edit Promotion', 'soup2nuts' ),
			'view_item'           => __( 'View Promotion', 'soup2nuts' ),
			'search_items'        => __( 'Search Promotions', 'soup2nuts' ),
			'not_found'           => __( 'No Promotions found', 'soup2nuts' ),
			'not_found_in_trash'  => __( 'No Promotions found in trash', 'soup2nuts' ),
			'parent_item_colon'   => __( 'Parent Promotion', 'soup2nuts' ),
			'menu_name'           => __( 'Promotions', 'soup2nuts' ),
		),
		'public'            => true,
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'supports'          => array( 'title', 'editor', 'thumbnail' ),
		'has_archive'       => true,
		'rewrite'           => true,
		'query_var'         => true,
		'menu_icon'         => 'dashicons-awards',
		'show_in_rest'      => true,
		'rest_base'         => 'promotion',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'promotion_init' );

function promotion_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['promotion'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Promotion updated. <a target="_blank" href="%s">View Promotion</a>', 'soup2nuts'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'soup2nuts'),
		3 => __('Custom field deleted.', 'soup2nuts'),
		4 => __('Promotion updated.', 'soup2nuts'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Promotion restored to revision from %s', 'soup2nuts'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Promotion published. <a href="%s">View Promotion</a>', 'soup2nuts'), esc_url( $permalink ) ),
		7 => __('Promotion saved.', 'soup2nuts'),
		8 => sprintf( __('Promotion submitted. <a target="_blank" href="%s">Preview Promotion</a>', 'soup2nuts'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Promotion scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Promotion</a>', 'soup2nuts'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Promotion draft updated. <a target="_blank" href="%s">Preview Promotion</a>', 'soup2nuts'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'promotion_updated_messages' );
