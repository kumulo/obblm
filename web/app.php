<?php
use Symfony\Component\HttpFoundation\Request;
require __DIR__.'/../vendor/autoload.php';
if (PHP_VERSION_ID < 70000) {
    include_once __DIR__.'/../var/bootstrap.php.cache';
}
$kernel = new AppKernel('prod', false);
Request::setTrustedProxies(['192.0.0.1', '10.0.0.0/8'], Request::HEADER_X_FORWARDED_ALL);
if (PHP_VERSION_ID < 70000) {
    $kernel->loadClassCache();
}
//$kernel = new AppCache($kernel);
// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
