<?php

namespace Test\Bundle\CompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * OpeningHours
 */
class OpeningHours
{
    /**
     * @var integer
     */
    private $dayInWeek;

    /**
     * @var string
     */
    private $startAt;

    /**
     * @var string
     */
    private $endAt;

    /**
     * @var string
     */
    private $lunchStartAt;

    /**
     * @var string
     */
    private $lunchEndAt;

    /**
     * @var integer
     */
    private $idOpnngHrs;

    /**
     * @var \Test\Bundle\CompanyBundle\Entity\Office
     */
    private $idOffice;


    /**
     * Set dayInWeek
     *
     * @param integer $dayInWeek
     * @return OpeningHours
     */
    public function setDayInWeek($dayInWeek)
    {
        $this->dayInWeek = $dayInWeek;

        return $this;
    }

    /**
     * Get dayInWeek
     *
     * @return integer 
     */
    public function getDayInWeek()
    {
        return $this->dayInWeek;
    }

    /**
     * Set startAt
     *
     * @param string $startAt
     * @return OpeningHours
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return string 
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set endAt
     *
     * @param string $endAt
     * @return OpeningHours
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt
     *
     * @return string 
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * Set lunchStartAt
     *
     * @param string $lunchStartAt
     * @return OpeningHours
     */
    public function setLunchStartAt($lunchStartAt)
    {
        $this->lunchStartAt = $lunchStartAt;

        return $this;
    }

    /**
     * Get lunchStartAt
     *
     * @return string 
     */
    public function getLunchStartAt()
    {
        return $this->lunchStartAt;
    }

    /**
     * Set lunchEndAt
     *
     * @param string $lunchEndAt
     * @return OpeningHours
     */
    public function setLunchEndAt($lunchEndAt)
    {
        $this->lunchEndAt = $lunchEndAt;

        return $this;
    }

    /**
     * Get lunchEndAt
     *
     * @return string 
     */
    public function getLunchEndAt()
    {
        return $this->lunchEndAt;
    }

    /**
     * Get idOpnngHrs
     *
     * @return integer 
     */
    public function getIdOpnngHrs()
    {
        return $this->idOpnngHrs;
    }

    /**
     * Set idOffice
     *
     * @param \Test\Bundle\CompanyBundle\Entity\Office $idOffice
     * @return OpeningHours
     */
    public function setIdOffice(\Test\Bundle\CompanyBundle\Entity\Office $idOffice = null)
    {
        $this->idOffice = $idOffice;

        return $this;
    }

    /**
     * Get idOffice
     *
     * @return \Test\Bundle\CompanyBundle\Entity\Office 
     */
    public function getIdOffice()
    {
        return $this->idOffice;
    }
}
