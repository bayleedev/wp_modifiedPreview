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
		'admin_menu' => array(
			'method' => 'setupAdminMenu',
			'priority' => 10,
			'args' => 1,
		),
		'post_link' => array(
			'method' => 'postLink',
			'priority' => 10,
			'args' => 3,
		),
		'page_link' => array(
			'method' => 'pageLink',
			'priority' => 10,
			'args' => 3,
		),
	);

	/**
	 * Will iterate the static property $filterMap and apply those filters
	 */
	public function __construct() {
		foreach(self::$filterMap as $filter => $items) {
			add_filter($filter, array(__CLASS__, $items['method']), $items['priority'], $items['args']);
		}
	}

	/**
	 * The front hook for page links.
	 * Channels the request to self::postLink
	 * 
	 * @param string $url The predicted url of the post
	 * @param int $post The current post id
	 */
	public static function pageLink($url, $id, $sample) {
		// possibly a revision number somewhere in here?
		$post = &get_post($id);
		return self::postLink($url, $post);
	}

	/**
	 * Try and overwrite the current url of posts/pages.
	 * 
	 * @param string $url The predicted url of the post
	 * @param stdClass $post The current post contents
	 * @param bool $leavename Optional, defaults to false. Whether to keep post name or page name.
	 */
	public static function postLink($url, $post, $leavename = false) {
		if(in_array($post->post_status, array('draft', 'auto-draft', 'inherit'))) {
			$url = get_option(self::key, $url);
			foreach($post as $key => $value) {
				if(is_array($value)) {
					$value = implode(',', $value);
				}
				$url = str_replace('%' . $key . '%', (string)$value, $url);
			}
		}
		return $url;
	}

	/**
	 * Sets up the menu in the admin panel
	 * @return null
	 */
	public static function setupAdminMenu() {
		add_options_page('Modified Preview', 'Modified Preview', 'manage_options', self::url, array(__CLASS__, 'adminMenu'));
		return;
	}

	/**
	 * Gets the data to/from the view
	 */
	public static function adminMenu() {
		$key = self::key;
		$url = self::url;
		if (isset($_POST[$key])) {
			self::saveOption($key, $_POST[$key]);
		}
		self::render('settings', compact('key', 'url'));
		return;
	}

	/**
	 * Will save wp options
	 * 
	 * @param string $key
	 * @param mixed $value
	 */
	protected static function saveOption($key, $value) {
		$option_exists = (get_option($key, null) !== null);
		if ($option_exists) {
			update_option($key, $value);
		} else {
			add_option($key, $value);
		}
		return;
	}
}