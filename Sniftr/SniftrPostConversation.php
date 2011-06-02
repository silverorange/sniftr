<?php

require_once 'Sniftr/SniftrPost.php';

/**
 * @package   Sniftr
 * @copyright 2011 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class SniftrPostConversation extends SniftrPost
{
	// {{{ public function getBody()

	public function getBody()
	{
		ob_start();

		foreach ($this->conversation->line as $line) {
			echo '<p>';
			echo '<strong>', $line['label'], '</strong> ', ((string)$line);
			echo '</p>';
		}

		return ob_get_clean();
	}

	// }}}
	// {{{ public function getTitle()

	public function getTitle()
	{
		$title = 'conversation-title';
		if (isset($this->$title) && $this->$title != '') {
			return $this->$title;
		}

		return Sniftr::_('Conversation');
	}

	// }}}
}

?>
