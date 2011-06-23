<?php

require_once 'Sniftr/SniftrPost.php';

/**
 * @package   Sniftr
 * @copyright 2011 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class SniftrPostPhoto extends SniftrPost
{
	// {{{ public function getBody()

	public function getBody()
	{
		$best_url = null;
		$best_delta = null;
		$best_width = null;
		foreach ($this->element->{'photo-url'} as $url) {
			$max_width = (isset($url['max-width'])) ?
				$url['max-width'] : 400;

			if ($best_url === null) {
				$best_url = (string)$url;
				$best_width = $max_width;
				$best_delta = abs($max_width - $this->width);
			} elseif (abs($max_width - $this->width) < $best_delta ||
				($best_width > $this->width && $max_width <= $this->width)) {
				$best_url = (string)$url;
				$best_width = $max_width;
				$best_delta = abs($max_width - $this->width);
			}
		}

		ob_start();

		$image_tag = new SwatHtmlTag('img');
		$image_tag->src = $best_url;
		$image_tag->alt = $this->getTitle();
		$image_tag->display();

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
}

?>
