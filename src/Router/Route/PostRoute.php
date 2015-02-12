<?php

namespace Masterclass\Router\Route;

use Masterclass\Router\Route\AbstractRoute;

/**
 * Description of PostRoute
 *
 * @author cainmartin
 */
class PostRoute extends AbstractRoute
{
    public function matchRoute($requestPath, $requestType)
    {
        if ($requestType != 'POST') {
            return false;
        }
        
        if ($this->routePath != $requestPath) {
            return false;
        }
        
        return true;
    }
}
