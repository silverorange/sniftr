<?php

/**
 * @package   Sniftr
 * @copyright 2011-2016 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class SniftrPostVideo extends SniftrPost
{
	// {{{ public function getBody()

	public function getBody()
	{
		$best_player = null;
		$best_delta = null;
		$best_width = null;
		foreach ($this->element->{'video-player'} as $player) {
			$max_width = (isset($player['max-width'])) ?
				$player['max-width'] : 400;

			if ($best_player === null) {
				$best_player = $player;
				$best_width = $max_width;
				$best_delta = abs($max_width - $this->width);
			} elseif (abs($max_width - $this->width) < $best_delta ||
				($best_width > $this->width &&
				$max_width <= $this->width)) {
				$best_player = $player;
				$best_width = $max_width;
				$best_delta = abs($max_width - $this->width);
			}
		}

		return $best_player;
	}

	// }}}
	// {{{ public function getTitle()

	public function getTitle()
	{
		if (isset($this->element->{'video-caption'}) &&
			$this->element->{'video-caption'} != '') {
			return strip_tags($this->element->{'video-caption'});
		}

		return Sniftr::_('Untitled Video');
	}

	// }}}
}

?>
