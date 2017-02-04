<?php

namespace AppBundle\Entity;

/**
 * Word
 */
class Word
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $tag;


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
     * Set id
     *
     * @param int $id
     *
     * @return Word
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set tag
     *
     * @param string $tag
     *
     * @return Word
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
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
     * @return Word
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
