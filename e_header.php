<?php
/**
 * Testimonials plugin for e107 v2.
 *
 * @file
 * e_header handler
 */

if(!defined('e107_INIT'))
{
	exit;
}


/**
 * Class testimonials_e_header.
 */
class testimonials_e_header
{

	private $plugPrefs = null;

	function __construct()
	{
		$this->plugPrefs = e107::getPlugConfig('testimonials')->getPref();

		self::include_components();
	}

	/**
	 * Include necessary CSS and JS files.
	 * Only loads assets when the testimonials menu is active on the current page
	 * or when viewing the testimonials page directly.
	 */
	function include_components()
	{
		// Always load on the testimonials page itself.
		$isTestimonialsPage = (strpos(e_REQUEST_URI, 'testimonials') !== false);

		// Check if testimonials_menu is enabled.
		$menuActive = e107::getDb()->count('menus', '(*)', "menu_name = 'testimonials_menu' AND menu_location > 0");

		if($isTestimonialsPage || $menuActive)
		{
			e107::css('testimonials', 'css/testimonials.css');
			e107::js('testimonials', 'js/testimonials.js', 'jquery');
		}
	}

}


// Class instantiation.
new testimonials_e_header;
