<?php

namespace Drop\Master\Service;

use GuzzleHttp\ClientInterface;
use Drop\Master\Repository\TeamRepository;
use Drop\Master\Repository\PlayerRepository;
use Drop\Master\Service\RaceState;

class InnocentHand
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
     * @var RaceState
     */
    private $raceState;

    /**
     * @var PlayerErrorDispatcher
     */
    private $playerErrorDispatcher;

    /**
     * @var ClientInterface
     */
    private $fleetControlApi;

    /**
     * @param TeamRepository $teamRepository
     * @param PlayerRepository $playerRepository
     * @param RaceState $raceState
     * @param PlayerErrorDispatcher $playerErrorDispatcher
     * @param ClientInterface $fleetControlApi
     */
    public function __construct(
        TeamRepository $teamRepository,
        PlayerRepository $playerRepository,
        RaceState $raceState,
        PlayerErrorDispatcher $playerErrorDispatcher,
        ClientInterface $fleetControlApi
    ) {
        $this->teamRepository = $teamRepository;
        $this->playerRepository = $playerRepository;
        $this->raceState = $raceState;
        $this->playerErrorDispatcher = $playerErrorDispatcher;
        $this->fleetControlApi = $fleetControlApi;
    }

    /**
     * Perform a session cooldown:
     * count votes, send to robots, reset votes...
     *
     * @return string[] Orders sent to robots.
     */
    public function sessionCooldown() : array
    {
        $teams = $this->teamRepository->findFullTeams();
        $teamsVotes = $this->countVotes($teams);
        $ordersToSend = $this->bestVote($teamsVotes);
        $ordersSent = $this->sendOrdersToRobots($ordersToSend);

        $this->noticeCanceledVotes();
        $this->resetVotes();
        $this->raceState->dispatchRaceState();

        return $ordersSent;
    }

    /**
     * Count players votes and returns sum by orders and by teams.
     *
     * @return int[][]
     */
    public function countVotes(array $teams)
    {
        $teamsVotes = [];

        foreach ($teams as $team) {
            $teamVotes = [];

            foreach ($team->getPlayers() as $player) {
                if (!$player->hasVote()) {
                    continue;
                }

                if (!isset($teamVotes[$player->getVote()])) {
                    $teamVotes[$player->getVote()] = 0;
                }

                $teamVotes[$player->getVote()]++;
            }

            $teamsVotes[$team->getName()] = $teamVotes;
        }

        return $teamsVotes;
    }

    /**
     * Returns more wanted order by teams.
     * Or null if there is no any vote in a team.
     *
     * @return string[]
     */
    public function bestVote(array $teamsVotes)
    {
        $bestVotes = [];

        foreach ($teamsVotes as $teamName => $teamVotes) {
            if (0 === count($teamVotes)) {
                $bestVotes[$teamName] = null;
            }

            asort($teamVotes);
            reset($teamVotes);
            $bestVotes[$teamName] = key($teamVotes);
        }

        return $bestVotes;
    }

    /**
     * Send request to fleet control api.
     *
     * @param string[] $orders An array of robot => order (i.e green => forward)
     *
     * @return string[][] Orders sent to fleet control api.
     */
    public function sendOrdersToRobots($orders)
    {
        $tuples = [];

        foreach ($orders as $robot => $order) {
            if (null === $order) {
                continue;
            }

            $tuples []= [
                'color' => $robot,
                'order' => $order,
            ];
        }

        if (count($tuples) > 0) {
            $this->fleetControlApi->request('POST', 'orders', ['json' => $tuples]);
        }

        return $tuples;
    }

    /**
     * Send a push notification for each players
     * whose vote has been canceled because player is not in a team.
     */
    public function noticeCanceledVotes()
    {
        $votersWithoutTeam = $this->playerRepository->findPlayersWithoutTeam(true);

        foreach ($votersWithoutTeam as $player) {
            $this->playerErrorDispatcher->dispatch($player, 'player_error.vote_canceled_because_no_team');
        }
    }

    /**
     * Reset all players votes.
     */
    public function resetVotes()
    {
        $this->playerRepository->resetVotes();
    }
}
