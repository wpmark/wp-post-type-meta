<?php
/*
Plugin Name: WP Post Type Meta
Description: Adds an admin sub menu to allow for a post type description to be added, ideal for showing at the top of the custom post type archive page. Through extensibility features the plugin also allows other post type meta information to be stored on a per post type basis.
Version:     0.9.5
Author:      Mark Wilkinson
Author URI:  http://markwilkinson.me
Text Domain: wpptm
License:     GPL v2 or later

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

/*
 * include the necessary functions files for the plugin
 */
require_once dirname( __FILE__ ) . '/functions/meta-settings.php';
require_once dirname( __FILE__ ) . '/functions/admin-menus.php';
require_once dirname( __FILE__ ) . '/functions/admin-menus-content.php';
require_once dirname( __FILE__ ) . '/functions/meta-update.php';

/**
 * Function wpptm_get_post_types()
 * helper function to get all the post types (filterable)
 */
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

/**
 * Function wpptm_description()
 * remove post types from having a description
 */
function wpptm_remove_pages_post_type( $post_types ) {

    unset( $post_types[ 'page' ] );
    return $post_types;
    
}

add_filter( 'wpptm_enabled_post_types', 'wpptm_remove_pages_post_type' );

/**
 * function wpptm_get_field()
 * this function gets a given field id for a post type
 * @param (string) $field is the name of the field to return - this is the id when declaring a field with the filter
 * @param (string) $post_type is the post type to return the field for - defaults to current queried post type.
 * @param (string) $default is the value to return if no saved value is returned - defaults to nothing
 * @return the value stored for that field.
 */
function wpptm_get_field( $field, $post_type = '', $default = '' ) {
	
	/* check we have a post type */
	if( empty( $post_type ) ) {
		
		/* use the currently queried post type */
		$post_type = get_query_var( 'post_type' );
		
	}
	
	/* get the fields for this post type from options */
	$options = get_option('wpptm_' . $post_type, array() );
	
	/* check if the field exists in the array */
	if( array_key_exists( $field, $options ) ) {
		
		/* get the desired field from the returned post type data */
		$setting = $options[ $field ];
		
		/* check we have a field to return */
		if( empty( $setting ) ) {
			
			/* do we have a default to return */
			if( $default != '' ) {
				
				/* set the default to be returned */
				$setting = $default;
			
			/* no setting or default */
			} else {
				
				/* set to false */
				$setting = false;
				
			}
	
		}
		
	} else {
		
		/* set the default to be returned */
		$setting = $default;
		
	}
	
	/* return our field */
	return apply_filters( 'wpptm_get_field', esc_attr( $setting ), $field, $post_type );
	
}