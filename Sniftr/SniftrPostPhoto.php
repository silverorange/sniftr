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
		ob_start();

		foreach ($this->element->{'photo-url'} as $url) {
			if ($url['max-width'] == self::$photo_dimension) {
				$image_tag = new SwatHtmlTag('img');
				$image_tag->src = (string)$url;
				$image_tag->alt = '';
				$image_tag->display();
				break;
			}
		}

		return ob_get_clean();
	}

	// }}}
	// {{{ public function getTitle()

	public function getTitle()
	{
		if (isset($this->element->{'photo-caption'}) &&
			$this->element->{'photo-caption'} != '') {
			return $this->element->{'photo-caption'};
		}

		return Sniftr::_('Photo');
	}

	// }}}
}

?>
