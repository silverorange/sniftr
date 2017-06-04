<?php

/**
 * @package   Sniftr
 * @copyright 2011-2016 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
abstract class SniftrPost
{
	// {{{ protected properties

	/**
	 * @var SimpleXMLElement
	 */
	protected $element;

	/**
	 * @var integer
	 */
	protected $width = 400;

	// }}}
	// {{{ public static function factory()

	public static function factory(SimpleXMLElement $element)
	{
		$type = $element['type'];

		switch ($type) {
		case 'audio' :
			$class = 'SniftrPostAudio';
			break;
		case 'conversation' :
			$class = 'SniftrPostConversation';
			break;
		case 'link' :
			$class = 'SniftrPostLink';
			break;
		case 'photo' :
			$class = 'SniftrPostPhoto';
			break;
		case 'quote' :
			$class = 'SniftrPostQuote';
			break;
		case 'video' :
			$class = 'SniftrPostVideo';
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

	/**
	 * @param SimpleXMLElement|SniftrPost $element
	 */
	public function __construct($element)
	{
		// get specific Sniftr post class
		$class = get_parent_class($this);
		while (strncmp('Sniftr', $class, 6) !== 0) {
			$class = get_parent_class($class);
		}

		if ($element instanceof $class) {
			$element = $element->element;
			if (!($element instanceof SimpleXMLElement)) {
				throw new InvalidArgumentException(
					'If using the copy constructor, the passed post must '.
					'already have an XML element associated with it.');
			}
		}

		if (!($element instanceof SimpleXMLElement)) {
			throw new InvalidArgumentException(sprintf(
				'The $element must be either a %s or a '.
				'SimpleXMLElement.', $class));
		}

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
		return new SwatDate('@'.$ts, new DateTimeZone('UTC'));
	}

	// }}}
	// {{{ public function setWidth()

	public function setWidth($width)
	{
		$this->width = $width;
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
