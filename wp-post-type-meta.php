<?php
/*
Plugin Name: WP Post Type Meta
Description: Adds an admin sub menu to allows for a post type description to be added, and extensibility allows other post type meta information.
Version:     0.1
Author:      Mark Wilkinson
Author URI:  http://markwilkinson.me
Text Domain: wpptm
License:     GPL v2 or later
*/

/***************************************************************
* include the necessary functions files for the plugin
***************************************************************/
require_once dirname( __FILE__ ) . '/functions/meta-settings.php';
require_once dirname( __FILE__ ) . '/functions/admin-menus.php';
require_once dirname( __FILE__ ) . '/functions/admin-menus-content.php';
require_once dirname( __FILE__ ) . '/functions/meta-update.php';

/***************************************************************
* Function wpptm_description()
* helper function to get all the post types (filterable)
***************************************************************/
function wpptm_get_post_types() {

	$post_types = get_post_types(
		array(
			'public' => true,
			'show_ui' => true,
		),
		'objects'
	);

	/* allow post types to be filterable */
	$post_types = apply_filters( 'wpptm_enabled_post_types', $post_types );

	return $post_types;

}

/***************************************************************
* Function wpptm_description()
* remove post types from having a description
***************************************************************/
function wpptm_remove_pages_post_type( $post_types ) {

    unset( $post_types[ 'page' ] );
    return $post_types;
    
}

add_filter( 'wpptm_enabled_post_types', 'wpptm_remove_pages_post_type' );