<?php

namespace Test\Bundle\CompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Company
 */
class Company
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $idCompany;
    
    /**
     * @var ArrayCollection
     */
    private $offices;

    public function __construct() {
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
