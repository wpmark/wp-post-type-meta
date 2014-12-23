<?php
/**
 * function wpptm_add_submenu_page()
 * add a submenu item labelled 'Meta Info' to each public post
 * type (filterable)
 */
function wpptm_add_submenu_page() {

	/* get a list of the post types */
	$post_types = wpptm_get_post_types();

	/* loop through each post type */
	foreach( $post_types as $post_type => $post_type_obj ) {

		/* add the menu item */
		$parent_slug = 'edit.php?post_type='.$post_type;
		$page_title  = $post_type_obj->labels->name . ' metainfo';
		$menu_title  = $post_type_obj->labels->name . ' Meta';
		$capability  = $post_type_obj->cap->edit_posts;
		$menu_slug	 = $post_type_obj->name . '-metainfo';
		$function    = 'wpptm_metainfo_content';

		add_submenu_page(
			$parent_slug,
			$page_title,
			$menu_title,
			$capability,
			$menu_slug,
			$function
		);

	}
}

add_action( 'admin_menu', 'wpptm_add_submenu_page' );