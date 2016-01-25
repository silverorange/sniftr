<?php

require_once 'Sniftr/SniftrPost.php';

/**
 * @package   Sniftr
 * @copyright 2011-2016 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class SniftrPostConversation extends SniftrPost
{
	// {{{ public function getBody()

	public function getBody()
	{
		ob_start();

		foreach ($this->element->conversation->line as $line) {
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
		if (isset($this->element->{'conversation-title'}) &&
			$this->element->{'conversation-title'} != '') {
			return $this->element->{'conversation-title'};
		}

		return Sniftr::_('Conversation');
	}

	// }}}
}

?>
