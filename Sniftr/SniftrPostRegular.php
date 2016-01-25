<?php

require_once 'Sniftr/SniftrPost.php';

/**
 * @package   Sniftr
 * @copyright 2011-2016 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class SniftrPostRegular extends SniftrPost
{
	// {{{ public function getBody()

	public function getBody()
	{
		return $this->element->{'regular-body'};
	}

	// }}}
	// {{{ public function getTitle()

	public function getTitle()
	{
		if (isset($this->element->{'regular-title'}) &&
			$this->element->{'regular-title'} != '') {
			return $this->element->{'regular-title'};
		}

		return Sniftr::_('Untitled');
	}

	// }}}
}

?>
