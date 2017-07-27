<?php

/**
 * @package   Sniftr
 * @copyright 2011-2016 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class SniftrPostAudio extends SniftrPost
{
	// {{{ public function getBody()

	public function getBody()
	{
		return $this->element->{'audio-player'};
	}

	// }}}
	// {{{ public function getTitle()

	public function getTitle()
	{
		if (isset($this->element->{'audio-caption'}) &&
			$this->element->{'audio-caption'} != '') {
			return strip_tags($this->element->{'audio-caption'});
		}

		return Sniftr::_('Untitled Audio');
	}

	// }}}
}

?>
