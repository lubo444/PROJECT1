<?php

namespace Test\Bundle\CompanyBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use Test\Bundle\CompanyBundle\Form\RestOpeningHoursType;
use Test\Bundle\CompanyBundle\Entity\OpeningHours;
use Test\Bundle\CompanyBundle\Entity\Week;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as BaseRoute;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @RouteResource("OpeningHours")
 */
class OpeningHoursController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @BaseRoute("/office/{officeId}",
     *  requirements={"officeId" = "\d+"},
     *  name="test_api_opnng_hrs")
     * @Template("TestCompanyBundle:Office:detail.html.twig")
     */
    public function openingHoursListAction(Request $request, $officeId)
    {
        $cacheManager = $this->get('test.cache_manager');
        
        $office = $cacheManager->getCachedObject('TestCompanyBundle:Office', $officeId);
        
        //check parents active status
        if(!$office || !$office->getActive() || !$office->getIdCompany()->getActive()){
            return $this->get('test.error_manager')->getFlashBagError('Object not found!');
        }
        
        return [
            'daysInWeek' => Week::getDaysInWeek(),
            'office' => $office
        ];
    }
    
    /**
     * @BaseRoute("/opening-hours/{itemId}/delete/{undelete}",
     *  requirements={"itemId" = "\d+", "undelete" = "\d+"},
     *  defaults={"undelete" = null},
     *  name="test_api_opening_hours_delete")
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
    
    
    
    
    //////////////// REST ////////////////////////////////////////
    
    /**
     * @ApiDoc()
     */
    public function cgetAction(Request $request, $companyId, $officeId)
    {

        $em = $this->getDoctrine()->getManager();
        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);

        //company does'n exist
        if (!$office) {
            return $this->handleView($this->view());
        }

        //set object's associations to null (One-To-Many bidirectional - remove one direction)
        //error "A circular reference has been detected"

        $office->setIdCompany(null);
        $oh = $office->getOpeningHours();
        foreach ($oh as $hour) {
            $hour->setIdOffice(null);
        }

        $view = $this->view($office, 200);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     */
    public function postAction(Request $request, $companyId, $officeId)
    {
        $em = $this->getDoctrine()->getManager();

        //TODO get user id
        $userId = 1;

        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);

        $opnngHrs = new OpeningHours();
        $opnngHrs->setIdOffice($office);
        $opnngHrs->setCreatedBy($userId);

        $form = $this->get('form.factory')->createNamed(null, new RestOpeningHoursType(), $opnngHrs);
        $form->submit($request);

        if ($form->isValid()) {
            $em->persist($opnngHrs);
            $em->flush();

            $view = $this->view(['id' => $opnngHrs->getIdOpnngHrs()], Codes::HTTP_CREATED);
            return $this->handleView($view);
        }

        $view = $this->view($form, Codes::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     */
    public function putAction(Request $request, $companyId, $officeId, $opnngHrsId)
    {
        $em = $this->getDoctrine()->getManager();

        $opnngHrs = $em->getRepository('TestCompanyBundle:OpeningHours')->find($opnngHrsId);

        $form = $this->get('form.factory')->createNamed(null, new RestOpeningHoursType('PUT'), $opnngHrs, ['method' => 'PUT']);
        $form->submit($request);

        if ($form->isValid()) {
            $em->merge($opnngHrs);
            $em->flush();

            $view = $this->view([], Codes::HTTP_OK);
            return $this->handleView($view);
        }

        $view = $this->view($form, Codes::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     */
    public function patchAction(Request $request, $companyId, $officeId, $opnngHrsId)
    {
        $em = $this->getDoctrine()->getManager();

        $opnngHrs = $em->getRepository('TestCompanyBundle:OpeningHours')->find($opnngHrsId);

        $form = $this->get('form.factory')->createNamed(null, new RestOpeningHoursType(), $opnngHrs);
        $form->submit($request);

        if ($form->isValid()) {
            $em->persist($opnngHrs);
            $em->flush();

            $view = $this->view([], Codes::HTTP_OK);
            return $this->handleView($view);
        }

        $view = $this->view($form, Codes::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     */
    public function deleteAction(Request $request, $companyId, $officeId, $opnngHrsId)
    {
        $em = $this->getDoctrine()->getManager();
        $opnngHrs = $em->getRepository('TestCompanyBundle:OpeningHours')->find($opnngHrsId);

        $opnngHrs->setActive(false);

        $em->persist($opnngHrs);
        $em->flush();

        $view = $this->view([], Codes::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     * 
     * @Rest\Put("/companies/{companyId}/offices/{officeId}/openinghours/{opnngHrsId}/undelete")
     */
    public function undeleteAction(Request $request, $companyId, $officeId, $opnngHrsId)
    {
        $em = $this->getDoctrine()->getManager();
        $opnngHrs = $em->getRepository('TestCompanyBundle:OpeningHours')->find($opnngHrsId);

        $opnngHrs->setActive(true);

        $em->persist($opnngHrs);
        $em->flush();

        $view = $this->view([], Codes::HTTP_OK);
        return $this->handleView($view);
    }
    

}
