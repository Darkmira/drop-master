<?php

namespace Drop\Master;

use Pimple\ServiceProviderInterface;
use Pimple\Container;

class MasterProvider implements ServiceProviderInterface
{
    /**
     * {@InheritDoc}
     */
    public function register(Container $app) : void
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
                $app['orm.em']->getRepository('Drop\\Master\\Entity\\Player')
            );
        };

        $app['app.player_error_dispatcher'] = function (Container $app) {
            return new Service\PlayerErrorDispatcher($app['dispatcher']);
        };
    }
}
