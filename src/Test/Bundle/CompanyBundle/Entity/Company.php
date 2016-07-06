<?php

namespace Test\Bundle\CompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Test\Bundle\CompanyBundle\Repository\CompanyRepository")
 */
class Company {

    /**
     * @ORM\Column(type="string", nullable=false, length=127)
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_company", nullable=false, options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idCompany;

    /**
     * @ORM\OneToMany(targetEntity="Office", mappedBy="idCompany", cascade={"persist"}, orphanRemoval=true)
     */
    private $offices;

    public function __construct()
    {
        $this->offices = new ArrayCollection();
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Company
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get idCompany
     *
     * @return integer 
     */
    public function getIdCompany()
    {
        return $this->idCompany;
    }

    /**
     * Get offices
     *
     * @return ArrayCollection 
     */
    public function getOffices()
    {
        return $this->offices;
    }

}
