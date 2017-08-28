<?php

namespace Drop\Master\Event;

use Symfony\Component\EventDispatcher\Event;

class RaceEvent extends Event
{
    /**
     * @var string
     *
     * Triggered anytime race state changes (i.e new player vote, votes reset...)
     */
    const RACE_CHANGED = 'app.race_changed';

    /**
     * @var array
     */
    private $race;

    /**
     * Take as param data from method RaceState::getRaceState
     *
     * @param array $race
     */
    public function __construct(array $race)
    {
        $this->race = $race;
    }

    /**
     * @return array
     */
    public function getRace() : array
    {
        return $this->race;
    }
}
