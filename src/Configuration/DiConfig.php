<?php

namespace Masterclass\Configuration;

use Aura\Di\Config;
use Aura\Di\Container;

/**
 * Description of DiConfig
 *
 * @author cainmartin
 */
class DiConfig extends Config
{
    public function define(Container $di)
    {
        $config = $di->get('config');
        $db = $config['database'];
        
        $dsn = 'mysql:host=' . $db['host'] . ';dbname=' . $db['name'];
        
        $di->params['Masterclass\Dbal\AbstractDb'] = [
            'dsn' => $dsn,
            'user' => $db['user'],
            'pass' => $db['pass'],
        ];
        
        $di->params['Masterclass\Model\Comment'] = [
            'db' => $di->lazyNew('Masterclass\Dbal\Mysql')
        ];
        
        $di->params['Masterclass\Model\Story'] = [
            'db' => $di->lazyNew('Masterclass\Dbal\Mysql')
        ];

        $di->params['Masterclass\Model\User'] = [
            'db' => $di->lazyNew('Masterclass\Dbal\Mysql')
        ];        
        
        $di->params['Masterclass\FrontController\MasterController'] = [
            'container' => $di,
            'config' => $config,
            'router' => $di->lazyNew('Masterclass\Router\Router'),
        ];
        
        $di->params['Masterclass\Controller\Comment'] = [
            'comment' => $di->lazyNew('Masterclass\Model\Comment')
        ];
        
        $di->params['Masterclass\Controller\Story'] = [
            'story' => $di->lazyNew('Masterclass\Model\Story'),
            'comment' => $di->lazyNew('Masterclass\Model\Comment'),
        ];
        
        $di->params['Masterclass\Controller\Index'] = [
            'story' => $di->lazyNew('Masterclass\Model\Story'),
        ];
        
        $di->params['Masterclass\Controller\User'] = [
            'user' => $di->lazyNew('Masterclass\Model\User'),
        ];
    }
}
