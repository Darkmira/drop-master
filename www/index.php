<?php

ini_set('display_errors', 0);

$loader = require_once '../vendor/autoload.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$app = new RestApiApplication([
    'project.root' => dirname(__DIR__),
    'env' => 'prod',
]);

$app['http_cache']->run();
