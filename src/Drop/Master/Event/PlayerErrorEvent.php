<?php

namespace Drop\Master\Event;

use Symfony\Component\EventDispatcher\Event;
use Drop\Master\Entity\Player;

class PlayerErrorEvent extends Event
{
    /**
     * @var string
     *
     * Triggered when a player seems to make an error when sending an order.
     */
    const PLAYER_ERROR = 'app.player_error';

    /**
     * @var Player
     */
    private $player;

    /**
     * @var string
     */
    private $message;

    /**
     * @param Player $player
     * @param array $message
     */
    public function __construct(Player $player, string $message)
    {
        $this->player = $player;
        $this->message = $message;
    }

    /**
     * @return Player
     */
    public function getPlayer() : Player
    {
        return $this->player;
    }

    /**
     * @return message
     */
    public function getMessage() : string
    {
        return $this->message;
    }
}
