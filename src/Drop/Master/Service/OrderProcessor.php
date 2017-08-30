<?php

namespace Drop\Master\Service;

use Drop\Master\Entity\Order;
use Drop\Master\Repository\TeamRepository;
use Drop\Master\Repository\PlayerRepository;

class OrderProcessor
{
    /**
     * @var TeamRepository
     */
    private $teamRepository;

    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    /**
     * @var PlayerErrorDispatcher
     */
    private $playerErrorDispatcher;

    /**
     * @param TeamRepository $teamRepository
     * @param PlayerRepository $playerRepository
     * @param PlayerErrorDispatcher $playerErrorDispatcher
     */
    public function __construct(
        TeamRepository $teamRepository,
        PlayerRepository $playerRepository,
        PlayerErrorDispatcher $playerErrorDispatcher
    ) {
        $this->teamRepository = $teamRepository;
        $this->playerRepository = $playerRepository;
        $this->playerErrorDispatcher = $playerErrorDispatcher;
    }

    /**
     * @param Order $order
     */
    public function processOrder(Order $order) : void
    {
        $player = $this->playerRepository->findOrCreate($order->getPseudo());

        if ($order->isTeam()) {
            if ($player->hasTeam()) {
                if ($order->getTeam() === $player->getTeam()->getName()) {
                    $error = 'player_error.already_in_team';
                } else {
                    $error = 'player_error.traitor';
                }

                $this->playerErrorDispatcher->dispatch($player, $error);
                return;
            }

            $team = $this->teamRepository->findOrCreate($order->getTeam());

            $player->setTeam($team);
        }

        if ($order->isMove()) {
            $player->setVote($order->getMove());

            if (!$player->hasTeam()) {
                $this->playerErrorDispatcher->dispatch($player, 'player_error.dont_forget_choose_team');
            }
        }
    }

    /**
     * @param Order[] $orders
     */
    public function processOrders(array $orders) : void
    {
        foreach ($orders as $order) {
            $this->processOrder($order);
        }
    }
}
