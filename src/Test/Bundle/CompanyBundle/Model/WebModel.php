<?php

namespace Test\Bundle\CompanyBundle\Model;

/**
 * Description of WebModel
 *
 * @author lubomir.ferenc
 */
class WebModel {

    private $modelManager;

    public function setModelManager($manager)
    {
        $this->modelManager = $manager;
    }

    public function getModelManager()
    {
        return $this->modelManager;
    }

    public function getCompanies($filters = [], $page = 1, $limit = 10)
    {
        $qb = $this->getModelManager()->createQueryBuilder();
        $qb->select('c, o, oh')
                ->from('TestCompanyBundle:Company', 'c')
                ->innerJoin('c.offices', 'o')
                ->innerJoin('o.openingHours', 'oh')
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

        $query = $qb->getQuery();
        $query->setParameters($parameters);

        return $query->getResult();
    }

}
