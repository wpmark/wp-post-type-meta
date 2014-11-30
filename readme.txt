=== Plugin Name ===
Contributors: wpmarkuk
Donate link: http://markwilkinson.me/saythanks
Tags: custom post type, meta, options
Requires at least: 4.0
Tested up to: 4.0.1
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a sub menu for custom post types allowing the addition of a post type description and via extensibility other meta fields.

== Description ==

WP Post Type Meta adds a sub menu item underneath each custom post type for your site. By default this sub menu allows you to add a post type description, which can be used, for example, on post type archives.

The plugins extensible features allow developers to easily add additional fields to this sub menu in the form of select, textareas, wysiwyg, checkboxes and text inputs.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the download folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How do I output the post type description in template files? =

All post type meta fields are stored in the WordPress options table in the option named `wpptm_meta`. Therefore to output a custom post type description you can use the following:

`
<?php
	$description = get_option( ‘wpptm_meta’ );
	$description = $description[ ‘post_type_name_description’ ];
	echo wpautop( $description );
?>
`

= How do I add my own fields to the meta sub menu for a post type? =

This is achieved with the `wpptm_settings` filter. You can pass an array to this filter with your own settings, setting the type to either wysiwyg, checkbox, textarea, select or text. Below is an example of how you would add a select input:

`
<?php
function wpptm_add_select_input( $settings ) {
	
	/* add our setting to the settings array */
	$settings[] = array(
		'type'=> 'select',
		'label'=> 'A Select Box',
		'id'=> ‘selectbox’,
		'options' = array(
			array(
				'name' => 'Display Name One',
				'value' => '1'
			),
			array(
				'name' => 'Display Name Two',
				'value' => '2'
			)
		)
		'class'=> 'select_box_css_class'
	);
	
	/* return the modified settings array */
	return $settings;
	
}

add_filter( 'wpptm_settings', 'wpptm_add_select_input', 20 );
?>
`

In the above example if the custom post type was called `cpt_content` you would access this in template files like so:

`
<?php
	$option = get_option( ‘wpptm_meta’ );
	$option = $option[ ‘cpt_content_selectbox’ ];
	echo $option;
?>
`

== Screenshots ==

None yet!

== Changelog ==

= 0.1 =
* Initial commit to wp.org.

== Upgrade notice ==

Upgrade through the WordPress dashboard.