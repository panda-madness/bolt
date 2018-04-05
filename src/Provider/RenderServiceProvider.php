<?php

namespace Bolt\Provider;

use Bolt\Helpers\Deprecated;
use Bolt\Render;
use Pimple\Container;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Pimple\ServiceProviderInterface;

class RenderServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['render'] = function ($app) {
            Deprecated::service('render', 3.3, 'twig');

            return new Render($app);
        };

        $app['safe_render'] = function ($app) {
            Deprecated::service('render', 3.3, 'Use "twig" service with sandbox enabled instead.');

            return new Render($app, true);
        };
    }

    public function boot(Application $app)
    {
    }
}
