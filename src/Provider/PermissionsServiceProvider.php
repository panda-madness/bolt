<?php

namespace Bolt\Provider;

use Bolt\AccessControl\Permissions;
use Pimple\Container;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Pimple\ServiceProviderInterface;

class PermissionsServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['permissions'] = function ($app) {
            $permissions = new Permissions($app);

            return $permissions;
        };
    }

    public function boot(Application $app)
    {
    }
}
