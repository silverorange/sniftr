<?php

require_once 'Sniftr/SniftrPost.php';

/**
 * @package   Sniftr
 * @copyright 2011 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class SniftrPostPhoto extends SniftrPost
{
	// {{{ protected properties

	protected $photo_width = 400;

	// }}}
	// {{{ public function getBody()

	public function getBody()
	{
		ob_start();

		foreach ($this->element->{'photo-url'} as $url) {
			if ($url['max-width'] <= $this->photo_width) {
				$image_tag = new SwatHtmlTag('img');
				$image_tag->src = (string)$url;
				$image_tag->alt = $this->getTitle();
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
			return strip_tags($this->element->{'photo-caption'});
		}

		return Sniftr::_('Photo');
	}

	// }}}
	// {{{ public function setPhotoWidth()

	public function setPhotoWidth($width)
	{
		$this->photo_width = $width;
	}

	// }}}
}

?>
