<?php

$di = new Aura\Di\Container(new \Aura\Di\Factory());

$di->params['Masterclass\FrontController\MasterController'] = [
    'container' => $di,
    'config' => $config
];

$di->params['Masterclass\Controller\Index'] = [
    'story' => $di->lazyNew('Masterclass\Model\Story'),
];

$di->params['MasterClass\Controller\Story'] = [
    'story' => $di->lazyNew('Masterclass\Model\Story'),
    'comment' => $di->lazyNew('Masterclass\Model\Comment'),
];

$di->params['MasterClass\Controller\Comment'] = [
    'comment' => $di->lazyNew('Masterclass\Model\Comment'),
];

$di->params['MasterClass\Controller\User'] = [
    'user' => $di->lazyNew('Masterclass\Model\User'),
];

$di->params['Masterclass\Model\Story'] = [
    'pdo' => $di->lazyNew('PDO'),
];

$di->params['Masterclass\Model\Comment'] = [
    'pdo' => $di->lazyNew('PDO'),
];

$di->params['Masterclass\Model\User'] = [
    'pdo' => $di->lazyNew('PDO'),
];

$di->params['PDO'] = [
    'dsn' => 'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['name'],
    'username' => $config['database']['user'],
    'passwd' => $config['database']['pass'],
];







