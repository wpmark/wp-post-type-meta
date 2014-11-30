<?php
/**
 * Function wpptm_update_description()
 * Updates/saves the added description
 */
function wpptm_update_post_type_meta() {
		
	/* check we have some posted meta information */
	if( isset( $_POST[ 'wpptm_update_metainfo' ] ) ) {
	
		/* get the current post type */
		$post_type = $_GET[ 'post_type' ];
		
		/**
		 * build an array of wpptm options to output
		 * $hooked wpptm_add_description_setting - 10
		 */
		$wpptm_settings = apply_filters(
			'wpptm_settings',
			array()
		);
		
		/* check we have settings to update */
		if( ! empty( $wpptm_settings ) ) {
			
			/* loop through each setting added */
			foreach( $wpptm_settings as $setting ) {
				
				/* get the current saved values from options */
				$wpptm_options = get_option( 'wpptm_meta' );
				
				/* get the setting id */
				$setting_id = $post_type . '_' . $setting[ 'id' ];
				
				/* get the posted value for this setting */
				$posted_setting_id = $_POST[ $setting_id ];
				
				/* add our posted setting to the options array */
				$wpptm_options[ $setting_id ] = $posted_setting_id;

				/* update this setting */
				update_option( 'wpptm_meta', $wpptm_options );
				
			} // end loop through each setting
			
		} // end if have settings to update

		/* redirect the user to meta admin page with added query vars */
		wp_redirect(
			add_query_arg(
				array(
					'post_type' => $post_type,
					'page' => $post_type . '-metainfo',
					'updated' => 'true',
					'post_type' => $post_type
				),
				$wp_get_referer
			)
		);
		exit;

	}

}

add_action( 'init', 'wpptm_update_post_type_meta' );