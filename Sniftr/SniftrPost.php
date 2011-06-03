<?php

require_once 'HotDate/HotDateTimeZone.php';
require_once 'Swat/SwatDate.php';

/**
 * @package   Sniftr
 * @copyright 2011 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
abstract class SniftrPost
{
	// {{{ protected properties

	/**
	 * @var SimpleXMLElement
	 */
	protected $element;

	// }}}
	// {{{ public static function factory()

	public static function factory(SimpleXMLElement $element)
	{
		$type = $element['type'];

		switch ($type) {
		case 'video' :
			$class = 'SniftrPostVideo';
			break;
		case 'conversation' :
			$class = 'SniftrPostConversation';
			break;
		case 'link' :
			$class = 'SniftrPostLink';
			break;
		case 'quote' :
			$class = 'SniftrPostQuote';
			break;
		case 'photo' :
			$class = 'SniftrPostPhoto';
			break;
		case 'regular' :
		default:
			$class = 'SniftrPostRegular';
			break;
		}

		include_once 'Sniftr/'.$class.'.php';

		return new $class($element);
	}

	// }}}
	// {{{ public function __construct()

	public function __construct(SimpleXMLElement $element)
	{
		$this->element = $element;
	}

	// }}}
	// {{{ public function getType()

	public function getType()
	{
		return (string)$this->element['type'];
	}

	// }}}
	// {{{ public function getLink()

	public function getLink()
	{
		return (string)$this->element['url-with-slug'];
	}

	// }}}
	// {{{ public function getDate()

	public function getDate()
	{
		$ts = (integer)$this->element['unix-timestamp'];
		return new SwatDate('@'.$ts, new HotDateTimeZone('UTC'));
	}

	// }}}
	// {{{ abstract public function getBody()

	abstract public function getBody();

	// }}}
	// {{{ abstract public function getTitle()

	abstract public function getTitle();

	// }}}
}

?>
