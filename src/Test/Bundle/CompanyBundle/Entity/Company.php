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
        $this->offices = new ArrayCollection();
        $this->createdBy = $userId;
        $this->active = 1;
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
