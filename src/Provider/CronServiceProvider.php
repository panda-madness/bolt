<?php

namespace Bolt\Provider;

use Bolt\Cron;
use Pimple\Container;
use Silex;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Symfony\Component\Console\Output\BufferedOutput;

class CronServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['cron'] = function ($app) {
            $cron = new Cron($app, new BufferedOutput());

            return $cron;
        };
    }

    public function boot(Silex\Application $app)
    {
    }
}
