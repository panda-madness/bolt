<?php

namespace Bolt\Provider;

use Bolt\Pager\PagerManager;
use Pimple\Container;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Pimple\ServiceProviderInterface;

class PagerServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        // the provider
        $app['pager'] = function () {
            return new PagerManager();
        };
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }
}
