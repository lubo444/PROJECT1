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

        if (is_array($parameters)) {
            $query->setParameters($parameters);
        }

        $result = $query->getResult(Query::HYDRATE_ARRAY);

        return $result;
    }
    
    public function getOpeningHours($officeId, $containInactive = false)
    {
        
        $qb = $this->createQueryBuilder('o');
        $qb->select('o, oh');
        $qb->leftJoin('o.openingHours', 'oh');
        $qb->where('o.idOffice = :idOffice');
        $qb->addOrderBy('oh.dayInWeek', 'ASC');
        
        $parameters = ['idOffice' => $officeId];
        if (!$containInactive) {
            $qb->andWhere('oh.active=:active OR oh.active IS NULL');
            $parameters['active'] = 1;
        }

        $query = $qb->getQuery();
        
        if (!$containInactive) {
            $qb->andWhere('oh.active=:active OR oh.active IS NULL');
            $parameters['active'] = 1;/**/
        }

        if (is_array($parameters)) {
            $query->setParameters($parameters);
        }

        $result = $query->getResult(Query::HYDRATE_ARRAY);

        return $result;
    }

}
