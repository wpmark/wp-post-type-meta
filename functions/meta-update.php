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
			
		/* loop through each setting added */
		foreach( $_POST as $key => $value ) {
			
			/* if the key is either the post type or the save button */
			if( $key == 'wpptm_post_type' || $key == 'wpptm_update_metainfo' )
				continue;
			
			/* get the current saved values from options */
			$wpptm_options = get_option( 'wpptm_meta' );
							
			/* add our posted setting to the options array */
			$wpptm_options[ $key ] = $value;

			/* update this setting */
			update_option( 'wpptm_meta', $wpptm_options );
			
		} // end loop through each setting

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

add_action( 'admin_init', 'wpptm_update_post_type_meta', 99 );