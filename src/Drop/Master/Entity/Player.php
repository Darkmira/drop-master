<?php

namespace Drop\Master\Entity;

class Player
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $pseudo;

    /**
     * @var string
     */
    private $vote;

    /**
     * @var Team
     */
    private $team;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id) : self
    {
        $this->id = $id;

        return $this;
    }

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
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * @return bool
     */
    public function hasVote() : bool
    {
        return null !== $this->vote;
    }

    /**
     * @param string $vote
     *
     * @return self
     */
    public function setVote(string $vote) : self
    {
        $this->vote = $vote;

        return $this;
    }

    /**
     * @return Team
     */
    public function getTeam() : Team
    {
        return $this->team;
    }

    /**
     * @return bool
     */
    public function hasTeam() : bool
    {
        return null !== $this->team;
    }

    /**
     * @param Team $team
     *
     * @return self
     */
    public function setTeam(Team $team) : self
    {
        $this->team = $team;

        return $this;
    }
}
