<?php

namespace Drop\Master\Repository;

use Doctrine\ORM\EntityRepository;
use Drop\Master\Entity\VoteSession;

class VoteSessionRepository extends EntityRepository
{
    public function findVoteSession()
    {
        return $this->createQueryBuilder('v')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function saveVoteSession(VoteSession $voteSession)
    {
        $this->_em->persist($voteSession);
        $this->_em->flush($voteSession);
    }
}
