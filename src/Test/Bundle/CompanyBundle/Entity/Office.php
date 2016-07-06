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
     * @ORM\ManyToOne(targetEntity="Company", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="id_company", referencedColumnName="id_company")
     */
    private $idCompany;

    /**
     * @ORM\OneToMany(targetEntity="OpeningHours", mappedBy="idOffice", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $openingHours;

    public function __construct()
    {
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
