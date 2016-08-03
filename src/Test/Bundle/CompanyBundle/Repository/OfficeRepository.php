<?php

namespace Test\Bundle\CompanyBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Description of OfficeRepository
 *
 * @author lubomir.ferenc
 */
class OfficeRepository extends EntityRepository
{

    public function getOfficeDetails($companyId, $containInactive = false)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->select('o, oh');
        $qb->leftJoin('o.openingHours', 'oh');
        $qb->where('o.idCompany = :idCompany');
        $qb->orderBy('o.address', 'ASC');
        $qb->addOrderBy('oh.dayInWeek', 'ASC');
        
        $parameters = ['idCompany' => $companyId];
        if (!$containInactive) {
            $qb->andWhere('oh.active=:active OR oh.active IS NULL');
            $parameters['active'] = 1;
        }

        $query = $qb->getQuery();
        $query->setParameters($parameters);

        $result = $query->getResult(Query::HYDRATE_ARRAY);

        return $result;
    }
    
    public function getOpeningHours($officeId, $showInactive = false)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->select('oh, o, c');
        $qb->leftJoin('o.openingHours', 'oh');
        $qb->leftJoin('o.idCompany', 'c');
        $qb->where('o.idOffice = :idOffice');
        $qb->addOrderBy('oh.dayInWeek', 'ASC');
        
        $parameters = ['idOffice' => $officeId];
        if (!$showInactive) {
            $qb->andWhere('c.active=:active');
            $qb->andWhere('o.active=:active');
            $qb->andWhere('oh.active=:active');
            $parameters['active'] = 1;
        }

        $query = $qb->getQuery();
        $query->setParameters($parameters);

        try{
            $result = $query->getSingleResult(Query::HYDRATE_ARRAY);
        }
        catch(\Exception $e){
            $result = false;
        }
        

        return $result;
    }

}
