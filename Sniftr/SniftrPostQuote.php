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
		$text = 'quote-text';
		$source = 'quote-source';

		ob_start();
		echo '<em>“'.$this->$text.'”</em>';

		if (isset($this->$source) && $this->$source != '') {
			echo '<br />'.$this->$source;
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
