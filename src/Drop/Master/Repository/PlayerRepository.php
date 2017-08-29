<?php

namespace Drop\Master\Repository;

use Doctrine\ORM\EntityRepository;
use Drop\Master\Entity\Player;

class PlayerRepository extends EntityRepository
{
    /**
     * @param string $pseudo
     *
     * @return Player
     */
    public function findOrCreate(string $pseudo) : Player
    {
        $player = $this->findOneByPseudo($pseudo);

        if (null === $player) {
            $player = new Player();

            $player->setPseudo($pseudo);

            $this->_em->persist($player);
            $this->_em->flush($player);
        }

        return $player;
    }

    /**
     * @return Player[]
     */
    public function findPlayersWithoutTeam($onlyVoters = false) : array
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.team is null')
        ;

        if ($onlyVoters) {
            $queryBuilder->andWhere('p.vote is not null');
        }

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Set all player votes to null.
     */
    public function resetVotes() : void
    {
        $this->createQueryBuilder('p')
            ->update()
            ->set('p.vote', ':reseted')
            ->setParameter(':reseted', null)
            ->getQuery()
            ->execute()
        ;
    }
}
