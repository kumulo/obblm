<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

$loader->add('Legacy', realpath(__DIR__.'/../src/Bn/LigueLegacyBundle/src'));

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
