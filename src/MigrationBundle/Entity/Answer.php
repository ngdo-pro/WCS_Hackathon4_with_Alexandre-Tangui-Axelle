<?php

namespace MigrationBundle\Entity;

/**
 * Answer
 */
class Answer
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $word;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $interview;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->interview = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set word
     *
     * @param string $word
     *
     * @return Answer
     */
    public function setWord($word)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * Set domain
     *
     * @param string $domain
     *
     * @return Answer
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Add interview
     *
     * @param \MigrationBundle\Entity\Interview $interview
     *
     * @return Answer
     */
    public function addInterview(\MigrationBundle\Entity\Interview $interview)
    {
        $this->interview[] = $interview;

        return $this;
    }

    /**
     * Remove interview
     *
     * @param \MigrationBundle\Entity\Interview $interview
     */
    public function removeInterview(\MigrationBundle\Entity\Interview $interview)
    {
        $this->interview->removeElement($interview);
    }

    /**
     * Get interview
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInterview()
    {
        return $this->interview;
    }
}

