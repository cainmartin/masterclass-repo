<?php

session_start();

$path = realpath(__DIR__ . '/..');
require_once $path . '/vendor/autoload.php';

// We are using a closure here because services need to be objects
$config = function() use ($path) {
    return require ($path . '/config/config.php');
};

$diContainerBuilder = new Aura\Di\ContainerBuilder();
$di = $diContainerBuilder->newInstance(['config' => $config], ['Masterclass\Configuration\DiConfig', 'Masterclass\Configuration\RouterConfig']);

$framework = $di->newInstance('Masterclass\FrontController\MasterController');
echo $framework->execute();