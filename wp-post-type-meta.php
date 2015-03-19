<?php
/*
Plugin Name: WP Post Type Meta
Description: Adds an admin sub menu to allow for a post type description to be added, ideal for showing at the top of the custom post type archive page. Through extensibility features the plugin also allows other post type meta information to be stored on a per post type basis.
Version:     0.7
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
function wpptm_get_post_types( $output = 'objects' ) {

	$post_types = get_post_types(
		array(
			'show_ui' => true,
		),
		$output
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