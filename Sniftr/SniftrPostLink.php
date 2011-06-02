<?php

require_once 'Sniftr/SniftrPost.php';

/**
 * @package   Sniftr
 * @copyright 2011 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class SniftrPostLink extends SniftrPost
{
	// {{{ public function getBody()

	public function getBody()
	{
		$text = 'link-text';
		$description = 'link-description';
		$url = 'link-url';

		ob_start();
		echo '<strong><a href="'.$this->$url.'">'.$this->$text.'</a></strong>';

		if (isset($this->$description) && $this->$description != '') {
			echo '<p>'.$this->$description.'</p>';
		}

		return ob_get_clean();
	}

	// }}}
	// {{{ public function getTitle()

	public function getTitle()
	{
		$link = 'link-text';
		if (isset($this->$link) && $this->$link != '') {
			return $this->$link;
		}

		return Sniftr::_('Link');
	}

	// }}}
}

?>
