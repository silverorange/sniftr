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
	// {{{ protected function getXML()

	protected function getXML()
	{
		$cache_key  = $this->getCacheKey();
		$expiry_key = $this->getCacheExpiryKey();

		$expired = $this->app->getCacheValue($expiry_key);
		if ($expired === false) {
			// expiry key expired, check for updated content on Tumblr
			$xml = $this->getTumblrXML();
			if ($xml === false) {
				// Tumblr API is down, try long cached value
				$xml = $this->app->getCacheValue($cache_key);
				if ($xml === false) {
					// Tumblr API is down, but we have no cached value
					$xml = '';
				}
			} else {
				// update long cache with new Tumblr content
				$this->app->addCacheValue($xml, $cache_key, null, 7200);
			}
			// update expiry cache value
			$this->app->addCacheValue('1', $expiry_key, null, 300);
		} else {
			// expiry key not expired, check for long cached value
			$xml = $this->app->getCacheValue($cache_key);
			if ($xml === false) {
				// long cached version expired or does not exist, check
				// for content on Tumblr
				$xml = $this->getTumblrXML();
				if ($xml === false) {
					// Tumblr API is down, but we have no cached value
					$xml = '';
					$this->app->deleteCacheValue($expiry_key);
				} else {
					// update long cache with new Tumblr content
					$this->app->addCacheValue($xml, $cache_key, null, 7200);
				}
			}
		}

		return $xml;
	}

	// }}}
	// {{{ protected function getTumblrXML()

	protected function getTumblrXML()
	{
		$uri = sprintf(self::API_READ_ENDPOINT,
			$this->app->config->sniftr->tumblr_username);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_URL, $uri);
		$xml = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if ($status != 200) {
			$xml = false;
		}

		return $xml;
	}

	// }}}
	// {{{ protected function getCacheExpiryKey()

	protected function getCacheExpiryKey()
	{
		return 'tumblr-'.$this->app->config->sniftr->tumblr_username.'-expiry';
	}

	// }}}
	// {{{ protected function getCacheKey()

	protected function getCacheKey()
	{
		return 'tumblr-'.$this->app->config->sniftr->tumblr_username;
	}

	// }}}
}

?>
