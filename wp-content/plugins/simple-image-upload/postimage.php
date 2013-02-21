<?php
/*
Plugin Name: Simple Image Upload
Description: This mod integrates image hosting with WordPress
Version: 1.4.0
Requires at least: WP 3.0.0
Tested up to: WP 3.5
License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
Author: Sium
Author URI: http://postimage.org/
Plugin URI: http://postimage.org/mod.php
Last Modified: 18 December, 2012
*/

class postimage_header
{
	public static function postimage_get()
	{
		$postimage_js=plugins_url('simple-image-upload/wordpress-english.js');
		
		echo "<script type='text/javascript' src='{$postimage_js}' charset='utf-8'></script>\n";
	}
}

add_action('admin_head',array('postimage_header','postimage_get'));

?>