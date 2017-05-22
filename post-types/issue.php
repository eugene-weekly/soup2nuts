<?php

function issue_init() {
	register_post_type( 'issue', array(
		'labels'            => array(
			'name'                => __( 'Issues', 'soup2nuts' ),
			'singular_name'       => __( 'Issue', 'soup2nuts' ),
			'all_items'           => __( 'All Issues', 'soup2nuts' ),
			'new_item'            => __( 'New Issue', 'soup2nuts' ),
			'add_new'             => __( 'Add New', 'soup2nuts' ),
			'add_new_item'        => __( 'Add New Issue', 'soup2nuts' ),
			'edit_item'           => __( 'Edit Issue', 'soup2nuts' ),
			'view_item'           => __( 'View Issue', 'soup2nuts' ),
			'search_items'        => __( 'Search Issues', 'soup2nuts' ),
			'not_found'           => __( 'No Issues found', 'soup2nuts' ),
			'not_found_in_trash'  => __( 'No Issues found in trash', 'soup2nuts' ),
			'parent_item_colon'   => __( 'Parent Issue', 'soup2nuts' ),
			'menu_name'           => __( 'Issues', 'soup2nuts' ),
		),
		'public'            => false,
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'supports'          => array( 'title', 'editor', 'thumbnail'  ),
		'has_archive'       => true,
		'rewrite'           => true,
		'query_var'         => true,
		'menu_icon'         => 'dashicons-welcome-widgets-menus',
		'show_in_rest'      => true,
		'rest_base'         => 'issue',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'issue_init' );

function issue_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['issue'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Issue updated. <a target="_blank" href="%s">View Issue</a>', 'soup2nuts'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'soup2nuts'),
		3 => __('Custom field deleted.', 'soup2nuts'),
		4 => __('Issue updated.', 'soup2nuts'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Issue restored to revision from %s', 'soup2nuts'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Issue published. <a href="%s">View Issue</a>', 'soup2nuts'), esc_url( $permalink ) ),
		7 => __('Issue saved.', 'soup2nuts'),
		8 => sprintf( __('Issue submitted. <a target="_blank" href="%s">Preview Issue</a>', 'soup2nuts'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Issue scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Issue</a>', 'soup2nuts'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Issue draft updated. <a target="_blank" href="%s">Preview Issue</a>', 'soup2nuts'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'issue_updated_messages' );
