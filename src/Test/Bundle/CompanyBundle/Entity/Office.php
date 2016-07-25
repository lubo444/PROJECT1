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
class Office
{

    /**
     * @ORM\Column(type="string", nullable=false, length=255)
     * @Assert\NotBlank
     */
    private $address;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_office", nullable=false, options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idOffice;

    /**
     * @ORM\ManyToOne(targetEntity="Company", cascade={"persist"}, inversedBy="offices", fetch="EAGER")
     * @ORM\JoinColumn(name="id_company", referencedColumnName="id_company")
     */
    private $idCompany;

    /**
     * @ORM\OrderBy({"dayInWeek" = "ASC"})
     * @ORM\OneToMany(targetEntity="OpeningHours", mappedBy="idOffice", cascade={"persist", "remove"}, orphanRemoval=true, fetch="EAGER")
     */
    private $openingHours;
    
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
        $this->openingHours = new ArrayCollection();
        $this->active = 1;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Office
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Get idOffice
     *
     * @return integer 
     */
    public function getIdOffice()
    {
        return $this->idOffice;
    }

    /**
     * Set idCompany
     *
     * @param \Test\Bundle\CompanyBundle\Entity\Company $idCompany
     * @return Office
     */
    public function setIdCompany(\Test\Bundle\CompanyBundle\Entity\Company $idCompany = null)
    {
        $this->idCompany = $idCompany;

        return $this;
    }

    /**
     * Get idCompany
     *
     * @return \Test\Bundle\CompanyBundle\Entity\Company 
     */
    public function getIdCompany()
    {
        return $this->idCompany;
    }
    
    /**
     * Get openingHours
     *
     * @return ArrayCollection 
     */
    public function getOpeningHours()
    {
        return $this->openingHours;
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
     * @return Office
     */
    public function setCreatedBy($userId)
    {
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
     * @return Office
     */
    public function setActive($active)
    {
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
     * @return Office
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
     * @return Office
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}
