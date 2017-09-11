<?php

namespace Drop\Master;

use Pimple\ServiceProviderInterface;
use Pimple\Container;

class MasterProvider implements ServiceProviderInterface
{
    /**
     * {@InheritDoc}
     */
    public function register(Container $app)
    {
        $app['serializer.builder']
            ->addMetadataDir($app['project.root'].'/src/Drop/Master/Resources/serializer')
        ;

        $app->extend('doctrine.mappings', function ($mappings, $app) {
            $mappings []= [
                'type' => 'yml',
                'namespace' => 'Drop\\Master\\Entity',
                'path' => $app['project.root'].'/src/Drop/Master/Resources/mapping',
            ];

            return $mappings;
        });

        $app['app.constant.api_key'] = getenv('API_KEY');
        $app['app.constant.fleet_control_api'] = getenv('FLEET_CONTROL_API');

        $app['app.fleet_control_api'] = function (Container $app) {
            return new \GuzzleHttp\Client([
                'base_uri' => $app['app.constant.fleet_control_api'],
            ]);
        };

        $app['app.vote_session_handler'] = function (Container $app) {
            return new Service\VoteSessionHandler(
                $app['orm.em']->getRepository('Drop\\Master\\Entity\\VoteSession')
            );
        };

        $app['app.innocent_hand'] = function (Container $app) {
            return new Service\InnocentHand(
                $app['orm.em']->getRepository('Drop\\Master\\Entity\\Team'),
                $app['orm.em']->getRepository('Drop\\Master\\Entity\\Player'),
                $app['app.race_state'],
                $app['app.player_error_dispatcher'],
                $app['app.fleet_control_api']
            );
        };

        $app['app.orders_processor'] = function (Container $app) {
            return new Service\OrderProcessor(
                $app['orm.em']->getRepository('Drop\\Master\\Entity\\Team'),
                $app['orm.em']->getRepository('Drop\\Master\\Entity\\Player'),
                $app['app.player_error_dispatcher']
            );
        };

        $app['app.race_state'] = function (Container $app) {
            return new Service\RaceState(
                $app['orm.em']->getRepository('Drop\\Master\\Entity\\Team'),
                $app['orm.em']->getRepository('Drop\\Master\\Entity\\Player'),
                $app['dispatcher'],
                $app['app.vote_session_handler']
            );
        };

        $app['app.player_error_dispatcher'] = function (Container $app) {
            return new Service\PlayerErrorDispatcher($app['dispatcher']);
        };
    }
}
