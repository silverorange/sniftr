<?php

namespace Silverorange\Autoloader;

$package = new Package('silverorange/sniftr');

$package->addRule(new Rule('', 'Sniftr'));

Autoloader::addPackage($package);

?>
