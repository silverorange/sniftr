<?php

require_once 'Sniftr/SniftrPost.php';

/**
 * @package   Sniftr
 * @copyright 2011 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class SniftrPostRegular extends SniftrPost
{
	// {{{ public function getBody()

	public function getBody()
	{
		$body = 'regular-body';
		return $this->$body;
	}

	// }}}
	// {{{ public function getTitle()

	public function getTitle()
	{
		$title = 'regular-title';
		if (isset($this->$title) && $this->$title != '') {
			return $this->$title;
		}

		return Sniftr::_('Untitled');
	}

	// }}}
}

?>
