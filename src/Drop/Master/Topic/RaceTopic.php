<?php

namespace Drop\Master\Topic;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Eole\Sandstone\Websocket\Topic;
use Drop\Master\Event\RaceEvent;

class RaceTopic extends Topic implements EventSubscriberInterface
{
    /**
     * Listen for race change push event.
     *
     * {@InheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            RaceEvent::RACE_CHANGED => 'onRaceChanged',
        ];
    }

    /**
     * Broadcast race event.
     *
     * @param RaceEvent $event
     */
    public function onRaceChanged(RaceEvent $event)
    {
        $this->broadcast($event->getRace());
    }
}
