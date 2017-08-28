<?php

namespace Drop\Master\Topic;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Eole\Sandstone\Websocket\Topic;
use Drop\Master\Event\PlayerErrorEvent;
use Drop\Master\Event\RaceEvent;

class PlayerErrorTopic extends Topic implements EventSubscriberInterface
{
    /**
     * Listen for player errors.
     *
     * {@InheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            PlayerErrorEvent::PLAYER_ERROR => 'onPlayerError',
        ];
    }

    /**
     * Broadcast player errors.
     *
     * @param RaceEvent $event
     */
    public function onPlayerError(PlayerErrorEvent $event)
    {
        $this->broadcast([
            'player' => $event->getPlayer(),
            'message' => $event->getMessage(),
        ]);
    }
}
