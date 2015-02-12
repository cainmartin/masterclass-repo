<?php

namespace Masterclass\FrontController;

use Aura\Di\Container;
use Masterclass\Router\Router;

class MasterController 
{
    /**
     *
     * @var type 
     */
    protected $config;
    
    /**
     *
     * @var Container 
     */
    protected $container;
    
    /**
     *
     * @var Router 
     */
    protected $router;
    
    public function __construct(Container $container, array $config = [], Router $router) 
    {
        $this->config = $config;
        $this->container = $container;
        $this->router = $router;
    }
    
    public function execute() 
    {
        $match = $this->_determineControllers();
        $calling = $match->getRouteClass();
        list($class, $method) = explode(':', $calling);
        $o = $this->container->newInstance($class);
        return $o->$method();
    }
    
    private function _determineControllers()
    {
        $match = $this->router->findMatch();
        
        if (!$match) {
            throw new \Exception('No Route Match Found');
        }
        
        return $match;
    }
}