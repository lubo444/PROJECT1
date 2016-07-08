<?php

namespace Test\Bundle\CompanyBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of CompanyRepository
 *
 * @author lubomir.ferenc
 */
class CompanyRepository extends EntityRepository {

    public function getCompanies($filters = [], $page = 1, $limit = 100)
    {
        $qb = $this->createQueryBuilder('Company');
        $qb->select('c, o, oh')
                ->from('TestCompanyBundle:Company', 'c')
                ->leftJoin('c.offices', 'o')
                ->leftJoin('o.openingHours', 'oh')
                ->orderBy('c.title', 'ASC')
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit);

        $parameters = [];
        
        foreach ($filters as $filterName => $filterValue) {
            if($filterValue === null){
                continue;
            }
        
            switch ($filterName) {
                case 'name':
                    $qb->where('c.title LIKE :name');
                    $qb->orWhere('o.address LIKE :name');
                    $parameters['name'] = '%' . $filterValue . '%';
                    break;
                
                case 'day':
                    $qb->andWhere('oh.dayInWeek = :day');
                    $parameters['day'] = $filterValue;
                    break;
                
                case 'hour':
                    $start = $qb->expr()->substring('oh.startAt', 1, 2);
                    $end = $qb->expr()->substring('oh.endAt', 1, 2);
                    $t1 = $qb->expr()->lte($start, $filterValue);
                    $t2 = $qb->expr()->gt($end, $filterValue);
                    $qb->andWhere($t1);
                    $qb->andWhere($t2);
                    break;
                
                default:
                    break;
            }
        }
        
        if(!isset($filters['roleAdmin']) || !$filters['roleAdmin']){
            $qb->andWhere('c.active = 1');
            $qb->andWhere('o.active = 1 OR o.idOffice IS NULL');
            $qb->andWhere('oh.active = 1 OR oh.idOpnngHrs IS NULL');
        }

        $query = $qb->getQuery();
        $query->setParameters($parameters);

        return $query->getResult();
    }

}
