<?php

namespace Drop\Master\Entity;

class VoteSession
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $sessionStart;

    /**
     * @var \DateTime
     */
    private $sessionEnd;

    /**
     * @var int
     */
    private $sessionDuration;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getSessionStart() : \DateTime
    {
        return $this->sessionStart;
    }

    /**
     * @param \DateTime $sessionStart
     *
     * @return self
     */
    public function setSessionStart(\DateTime $sessionStart) : self
    {
        $this->sessionStart = $sessionStart;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getSessionEnd() : \DateTime
    {
        return $this->sessionEnd;
    }

    /**
     * @param \DateTime $sessionEnd
     *
     * @return self
     */
    public function setSessionEnd(\DateTime $sessionEnd) : self
    {
        $this->sessionEnd = $sessionEnd;

        return $this;
    }

    /**
     * @return int
     */
    public function getSessionDuration() : int
    {
        return $this->sessionDuration;
    }

    /**
     * @param type $sessionDuration
     *
     * @return self
     */
    public function setSessionDuration($sessionDuration) : self
    {
        $this->sessionDuration = $sessionDuration;

        return $this;
    }
}
