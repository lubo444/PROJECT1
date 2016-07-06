<?php

namespace Test\Bundle\CompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Office
 */
class Office
{
    /**
     * @var string
     */
    private $address;

    /**
     * @var integer
     */
    private $idOffice;

    /**
     * @var \Test\Bundle\CompanyBundle\Entity\Company
     */
    private $idCompany;

    /**
     * @var ArrayCollection
     */
    private $openingHours;

    public function __construct() {
        $this->openingHours = new ArrayCollection();
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
}
