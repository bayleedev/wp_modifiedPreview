<?php

class previewCore {

	/**
	 * Will render a view
	 */
	public static function render($view, $args = array()) {
		extract($args);
		include(__DIR__ . '/../views/' . $view . '.html.php');
	}
}