<?php

namespace Drop\Master\Service;

use Drop\Master\Entity\Order;
use Drop\Master\Repository\TeamRepository;
use Drop\Master\Repository\PlayerRepository;

class RaceState
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
     * @param TeamRepository $teamRepository
     * @param PlayerRepository $playerRepository
     */
    public function __construct(TeamRepository $teamRepository, PlayerRepository $playerRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->playerRepository = $playerRepository;
    }

    /**
     * @return array
     */
    public function getRaceState()
    {
        return [
            'teams' => $this->teamRepository->findFullTeams(),
            'players_without_team' => $this->playerRepository->findPlayersWithoutTeam(),
        ];
    }
}
