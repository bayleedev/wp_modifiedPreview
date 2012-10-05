<?php
// Dependencies
require(__DIR__ . '/previewCore.php');

/**
 * The main class for the preview change library
 */
class previewChange extends previewCore {

	/**
	 * The key we use to save data in.
	 */
	const key = 'mp_previewURL';

	/**
	 * The expected url of the tab
	 */
	const url = 'modifiedPreviewSettings';

	/**
	 * The map of filters to apply.
	 * The key is the filter you want to hook onto.
	 * The value is the method of this object you wish to add.
	 */
	public static $filterMap = array(
		'preview_post_link' => 'previewPostLink',
		'admin_menu' => 'setupAdminMenu',
	);

	/**
	 * Will iterate the static property $filterMap and apply those filters
	 */
	public function __construct() {
		foreach(self::$filterMap as $filter => $method) {
			echo 'addingFilter: ' . $filter . '::' . $method . PHP_EOL;
			add_filter($filter, array($this, $method));
		}
	}

	/**
	 * Will parse the current link url for the given post
	 * 
	 * @return string The new preview link path
	 */
	public static function previewPostLink() {
		$url = get_option(self::key, 'http://google.com');

		$values = array_map('strval', (array)get_post($id));
		$keys = array_map(function($key) {
			return '%' . $key . '%';
		}, array_keys($values));

		return str_replace($keys, $values, $url);
	}

	/**
	 * Sets up the menu in the admin panel
	 * @return null
	 */
	public function setupAdminMenu() {
		add_options_page('Modified Preview', 'Modified Preview', 'manage_options', self::url, array($this, 'adminMenu'));
		return;
	}

	/**
	 * Gets the data to/from the view
	 */
	public function adminMenu() {
		$key = self::key;
		$url = self::url;
		if (isset($_POST[$key])) {
			$this->saveOption($key, $_POST[$key]);
		}
		$this->render('settings', compact('key', 'url'));
	}

	/**
	 * Will save wp options
	 * 
	 * @param string $key
	 * @param mixed $value
	 */
	protected function saveOption($key, $value) {
		$option_exists = (get_option($key, null) !== null);
		if ($option_exists) {
			update_option($key, $value);
		} else {
			add_option($key, $value);
		}
	}
}