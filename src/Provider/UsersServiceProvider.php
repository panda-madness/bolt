<?php

namespace Bolt\Provider;

use Bolt\Users;
use Pimple\Container;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Pimple\ServiceProviderInterface;

class UsersServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['users'] = function ($app) {
            return new Users($app);
        };
    }

    public function boot(Application $app)
    {
    }
}
