<?php

namespace Bolt\Provider;

use Bolt\Filesystem\FilePermissions;
use Pimple\Container;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Pimple\ServiceProviderInterface;

/**
 * @author Benjamin Georgeault <benjamin@wedgesama.fr>
 */
class FilePermissionsServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['filepermissions'] = function ($app) {
            return new FilePermissions($app['config']);
        };
    }

    public function boot(Application $app)
    {
    }
}
