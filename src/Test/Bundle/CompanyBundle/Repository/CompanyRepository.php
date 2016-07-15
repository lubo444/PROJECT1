<?php

namespace Test\Bundle\CompanyBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Test\Bundle\CompanyBundle\Entity\Company;
use Test\Bundle\CompanyBundle\Entity\Office;
use Test\Bundle\CompanyBundle\Entity\OpeningHours;

/**
 * Description of CompanyRepository
 *
 * @author lubomir.ferenc
 */
class CompanyRepository extends EntityRepository
{

    public function getCompanies($filters = [], $page = 1, $limit = 100)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c, o, oh')
                ->leftJoin('c.offices', 'o')
                ->leftJoin('o.openingHours', 'oh')
                ->orderBy('c.title', 'ASC')
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit);

        $parameters = [];

        foreach ($filters as $filterName => $filterValue) {
            if ($filterValue === null) {
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

        if (!isset($filters['roleAdmin']) || !$filters['roleAdmin']) {
            $qb->andWhere('c.active = 1');
            $qb->andWhere('o.active = 1 OR o.idOffice IS NULL');
            $qb->andWhere('oh.active = 1 OR oh.idOpnngHrs IS NULL');
        }
        
        $query = $qb->getQuery();
        $query->setParameters($parameters);

        return $query->getResult();
    }

    public function insertCompanies($rows)
    {
        $em = $this->getEntityManager();

        foreach ($rows as $row) {
            $company = $em->getRepository('TestCompanyBundle:Company')->findOneBy(
                    ['title' => $row['companyName']]
            );

            if (!$company) {
                $company = new Company();
                $company->setCreatedBy($row['userCreatedBy']);
                $company->setTitle($row['companyName']);
                $company->setCreatedAt(new \DateTime());
                $em->persist($company);
                $em->flush();
            }

            $office = $em->getRepository('TestCompanyBundle:Office')->findOneBy(
                    [
                        'idCompany' => $company->getIdCompany(),
                        'address' => $row['officeAddress']
                    ]
            );

            if (!$office) {
                $office = new Office($row['userCreatedBy']);
                $office->setAddress($row['officeAddress']);
                $office->setCreatedAt(new \DateTime());
                $office->setIdCompany($company);
                $em->persist($office);
                $em->flush();
            }
            foreach (range(1, 7) as $i) {
                if ($row['oh' . $i] == '' || $row['ch' . $i] == '') {
                    continue;
                }
                
                $dayInWeek = $i%7;
                
                $openingHour = new OpeningHours($row['userCreatedBy']);
                $openingHour->setDayInWeek($dayInWeek);
                $openingHour->setCreatedAt(new \DateTime());
                $openingHour->setIdOffice($office);
                $openingHour->setStartAt($row['oh' . $i]);
                $openingHour->setEndAt($row['ch' . $i]);
                $openingHour->setLunchStartAt($row['ls' . $i]);
                $openingHour->setLunchEndAt($row['le' . $i]);
                $em->persist($openingHour);
            }

            $em->flush();
            $em->clear();
        }
    }

}
