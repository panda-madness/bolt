<?php

namespace Bolt\Provider;

use Bolt\Security\Random\Generator;
use Pimple\Container;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Pimple\ServiceProviderInterface;

class RandomGeneratorServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['randomgenerator'] = function () {
            return new Generator();
        };
    }

    public function boot(Application $app)
    {
    }
}
