<?php

require_once 'PEAR/PackageFileManager2.php';

$version = '0.1.5';
$notes = <<<EOT
No release notes for you!
EOT;

$description =<<<EOT
Tumblr blog integration with Site package.
EOT;

$package = new PEAR_PackageFileManager2();
PEAR::setErrorHandling(PEAR_ERROR_DIE);

$result = $package->setOptions(
	array(
		'filelistgenerator' => 'svn',
		'simpleoutput'      => true,
		'baseinstalldir'    => '/',
		'packagedirectory'  => './',
		'dir_roles'         => array(
			'Sniftr'        => 'php',
			'locale'        => 'data',
			'www'           => 'data',
			'dependencies'  => 'data',
			'/'             => 'data',
		),
	)
);

$package->setPackage('Sniftr');
$package->setSummary('Tumblr blog integration for Site package.');
$package->setDescription($description);
$package->setChannel('pear.silverorange.com');
$package->setPackageType('php');
$package->setLicense('LGPL', 'http://www.gnu.org/copyleft/lesser.html');

$package->setReleaseVersion($version);
$package->setReleaseStability('alpha');
$package->setAPIVersion('0.1.0');
$package->setAPIStability('alpha');
$package->setNotes($notes);

$package->addIgnore('package.php');

$package->addMaintainer(
	'lead',
	'gauthierm',
	'Mike Gauthier',
	'mike@silverorange.com'
);

$package->addReplacement(
	'Sniftr/Sniftr.php',
	'pear-config',
	'@DATA-DIR@',
	'data_dir'
);

$package->setPhpDep('5.1.5');
$package->setPearinstallerDep('1.4.0');
$package->addPackageDepWithChannel(
	'required',
	'Site',
	'pear.silverorange.com',
	'1.5.25'
);
$package->addExtensionDep('required', 'curl');
$package->addExtensionDep('required', 'simplexml');

$package->generateContents();

if (isset($_GET['make']) || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
	$package->writePackageFile();
} else {
	$package->debugPackageFile();
}

?>
