<?php

namespace Masterclass\Router\Route;

use Masterclass\Router\Route\AbstractRoute;

/**
 * Description of GetRoute
 *
 * @author cainmartin
 */
class GetRoute extends AbstractRoute
{
    public function matchRoute($requestPath, $requestType)
    {
        if ($requestType != 'GET') {
            return false;
        }
        
        if ($this->routePath != $requestPath) {
            return false;
        }
        
        return true;
    }
}
