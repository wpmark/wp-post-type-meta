<?php
/**
 * function wpptm_add_description_setting()
 * adds the post type description field to the post type meta admin page
 * @param (array) $settings is the current array of settings
 * @return (array) $settings is the newly modififed array of settings
 */
function wpptm_add_description_setting( $settings ) {
	
	/* add our description setting to the setting array */
	$settings[] = array(
		'type'=> 'wysiwyg',
		'label'=> 'Description',
		'id'=> 'description', // this is the option name where the setting is stored
		'textarea_rows' => 5,
		'media_buttons' => false,
		'class'=> 'description'
	);
	
	/* return the modified settings array */
	return $settings;
	
}

add_filter( 'wpptm_settings', 'wpptm_add_description_setting', 10 );