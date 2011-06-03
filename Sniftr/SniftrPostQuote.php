<?php

require_once 'Sniftr/SniftrPost.php';

/**
 * @package   Sniftr
 * @copyright 2011 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class SniftrPostQuote extends SniftrPost
{
	// {{{ public function getBody()

	public function getBody()
	{
		ob_start();

		echo '<em>“', $this->element->{'quote-text'}, '”</em>';

		if (isset($this->element->{'quote-source'}) &&
			$this->element->{'quote-source'} != '') {
			echo '<br />', $this->element->{'quote-source'};
		}

		return ob_get_clean();
	}

	// }}}
	// {{{ public function getTitle()

	public function getTitle()
	{
		return Sniftr::_('Quote');
	}

	// }}}
}

?>
