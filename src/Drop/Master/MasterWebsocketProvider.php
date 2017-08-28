<?php

namespace Drop\Master;

use Pimple\ServiceProviderInterface;
use Pimple\Container;

class MasterWebsocketProvider implements ServiceProviderInterface
{
    /**
     * {@InheritDoc}
     */
    public function register(Container $app) : void
    {
        $app->topic('race', function ($topicPattern) {
            return new Topic\RaceTopic($topicPattern);
        });

        $app->topic('player-error', function ($topicPattern) {
            return new Topic\PlayerErrorTopic($topicPattern);
        });
    }
}
