<?php

require_once 'Site/SiteCommandLineApplication.php';
require_once 'Site/SiteConfigModule.php';
require_once 'Site/SiteMemcacheModule.php';
require_once 'Sniftr/Sniftr.php';
require_once 'Sniftr/SniftrReader.php';

/**
 * @pacakge   Sniftr
 * @copyright 2011 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class SniftrUpdater extends SiteCommandLineApplication
{
	// {{{ public function run()

	public function run()
	{
		$this->initModules();
		$this->parseCommandLineArguments();

		$this->output(
			sprintf(
				"Updating cache for blog %s ... ",
				$this->config->sniftr->tumblr_username
			),
			SiteCommandLineApplication::VERBOSITY_ALL
		);

		$reader = new SniftrReader(
			$this,
			$this->config->sniftr->tumblr_username
		);
		$posts = $reader->getPostsAndForceCacheUpdate();

		$this->output(
			"done\n",
			SiteCommandLineApplication::VERBOSITY_ALL
		);
	}

	// }}}
	// {{{ protected function getDefaultModuleList()

	protected function getDefaultModuleList()
	{
		return array(
			'config'   => 'SiteConfigModule',
			'memcache' => 'SiteMemcacheModule',
		);
	}

	// }}}
	// {{{ protected function addConfigDefinitions()

	/**
	 * Adds configuration definitions to the config module of this application
	 *
	 * @param SiteConfigModule $config the config module of this application to
	 *                                  witch to add the config definitions.
	 */
	protected function addConfigDefinitions(SiteConfigModule $config)
	{
		parent::addConfigDefinitions($config);
		$config->addDefinitions(Sniftr::getConfigDefinitions());
	}

	// }}}
	// {{{ protected function configure()

	/**
	 * Configures modules of this application before they are initialized
	 *
	 * @param SiteConfigModule $config the config module of this application to
	 *                                  use for configuration other modules.
	 */
	protected function configure(SiteConfigModule $config)
	{
		parent::configure($config);

		if (isset($config->exceptions->log_location)) {
			SwatException::setLogger(
				new SiteExceptionLogger(
					$config->exceptions->log_location,
					$config->exceptions->base_uri
				)
			);
		}

		if (isset($config->errors->log_location)) {
			SwatError::setLogger(
				new SiteErrorLogger(
					$config->errors->log_location,
					$config->errors->base_uri
				)
			);
		}

		if ($config->date->time_zone !== null) {
			$this->default_time_zone =
				new HotDateTimeZone($config->date->time_zone);
		}

		$this->default_locale = $config->i18n->locale;

		setlocale(LC_ALL, $config->i18n->locale.'.UTF-8');

		$this->memcache->server = $config->memcache->server;
		$this->memcache->app_ns = $config->memcache->app_ns;
	}

	// }}}
}

?>
