<?php

namespace Bolt\Provider;

use Bolt\TemplateChooser;
use Pimple\Container;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Pimple\ServiceProviderInterface;

class TemplateChooserServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['templatechooser'] = function ($app) {
            $chooser = new TemplateChooser($app['config']);

            return $chooser;
        };
    }

    public function boot(Application $app)
    {
    }
}
