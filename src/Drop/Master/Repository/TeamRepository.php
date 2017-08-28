<?php

namespace Drop\Master\Repository;

use Doctrine\ORM\EntityRepository;
use Drop\Master\Entity\Team;

class TeamRepository extends EntityRepository
{
    /**
     * @param string $name
     *
     * @return Team
     */
    public function findOrCreate(string $name) : Team
    {
        $team = $this->findOneByName($name);

        if (null === $team) {
            $team = new Team();

            $team->setName($name);

            $this->_em->persist($team);
            $this->_em->flush($team);
        }

        return $team;
    }

    /**
     * @return Team[]
     */
    public function findFullTeams() : array
    {
        return $this->createQueryBuilder('t')
            ->addSelect('p')
            ->leftJoin('t.players', 'p')
            ->getQuery()
            ->getResult()
        ;
    }
}
