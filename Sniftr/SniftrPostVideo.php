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
		$player = 'video-player';
		return $this->$player;
	}

	// }}}
	// {{{ public function getTitle()

	public function getTitle()
	{
		$caption = 'video-caption';
		if (isset($this->$caption) && $this->$caption != '') {
			return strip_tags($this->$caption);
		}

		return Sniftr::_('Untitled Video');
	}

	// }}}
}

?>
