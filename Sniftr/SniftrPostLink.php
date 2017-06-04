<?php

/**
 * @package   Sniftr
 * @copyright 2011-2016 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class SniftrPostLink extends SniftrPost
{
	// {{{ public function getBody()

	public function getBody()
	{
		ob_start();

		echo '<strong>';
		$anchor = new SwatHtmlTag('a');
		$anchor->href = $this->element->{'link-url'};
		$anchor->setContent($this->element->{'link-text'});
		$anchor->display();
		echo '</strong>';

		if (isset($this->element->{'link-description'}) &&
			$this->element->{'link-description'} != '') {
			echo '<p>', $this->element->{'link-description'}, '</p>';
		}

		return ob_get_clean();
	}

	// }}}
	// {{{ public function getTitle()

	public function getTitle()
	{
		if (isset($this->element->{'link-text'}) &&
			$this->element->{'link-text'} != '') {
			return $this->element->{'link-text'};
		}

		return Sniftr::_('Link');
	}

	// }}}
}

?>
