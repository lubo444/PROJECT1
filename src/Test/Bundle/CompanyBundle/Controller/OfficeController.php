<?php

namespace Test\Bundle\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Test\Bundle\CompanyBundle\Form\RestOfficeType;
use Test\Bundle\CompanyBundle\Entity\Office;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class OfficeController extends Controller
{

    
    /**
     * @Route("/company/{companyId}", requirements={"companyId" = "\d+"}, name="test_office_list")
     * @Template("TestCompanyBundle:Office:list.html.twig")
     */
    public function officesListAction(Request $request, $companyId)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        //check parents active status
        $company = $em->getRepository('TestCompanyBundle:Company')->find($companyId);
        
        if(!$company || !$company->getActive()){
            return $this->get('test.error_manager')->getFlashBagError('Object not found!');
        }
        
        //get data
        $qb = $em->createQueryBuilder();
        
        $qb->select('o')
            ->from('TestCompanyBundle:Office', 'o')
            ->innerJoin('o.idCompany', 'c')
            ->where('o.idCompany = :idCompany')
            ->setParameter('idCompany', $companyId);
        
        if(!$this->isGranted('ROLE_ADMIN')){
            $qb->andWhere('c.active = :active')
                ->andWhere('o.active = :active')
                ->setParameter('active', 1);
        }
        
        $offices = $qb->getQuery()->getResult();
        /*
        return [
            'offices' => $offices,
            'company' => $company
        ];/***/
        
        $tmp = $this->render(
            'TestCompanyBundle:Office:list.html.twig',
                [
                'offices' => $offices,
                'company' => $company
            ]
        );
        
        return $tmp;
        
        echo '<pre>';
        dump($tmp);
        echo '</pre>';
        die;
        
        
    }
    
    
    /**
     * @Route("/office/{itemId}/delete/{undelete}",
     *  requirements={"itemId" = "\d+", "undelete" = "\d+"},
     *  defaults={"undelete" = null},
     *  name="test_office_delete")
     * @Template()
     */
    public function deleteOfficeAction(Request $request, $itemId, $undelete)
    {
        $em = $this->getDoctrine()->getManager();
        $office = $em->getRepository('TestCompanyBundle:Office')->find($itemId);

        if (!$office) {
            return $this->get('test.error_manager')->getFlashBagError('Object not found!');
        }

        $this->get('test.authorization')->checkAccessItem($office);

        if ($undelete) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $office->setActive(true);
            }
        } else {
            $office->setActive(false);
        }

        $companyId = $office->getIdCompany()->getIdCompany();

        $em->persist($office);
        $em->flush();
        
        $cacheManager = $this->get('test.cache_manager');
        $cacheManager->deleteCachedObject('TestCompanyBundle:Office', $itemId);

        return $this->redirectToRoute('test_office_list', array('companyId' => $companyId), 301);
    }

    
    
}
