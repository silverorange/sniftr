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
			$class = 'SniftrPostVideo';
			break;
		case 'link' :
			$class = 'SniftrPostVideo';
			break;
		case 'quote' :
			$class = 'SniftrPostVideo';
			break;
		case 'photo' :
			$class = 'SniftrPostVideo';
			break;
		case 'regular' :
			$class = 'SniftrPostVideo';
			break;
		}

		return new $class($element);
	}

	// }}}
	// {{{ public function __construct()

	public function __construct(SimpleXMLElement $element)
	{
		$this->element = $element;
	}

	// }}}
	// {{{ public function __get()

	public function __get($name)
	{
		return $this->element->$name;
	}

	// }}}
	// {{{ public function __isset()

	public function __isset($name)
	{
		return isset($this->element->$name);
	}

	// }}}
	// {{{ public function getType()

	public function getType()
	{
		return (string)$this->type;
	}

	// }}}
	// {{{ public function getLink()

	public function getLink()
	{
		$name = 'url-with-slug';
		return (string)$this->$name;
	}

	// }}}
	// {{{ public function getDate()

	public function getDate()
	{
		$name = 'unix-timestamp';
		$ts = (integer)$this->$name;
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
