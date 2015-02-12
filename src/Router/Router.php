<?php

namespace Masterclass\Router;

use Masterclass\Router\Route\RouteInterface;

/**
 * Description of Router
 *
 * @author cainmartin
 */
class Router
{
    protected $serverVars;
    protected $routes = [];
    
    public function __construct($serverVars, array $routes = []) 
    {
        $this->serverVars = $serverVars;
        foreach ($routes as $route) {
            $this->addRoute($route);
        }
    }
    
    public function addRoute(RouteInterface $route)
    {
        $this->routes[]  = $route;
    }
    
    public function findMatch()
    {
        $path = parse_url($this->serverVars['REQUEST_URI'], PHP_URL_PATH);
        
        foreach($this->routes as $route) {
      
            if ($route->MatchRoute($path, $this->serverVars['REQUEST_METHOD'])) {
                return $route;
            }
        }
        
        return false;
    }
}
