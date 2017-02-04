<?php

namespace AppBundle\Entity;

/**
 * Occurence
 */
class Occurence
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var float
     */
    private $number;


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
     * Set number
     *
     * @param float $number
     *
     * @return Occurence
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return float
     */
    public function getNumber()
    {
        return $this->number;
    }
    /**
     * @var \AppBundle\Entity\Profession
     */
    private $profession;

    /**
     * @var \AppBundle\Entity\Word
     */
    private $word;


    /**
     * Set profession
     *
     * @param \AppBundle\Entity\Profession $profession
     *
     * @return Occurence
     */
    public function setProfession(\AppBundle\Entity\Profession $profession = null)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession
     *
     * @return \AppBundle\Entity\Profession
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set word
     *
     * @param \AppBundle\Entity\Word $word
     *
     * @return Occurence
     */
    public function setWord(\AppBundle\Entity\Word $word = null)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return \AppBundle\Entity\Word
     */
    public function getWord()
    {
        return $this->word;
    }
}
