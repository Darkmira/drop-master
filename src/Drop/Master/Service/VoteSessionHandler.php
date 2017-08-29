<?php

namespace Drop\Master\Service;

use Drop\Master\Entity\VoteSession;
use Drop\Master\Repository\VoteSessionRepository;

class VoteSessionHandler
{
    /**
     *
     * @var VoteSessionRepository
     */
    private $voteSessionRepository;

    /**
     * @param VoteSessionRepository $voteSessionRepository
     */
    public function __construct(VoteSessionRepository $voteSessionRepository)
    {
        $this->voteSessionRepository = $voteSessionRepository;
    }

    /**
     * @return VoteSession|null
     */
    public function getCurrent()
    {
        return $this->voteSessionRepository->findVoteSession();
    }

    /**
     * @param int $seconds
     */
    public function startNew(int $seconds)
    {
        $voteSession = $this->getCurrent();

        if (null === $voteSession) {
            $voteSession = new VoteSession();
        }

        $voteSession
            ->setSessionDuration($seconds)
            ->setSessionStart(new \DateTime())
            ->setSessionEnd((new \DateTime())->modify("+$seconds second"))
        ;

        $this->voteSessionRepository->saveVoteSession($voteSession);
    }
}
