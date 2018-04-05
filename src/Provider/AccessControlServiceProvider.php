<?php

namespace Bolt\Provider;

use Bolt\AccessControl;
use Bolt\Legacy\PasswordLib\PasswordLibFactory;
use Pimple\Container;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class AccessControlServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['access_control.cookie.options'] = function () use ($app) {
            return [
                'remoteaddr'   => $app['config']->get('general/cookies_use_remoteaddr', true),
                'browseragent' => $app['config']->get('general/cookies_use_browseragent', false),
                'httphost'     => $app['config']->get('general/cookies_use_httphost', true),
                'lifetime'     => $app['config']->get('general/cookies_lifetime', 1209600),
            ];
        };

        $app['access_control.hash.strength'] = function () use ($app) {
            return max($app['config']->get('general/hash_strength'), 8);
        };

        $app['access_control'] = function ($app) {
            $tracker = new AccessControl\AccessChecker(
                $app['storage.lazy'],
                $app['request_stack'],
                $app['session'],
                $app['dispatcher'],
                $app['logger.flash'],
                $app['logger.system'],
                $app['permissions'],
                $app['randomgenerator'],
                $app['access_control.cookie.options']
            );

            return $tracker;
        };

        $app['access_control.login'] = function ($app) {
            return new AccessControl\Login(
                $app
            );
        };

        $app['access_control.password'] = function ($app) {
            return new AccessControl\Password($app);
        };

        $app['password_factory'] = function () {
            return new PasswordLibFactory();
        };

        $app['token.authentication.name'] = function ($app) {
            $request = $app['request_stack']->getCurrentRequest() ?: Request::createFromGlobals();
            $name = 'bolt_authtoken_' . md5($request->getHttpHost() . $request->getBaseUrl());

            return $name;
        };
    }

    public function boot(Application $app)
    {
    }
}
