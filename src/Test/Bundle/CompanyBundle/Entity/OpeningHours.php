<?php

namespace Test\Bundle\CompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class OpeningHours {

    /**
     * @ORM\Column(type="integer", name="day_in_week", nullable=false)
     * @Assert\NotBlank()
     */
    private $dayInWeek;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", nullable=false, length=15)
     */
    private $startAt;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", nullable=false, length=15)
     */
    private $endAt;

    /**
     * @ORM\Column(type="string", nullable=true, length=15)
     */
    private $lunchStartAt;

    /**
     * @ORM\Column(type="string", nullable=true, length=15)
     */
    private $lunchEndAt;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_opnng_hrs", nullable=false, options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idOpnngHrs;
    
    /**
     * @ORM\ManyToOne(targetEntity="Office", cascade={"persist"}, fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="id_office", referencedColumnName="id_office")
     */
    private $idOffice;
    
    /**
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":false})
     * @Assert\NotBlank
     */
    private $createdBy;
    
    /**
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true})
     * @Assert\NotBlank
     */
    private $active;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->active = 1;
    }

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
    
    /**
     * Get createdBy
     *
     * @return User 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    /**
     * Set createdBy
     *
     * @param string $userId
     * @return Company
     */
    public function setCreatedBy($userId){
        $this->createdBy = $userId;
        
        return $this;
    }
    
    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive()
    {
        return $this->active;
    }
    
    /**
     * Set active
     *
     * @param string $active
     * @return Company
     */
    public function setActive($active){
        $this->active = $active;
        
        return $this;
    }
    
    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new DateTime('now'));
        }
    }
    
    /**
     * Get updatedAt
     *
     * @return DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param DateTime $updatedAt
     * @return Company
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    
    /**
     * Get createdAt
     *
     * @return DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     * @return Company
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}
