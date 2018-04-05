<?php

namespace Bolt\Provider;

use Bolt\Common\Deprecated;
use Pimple\Container;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Silex\Provider\SwiftmailerServiceProvider;
use Pimple\ServiceProviderInterface;

/**
 * SwiftMailer integration.
 *
 * @author Carson Full <carsonfull@gmail.com>
 */
class MailerServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        if (!isset($app['swiftmailer.options'])) {
            $app->register(new SwiftmailerServiceProvider());
        }

        $app['swiftmailer.options'] = $app->factory(function ($app) {
            return (array) $app['config']->get('general/mailoptions');
        });

        $app['swiftmailer.use_spool'] = $app->factory(function ($app) {
            return (bool) $app['config']->get('general/mailoptions/spool', true);
        });

        // Use the 'mail' transport. Discouraged, but some people want it. ¯\_(ツ)_/¯
        $transportFactory = $app->raw('swiftmailer.transport');
        $app['swiftmailer.transport'] = function ($app) use ($transportFactory) {
            if ($app['config']->get('general/mailoptions/transport') === 'mail') {
                Deprecated::warn("Setting 'general/mailoptions/transport' configuration value to 'mail'", 3.3, "Use 'smtp' instead.");

                return \Swift_MailTransport::newInstance();
            }

            return $transportFactory($app);
        };
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }
}
