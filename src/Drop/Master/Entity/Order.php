<?php

namespace Drop\Master\Entity;

class Order
{
    /**
     * @var string
     */
    const TEAM = 'team';

    /**
     * @var string
     */
    const MOVE = 'move';

    /**
     * @var string
     */
    private $pseudo;

    /**
     * @var string
     */
    private $team;

    /**
     * @var string
     */
    private $move;

    /**
     * @return string
     */
    public function getPseudo() : string
    {
        return $this->pseudo;
    }

    /**
     * @param string $pseudo
     *
     * @return self
     */
    public function setPseudo(string $pseudo) : self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return string
     */
    public function getType() : string
    {
        return null === $this->team ? self::MOVE : self::TEAM;
    }

    /**
     * @return bool
     */
    public function isTeam() : bool
    {
        return self::TEAM === $this->getType();
    }

    /**
     * @return string
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param string $team
     *
     * @return self
     */
    public function setTeam(string $team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMove() : bool
    {
        return self::MOVE === $this->getType();
    }

    /**
     * @return string
     */
    public function getMove()
    {
        return $this->move;
    }

    /**
     * @param string $move
     *
     * @return self
     */
    public function setMove(string $move) : self
    {
        $this->move = $move;

        return $this;
    }
}
