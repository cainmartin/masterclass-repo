<?php

return array(

    'database' => array(
        'user' => '',
        'pass' => '',
        'host' => '',
        'name' => '',
    ),
    
    'routes' => array(
        '' => 'Masterclass\Controller\index:index',
        'story' => 'Masterclass\Controller\story:index',
        'story/create' => 'Masterclass\Controller\story:create',
        'comment/create' => 'Masterclass\Controller\comment:create',
        'user/create' => 'Masterclass\Controller\user:create',
        'user/account' => 'Masterclass\Controller\user:account',
        'user/login' => 'Masterclass\Controller\user:login',
        'user/logout' => 'Masterclass\Controller\user:logout',
    ),
);

