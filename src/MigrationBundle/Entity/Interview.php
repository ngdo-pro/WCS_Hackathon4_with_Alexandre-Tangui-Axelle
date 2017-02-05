<?php

namespace MigrationBundle\Entity;

/**
 * Interview
 */
class Interview
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $bonusWord;

    /**
     * @var \MigrationBundle\Entity\User
     */
    private $user;

    /**
     * @var \MigrationBundle\Entity\Job
     */
    private $job;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $answer;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answer = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set bonusWord
     *
     * @param string $bonusWord
     *
     * @return Interview
     */
    public function setBonusWord($bonusWord)
    {
        $this->bonusWord = $bonusWord;

        return $this;
    }

    /**
     * Get bonusWord
     *
     * @return string
     */
    public function getBonusWord()
    {
        return $this->bonusWord;
    }

    /**
     * Set user
     *
     * @param \MigrationBundle\Entity\User $user
     *
     * @return Interview
     */
    public function setUser(\MigrationBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MigrationBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set job
     *
     * @param \MigrationBundle\Entity\Job $job
     *
     * @return Interview
     */
    public function setJob(\MigrationBundle\Entity\Job $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return \MigrationBundle\Entity\Job
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Add answer
     *
     * @param \MigrationBundle\Entity\Answer $answer
     *
     * @return Interview
     */
    public function addAnswer(\MigrationBundle\Entity\Answer $answer)
    {
        $this->answer[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \MigrationBundle\Entity\Answer $answer
     */
    public function removeAnswer(\MigrationBundle\Entity\Answer $answer)
    {
        $this->answer->removeElement($answer);
    }

    /**
     * Get answer
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswer()
    {
        return $this->answer;
    }
}

