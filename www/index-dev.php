<?php

$loader = require_once '../vendor/autoload.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$app = new RestApiApplication([
    'project.root' => dirname(__DIR__),
    'env' => 'dev',
    'debug' => true,
]);

$app->run();
