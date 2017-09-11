<?php

namespace Drop\Master\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Drop\Master\Entity\Player;
use Drop\Master\Event\PlayerErrorEvent;

class PlayerErrorDispatcher
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Player $player
     * @param string $message
     */
    public function dispatch(Player $player, string $message)
    {
        $this->dispatcher->dispatch(
            PlayerErrorEvent::PLAYER_ERROR,
            new PlayerErrorEvent($player, $message)
        );
    }
}
