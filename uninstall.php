<?php
/**
 * Image ALT Fixer
 *
 * Uninstalling deletes options.
 *
 */
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit();

// Delete option plugin
if (is_multisite()) {
	$blogs = wp_list_pluck( get_sites(), 'blog_id' );
	if ($blogs) {
		foreach($blogs as $blog) {
			switch_to_blog($blog['blog_id']);
			delete_option( 'image_alt_fixer_option_name' );
		}
		restore_current_blog();
	}
} else {	
	delete_option( 'image_alt_fixer_option_name' );
}
