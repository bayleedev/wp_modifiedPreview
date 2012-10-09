<?php
/*
Plugin Name: Modified Preview
Plugin URI: http://github.com/BlaineSch/wp_modifiedPreview
Description: Change the url of the preview button
Version: 0.1
Author: Blaine Schmeisser
Author URI: http://github.com/BlaineSch
*/

if ( ! class_exists( 'WP' ) ) {
	die();
}
require_once(__DIR__ . '/classes/previewChange.php');
new previewChange();