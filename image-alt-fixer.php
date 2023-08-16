<?php
/**
 * Image ALT Fixer
 *
 * @author    Antonio Lamorgese <antonio.lamorgese@gmail.com>
 * @copyright 2023 Antonio Lamorgese
 * @license   GNU General Public License v3.0
 * @link      https://github.com/antoniolamorgese/image-alt-fixer
 * @see       https://jeremyhixon.com/tool/wordpress-option-page-generator/
 */

/**
 * Plugin Name:        Image ALT Fixer
 * Plugin URI:         https://github.com/antoniolamorgese/image-alt-fixer
 * Description:        Image ALT Fixer automatically sets the ALT attribute content of all IMG and FIGURE tags, present in a post, with a keyphrase calculated based on the post content.
 * Author:             Antonio Lamorgese
 * Author URI:         http://www.phpcodewizard.it/antoniolamorgese/
 * Version:            1.0.0
 * License:            GNU General Public License v3.0
 * License URI:        https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:        image-alt-fixer
 * Domain Path:        /languages
 * GitHub Plugin URI:  https://github.com/antoniolamorgese/image-alt-fixer
 * Requires at least:  5.6
 * Tested up to:       6.3
 * Requires PHP:       5.6 or later
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 3, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Exit if called directly.
 */
if ( ! defined( 'ABSPATH' ) ) exit; 

 /**
 * Load Localisation files.
 *
 * Locales found in:
 * 	 - /wp-content/plugins/image-alt-fixer/languages/image-alt-fixer-LOCALE.mo
 */
load_plugin_textdomain( 'image-alt-fixer', "", dirname(plugin_basename(__FILE__)) . '/languages' );

/**
 * Create HTML code to include in the BODY tag.
 * Fixing all ALT property in the images HTML Tags
 */
if(!is_Admin()) {
	if(!is_front_page()){
		if(!function_exists('image_alt_fixer_add_Code_html_in_tag_body')) {
			function image_alt_fixer_add_Code_html_in_tag_body() {
				?>
					<!-- Image ALT Fixer Plugin -->
					<script>
						jQuery(document).ready(function(){
							// Get the content of the H1 tag
							var titleContent = jQuery("h1").text();
							if(titleContent != undefined) {
								// Iterate over all "IMG" elements
								var allImages = jQuery('img');
								allImages.each(function() {
									if((jQuery(this).prop("alt") === undefined) || (!jQuery(this).prop("alt"))) {
									   // If IMG doesn't have the ALT property, set it with the H1 tag
									   jQuery(this).prop("alt", titleContent);
									}
								});
								
								// Iterate over all "FIGURE" elements
								jQuery('figure').each(function() {
									captionFigure = jQuery(this).find('figcaption').text();
									if(captionFigure !== undefined) {
									   // Set the ALT property of the IMG tag with the content of the FIGCAPTION tag
									   jQuery(this).find('img').prop('alt', captionFigure);
									}
								});         
							}   					
						});	
					</script>
				<?php
			}	
			add_action('wp_footer', 'image_alt_fixer_add_Code_html_in_tag_body');
		}	
	}
}

