<?php

namespace Test\Bundle\CompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class Office {

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
     * @ORM\ManyToOne(targetEntity="Company", cascade={"persist"}, inversedBy="offices", fetch="LAZY")
     * @ORM\JoinColumn(name="id_company", referencedColumnName="id_company")
     */
    private $idCompany;

    /**
     * @ORM\OneToMany(targetEntity="OpeningHours", mappedBy="idOffice", cascade={"persist", "remove"}, orphanRemoval=true)
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

    public function __construct($userId)
    {
        $this->openingHours = new ArrayCollection();
        $this->createdBy = $userId;
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

}
