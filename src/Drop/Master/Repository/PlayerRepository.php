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
    public function findPlayersWithoutTeam() : array
    {
        return $this->createQueryBuilder('p')
            ->where('p.team is null')
            ->getQuery()
            ->getResult()
        ;
    }
}
