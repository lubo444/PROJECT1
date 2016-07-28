<?php

namespace Test\Bundle\CompanyBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of OfficeRepository
 *
 * @author lubomir.ferenc
 */
class OfficeRepository extends EntityRepository
{
/*
    public function getOfficeDetails($idOffice, $containInactive = false)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->select('o, oh');
        $qb->leftJoin('o.openingHours', 'oh');
        $qb->where('o.idOffice = :idOffice');
        $qb->orderBy('o.address', 'ASC');
        $qb->addOrderBy('oh.dayInWeek', 'ASC');

        $parameters = ['idOffice'=>$idOffice];
        if (!$containInactive) {
            $qb->andWhere('oh.active=:active');
            $parameters['active'] = 1;
        }
        
        $query = $qb->getQuery();
        
        if (is_array($parameters)) {
            $query->setParameters($parameters);
        }

        $result = $query->getResult();
        
        return $result;
    }/**/

}
