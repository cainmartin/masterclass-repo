<?php

namespace Masterclass\FrontController;

use Aura\Di\Container;
use Aura\Web\Response;
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
        $response = $o->$method();
        if ($response instanceof Response) {
            $this->sendResponse($response);
        }
    }
    
    public function sendResponse(Response $response)
    {
        header($response->status->get(), true, $response->status->getCode());
        
        // Send non-cookie headers
        foreach($response->headers->get() as $label => $value) {
            header("{$label}: {$value}");
        }
        
        // Send cookies
        foreach($response->cookies->get() as $name => $cookie) {
            setcookie(
                    $name,
                    $cookie['value'],
                    $cookie['expire'],
                    $cookie['path'],
                    $cookie['domain'],
                    $cookie['secure'],
                    $cookie['httponly']
            );
        }
        header('Connection: close');
        
        // Send response
        print($response->content->get());
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