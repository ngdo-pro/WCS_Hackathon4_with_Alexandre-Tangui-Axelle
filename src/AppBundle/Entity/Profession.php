<?php

namespace AppBundle\Entity;

/**
 * Profession
 */
class Profession
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $domain;

    /**
     * Set id
     *
     * @param int $id
     *
     * @return Profession
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Profession
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set domain
     *
     * @param string $domain
     *
     * @return Profession
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $occurences;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->occurences = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add occurence
     *
     * @param \AppBundle\Entity\Occurence $occurence
     *
     * @return Profession
     */
    public function addOccurence(\AppBundle\Entity\Occurence $occurence)
    {
        $this->occurences[] = $occurence;

        return $this;
    }

    /**
     * Remove occurence
     *
     * @param \AppBundle\Entity\Occurence $occurence
     */
    public function removeOccurence(\AppBundle\Entity\Occurence $occurence)
    {
        $this->occurences->removeElement($occurence);
    }

    /**
     * Get occurences
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOccurences()
    {
        return $this->occurences;
    }
}
