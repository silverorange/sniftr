<?php

require_once 'Sniftr/SniftrPost.php';

/**
 * @package   Sniftr
 * @copyright 2011 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class SniftrPostPhoto extends SniftrPost
{
	// {{{ public static properties

	public static $photo_dimension = 500;

	// }}}
	// {{{ public function getBody()

	public function getBody()
	{
		$url = 'photo-url';

		ob_start();

		foreach ($this->$url as $url) {
			if ($url['max-width'] == self::$photo_dimension) {
				echo '<img src="'.((string)$url).'" alt="" />';
				break;
			}
		}

		return ob_get_clean();
	}

	// }}}
	// {{{ public function getTitle()

	public function getTitle()
	{
		$caption = 'photo-caption';
		if (isset($this->$caption) && $this->$caption != '') {
			return $this->$caption;
		}

		return Sniftr::_('Photo');
	}

	// }}}
}

?>
