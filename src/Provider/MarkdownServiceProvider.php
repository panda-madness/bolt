<?php

namespace Bolt\Provider;

use ParsedownExtra as Markdown;
use Pimple\Container;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Pimple\ServiceProviderInterface;

class MarkdownServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['markdown'] = function () {
            $markdown = new Markdown();

            return $markdown;
        };
    }

    public function boot(Application $app)
    {
    }
}
