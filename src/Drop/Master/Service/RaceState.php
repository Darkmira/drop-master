<?php

namespace Drop\Master\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Drop\Master\Event\RaceEvent;
use Drop\Master\Repository\TeamRepository;
use Drop\Master\Repository\PlayerRepository;
use Drop\Master\Service\VoteSessionHandler;

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
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var VoteSessionHandler
     */
    private $voteSessionHandler;

    /**
     * @param TeamRepository $teamRepository
     * @param PlayerRepository $playerRepository
     * @param EventDispatcherInterface $dispatcher
     * @param VoteSessionHandler $voteSessionHandler
     */
    public function __construct(
        TeamRepository $teamRepository,
        PlayerRepository $playerRepository,
        EventDispatcherInterface $dispatcher,
        VoteSessionHandler $voteSessionHandler
    ) {
        $this->teamRepository = $teamRepository;
        $this->playerRepository = $playerRepository;
        $this->dispatcher = $dispatcher;
        $this->voteSessionHandler = $voteSessionHandler;
    }

    /**
     * @return array
     */
    public function getRaceState()
    {
        return [
            'teams' => $this->teamRepository->findFullTeams(),
            'players_without_team' => $this->playerRepository->findPlayersWithoutTeam(),
            'vote_session' => $this->voteSessionHandler->getCurrent(),
        ];
    }

    /**
     * Dispatch race changed event.
     */
    public function dispatchRaceState()
    {
        $raceState = $this->getRaceState();
        $raceEvent = new RaceEvent($raceState);

        $this->dispatcher->dispatch(RaceEvent::RACE_CHANGED, $raceEvent);
    }
}
