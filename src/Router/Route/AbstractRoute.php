<?php

namespace Masterclass\Router\Route;

use Masterclass\Router\Route\RouteInterface;

/**
 * Description of AbstractRoute
 *
 * @author cainmartin
 */
abstract class AbstractRoute implements RouteInterface
{
    protected $routePath;
    protected $routeClass;
    
    /**
     * 
     * @param type $routePath
     * @param type $routeClass
     */
    public function __construct($routePath, $routeClass)
    {
        $this->routePath = $routePath;
        $this->routeClass = $routeClass;
    }
    
    /**
     * 
     * @return type
     */
    public function getRoutePath()
    {
        return $this->routePath;
    }
    
    /**
     * 
     * @return type
     */
    public function getRouteClass()
    {
        return $this->routeClass;
    }
    
    /**
     * 
     */
    abstract public function matchRoute($requestPath, $requestType);
}
