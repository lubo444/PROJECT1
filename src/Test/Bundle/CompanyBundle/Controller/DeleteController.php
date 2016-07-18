<?php

namespace Test\Bundle\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DeleteController extends Controller
{
    
    /**
     * @Route("/company/{itemId}/delete/{undelete}",
     *  requirements={"itemId" = "\d+", "undelete" = "\d+"},
     *  defaults={"undelete" = null},
     *  name="test_company_delete")
     * @Template()
     */
    public function deleteCompanyAction(Request $request, $itemId, $undelete)
    {

        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('TestCompanyBundle:Company')->find($itemId);

        if (!$company) {
            return $this->get('test.error_manager')->getFlashBagError('Object not found!');
        }

        $this->get('test.authorization')->checkAccessItem($company);

        if ($undelete) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $company->setActive(true);
            }
        } else {
            $company->setActive(false);
        }

        $em->persist($company);
        $em->flush();

        return $this->redirectToRoute('test_company_list');
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

    /**
     * @Route("/opening-hours/{itemId}/delete/{undelete}",
     *  requirements={"itemId" = "\d+", "undelete" = "\d+"},
     *  defaults={"undelete" = null},
     *  name="test_opening_hours_delete")
     * @Template()
     */
    public function deleteOpeningHoursAction(Request $request, $itemId, $undelete)
    {
        $em = $this->getDoctrine()->getManager();
        $openingHours = $em->getRepository('TestCompanyBundle:OpeningHours')->find($itemId);

        if (!$openingHours) {
            return $this->get('test.error_manager')->getFlashBagError('Object not found!');
        }
        
        $this->get('test.authorization')->checkAccessItem($openingHours);

        if ($undelete) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $openingHours->setActive(true);
            }
        } else {
            $openingHours->setActive(false);
        }

        $officeId = $openingHours->getIdOffice()->getIdOffice();

        $em->persist($openingHours);
        $em->flush();

        return $this->redirectToRoute('test_opnng_hrs', array('officeId' => $officeId), 301);
    }
    
}
