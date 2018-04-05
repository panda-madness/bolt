<?php

namespace Bolt\Provider;

use Bolt\Omnisearch;
use Pimple\Container;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Pimple\ServiceProviderInterface;

class OmnisearchServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['omnisearch'] = function ($app) {
            $omnisearch = new Omnisearch($app);

            return $omnisearch;
        };
    }

    public function boot(Application $app)
    {
    }
}
