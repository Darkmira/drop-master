<?php

namespace Drop\Master;

use Pimple\ServiceProviderInterface;
use Pimple\Container;

class MasterRestApiProvider implements ServiceProviderInterface
{
    /**
     * {@InheritDoc}
     */
    public function register(Container $app)
    {
        $app->forwardEventsToPushServer([
            Event\RaceEvent::RACE_CHANGED,
            Event\PlayerErrorEvent::PLAYER_ERROR,
        ]);
    }
}
