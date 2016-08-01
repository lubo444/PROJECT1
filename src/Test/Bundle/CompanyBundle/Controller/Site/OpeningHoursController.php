<?php

namespace Test\Bundle\CompanyBundle\Controller\Site;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Test\Bundle\CompanyBundle\Entity\Week;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as BaseRoute;
use Test\Bundle\CompanyBundle\Entity\OpeningHours;
use Test\Bundle\CompanyBundle\Form\OpeningHoursType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class OpeningHoursController extends Controller
{

    /**
     * @BaseRoute("/office/{officeId}",
     *  requirements={"officeId" = "\d+"},
     *  name="test_opnng_hrs")
     * @Template("TestCompanyBundle:Office:detail.html.twig")
     */
    public function openingHoursListAction(Request $request, $officeId)
    {
        $cacheManager = $this->get('test.cache_manager');
        $em = $this->getDoctrine()->getManager();
        /*
        $office = $cacheManager->getCachedObject('Test\Bundle\CompanyBundle\Entity\Office', $officeId);
        //$companyId = $office->getIdCompany();
        

        //$company = $em->getRepository('TestCompanyBundle:Company')->find($companyId);
        //$office->setIdCompany($company);

        //check parents active status
        if (!$office || !$office->getActive() || !$office->getIdCompany()->getActive()) {
            return $this->get('test.error_manager')->getFlashBagError('Object not found!', ['officeId' => $officeId]);
        }

        
        $criteriaOpnngHrs['idOffice'] = $office->getIdOffice();
        if (!$this->isGranted('ROLE_ADMIN')) {
            $criteriaOpnngHrs['active'] = 1;
        }/**/

        $off = $em->getRepository('TestCompanyBundle:Office')->getOpeningHours($officeId);
        
        /*
        $openingHours = $em->getRepository('TestCompanyBundle:OpeningHours')->//findBy($criteriaOpnngHrs, ['dayInWeek' => 'ASC']);
                createQueryBuilder('oh')
                ->select('oh, o') 
                ->leftJoin('TestCompanyBundle:Office', 'o')
         ->where('oh.idOffice = :idOffice'); 
        $query = $openingHours->getQuery();
        //$query->setFetchMode('Test\Bundle\CompanyBundle\Entity\Office', 'idCompany', ClassMetadata::FETCH_EXTRA_LAZY);
        $query->setParameters(['idOffice'=>$officeId]);
/**/

        //$office->setOpeningHours($openingHours);
        
        return [
            'daysInWeek' => Week::getDaysInWeek(),
            'office' => $off[0]
        ];
    }

    /**
     * @BaseRoute("/office/{officeId}/opening-hours/create", requirements={"officeId" = "\d+"}, name="test_opening_hours_create")
     * @Template("TestCompanyBundle:Form:basic.html.twig")
     */
    public function registerOpeningHoursAction(Request $request, $officeId)
    {
        $em = $this->getDoctrine()->getManager();

        $loggedUserId = $this->get('test.authorization')->getAuthenticatedUserId();
        $opnngHours = new OpeningHours();

        $opnngHours->setCreatedBy($loggedUserId);

        $form = $this->createForm(new OpeningHoursType(), $opnngHours);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $startAt = $data->getStartAt();
            $startLunchAt = $data->getLunchStartAt();
            $endLunchAt = $data->getLunchEndAt();
            $endAt = $data->getEndAt();

            $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);

            $opnngHours->setIdOffice($office);
            $opnngHours->setStartAt($startAt);
            $opnngHours->setLunchStartAt($startLunchAt);
            $opnngHours->setLunchEndAt($endLunchAt);
            $opnngHours->setEndAt($endAt);

            $em = $this->getDoctrine()->getManager();
            $em->persist($opnngHours);
            $em->flush();

            $this->get('test.cache_manager')->updateCachedObject('Test\Bundle\CompanyBundle\Entity\Office', $officeId);

            return $this->redirectToRoute('test_opnng_hrs', array('officeId' => $officeId), 301);
        }

        return ['form' => $form->createView()];
    }

    /**
     * @BaseRoute("/opening-hours/{itemId}/edit", requirements={"itemId" = "\d+"}, name="test_opening_hours_edit")
     * @Template("TestCompanyBundle:Form:basic.html.twig")
     */
    public function editOpeningHoursAction(Request $request, $itemId)
    {
        $em = $this->getDoctrine()->getManager();
        $cacheManager = $this->get('test.cache_manager');

        $opnngHours = $em->getRepository('TestCompanyBundle:OpeningHours')->find($itemId);
        if (!$opnngHours) {
            return $this->get('test.error_manager')->getFlashBagError('Object not found!', ['openingHoursId' => $itemId]);
        }

        $this->get('test.authorization')->checkAccessItem($opnngHours);

        $form = $this->createForm(new OpeningHoursType(), $opnngHours);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();

                $officeId = $form->getData()->getIdOffice()->getIdOffice();

                $cacheManager->updateCachedObject('Test\Bundle\CompanyBundle\Entity\Office', $officeId);

                return $this->redirectToRoute('test_opnng_hrs', ['officeId' => $officeId], 301);
            }
        }

        return ['form' => $form->createView()];
    }

    /**
     * @BaseRoute("/opening-hours/{itemId}/delete/{undelete}",
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
            return $this->get('test.error_manager')->getFlashBagError('Object not found!', ['openingHoursId' => $itemId]);
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

        $cacheManager = $this->get('test.cache_manager');
        $cacheManager->updateCachedObject('Test\Bundle\CompanyBundle\Entity\Office', $officeId);

        return $this->redirectToRoute('test_opnng_hrs', array('officeId' => $officeId), 301);
    }

}
