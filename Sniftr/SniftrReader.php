<?php

require_once 'Sniftr/SniftrPost.php';

/**
 * @package   Sniftr
 * @copyright 2011 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class SniftrReader
{
	// {{{ class constants

	const API_READ_ENDPOINT = 'http://%s.tumblr.com/api/read';

	// }}}
	// {{{ protected properties

	/**
	 * @var SiteApplication
	 */
	protected $app;

	// }}}
	// {{{ public function __construct()

	public function __construct(SiteApplication $app)
	{
		$this->app = $app;
	}

	// }}}
	// {{{ public function getPosts()

	public function getPosts()
	{
		$posts = array();

		$xml = $this->getXML();
		if ($xml != '') {
			$simple_xml = new SimpleXMLElement($xml);
			foreach ($simple_xml->posts->post as $post) {
				$posts[] = SniftrPost::factory($post);
			}
		}

		return $posts;
	}

	// }}}
	// {{{ public function getXML()

	protected function getXML()
	{
		$key = $this->getCacheKey();
		$xml = $this->app->getCacheValue($key);

		if ($xml === false) {
			$uri = sprintf(self::API_READ_ENDPOINT,
				$this->app->config->sniftr->tumblr_username);

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_URL, $uri);
			$xml = curl_exec($curl);
			$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			if ($status != 200) {
				$xml = '';
			} else {
				$this->app->addCacheValue($xml, $key, null, 600);
			}
		}

		return $xml;
	}

	// }}}
	// {{{ public function getCacheKey()

	protected function getCacheKey()
	{
		return 'tumblr-'.$this->app->config->sniftr->tumblr_username;
	}

	// }}}
}

?>
