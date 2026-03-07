<?php
/**
 * Testimonials plugin for e107 v2.
 *
 * @file
 * Class to render Testimonials menu.
 */

if(!defined('e107_INIT'))
{
	exit;
}

// [PLUGINS]/testimonials/languages/[LANGUAGE]/[LANGUAGE]_front.php
e107::lan('testimonials', false, true);

// Fallback: if language file didn't load (missing translation), load English directly.
if(!defined('LAN_TESTIMONIALS_01'))
{
	$fallback = e_PLUGIN . 'testimonials/languages/English/English_front.php';
	if(is_readable($fallback))
	{
		include_once($fallback);
	}
}

class testimonials_menu
{

	/**
	 * Store plugin preferences.
	 *
	 * @var mixed|null
	 */
	private $plugPrefs = null;


	/**
	 * Store testimonial items.
	 *
	 * @var array
	 */
	private $testimonials = array();


	/**
	 * Constructor.
	 */
	function __construct()
	{
		// Get plugin preferences.
		$this->plugPrefs = e107::getPlugConfig('testimonials')->getPref();

		$this->renderMenu();
	}


	/**
	 * Render testimonials menu.
	 */
	function renderMenu()
	{
		$this->getItems();

		if(empty($this->testimonials))
		{
			return; // No testimonials to display.
		}

		$template = e107::getTemplate('testimonials');
		$sc = e107::getScBatch('testimonials', true);
		$tp = e107::getParser();

		$totalItems = count($this->testimonials);

		$sc->setVars(array('count' => $totalItems));
		$text = $tp->parseTemplate($template['menu_header'], true, $sc);
		foreach($this->testimonials as $key => $val)
		{
			$val['active'] = ((int) $key === 0);
			$val['count'] = $totalItems; // Preserve count for indicators shortcode.
			$sc->setVars($val);
			$text .= $tp->parseTemplate($template['menu_body'], true, $sc);
		}
		// Restore count for footer (indicators need it).
		$sc->setVars(array('count' => $totalItems));
		$text .= $tp->parseTemplate($template['menu_footer'], true, $sc);

		e107::getRender()->tablerender(LAN_TESTIMONIALS_01, $text);
		unset($text);
	}


	/**
	 * Select messages from database.
	 */
	function getItems()
	{
		$db = e107::getDb('testimonials');

		$query = 'SELECT t.*, u.user_id, u.user_name FROM #testimonials AS t ';
		$query .= 'LEFT JOIN #user AS u ON SUBSTRING_INDEX(t.tm_name,".",1) = u.user_id ';
		$query .= 'WHERE t.tm_blocked = 0 ';
		$query .= 'ORDER BY rand() ';
		$query .= 'LIMIT 0, ' . (int) $this->plugPrefs['tm_menu_items'];

		$db->gen($query);

		while($row = $db->fetch())
		{
			$item = $row;

			list($tm_uid, $tm_nick) = explode(".", $row['tm_name'], 2);
			$item['user_name'] = $tm_nick;

			if (!empty($item['tm_url'])) {
				if (strpos($item['tm_url'], 'http') === FALSE) {
					$item['tm_url'] = 'http://' . $item['tm_url'];
				}
			}

			$this->testimonials[] = $item;
		}
	}
}


new testimonials_menu();
