<?php

namespace Test\Bundle\CompanyBundle\Model;

use Doctrine\ORM\EntityRepository;

/**
 * Description of WebModel
 *
 * @author lubomir.ferenc
 */
class WebModel extends EntityRepository {

    public function getOfficesByCompany($companyId)
    {
        $offices = $this->getEntityManager()
                ->getRepository("TestCompanyBundle:Office")
                ->getQuery()
                ->getResult();
        
        
    }

}
