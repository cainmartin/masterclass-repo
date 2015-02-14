<?php

session_start();

$path = realpath(__DIR__ . '/..');
require_once $path . '/vendor/autoload.php';

// We are using a closure here because services need to be objects
$config = function() use ($path) {
    return require ($path . '/Config/config.php');
};

$configuration = require $path . '/Config/config.php';

$diContainerBuilder = new Aura\Di\ContainerBuilder();
$di = $diContainerBuilder->newInstance(['config' => $config], $configuration['config_classes']);

$framework = $di->newInstance('Masterclass\FrontController\MasterController');
echo $framework->execute();