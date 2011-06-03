<?php

require_once 'Sniftr/SniftrPost.php';

/**
 * @package   Sniftr
 * @copyright 2011 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class SniftrPostVideo extends SniftrPost
{
	// {{{ public function getBody()

	public function getBody()
	{
		return $this->element->{'video-player'};
	}

	// }}}
	// {{{ public function getTitle()

	public function getTitle()
	{
		if (isset($this->element->{'video-caption'}) &&
			$this->element->{'video-caption'} != '') {
			return strip_tags($this->element->{'video-caption'});
		}

		return Sniftr::_('Untitled Video');
	}

	// }}}
}

?>
