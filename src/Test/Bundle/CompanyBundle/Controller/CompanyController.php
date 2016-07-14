<?php

namespace Test\Bundle\CompanyBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\View as AnnoView;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;

class CompanyController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @ApiDoc()
     */ 
    public function cgetAction()
    {
        $page = 1;
        $data = ['bim', 'bam', 'bingo'];
        $view = new View($data, 200);

        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     */
    public function postAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $company = new \Test\Bundle\CompanyBundle\Entity\Company(1);
        $form = $this->get('form.factory')->createNamed('', new \Test\Bundle\CompanyBundle\Form\RestCompanyType(), $company);
        $form->submit($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            $view = $this->view(['id' => $company->getIdCompany()], Codes::HTTP_CREATED);
            return $this->handleView($view);
        }
        
        $view = $this->view($form, Codes::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     * @Rest\Put("/companies/{companyId}", requirements={"companyId" = "\d+"})
     */
    public function putAction()
    {
        $page = 1;
        $data = ['bim', 'bam', 'bingo'];
        $view = new View($data, 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/postoffice")
     */
    public function postarAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $company = new \Test\Bundle\CompanyBundle\Entity\Company();
        $form = $this->createForm(new \Test\Bundle\CompanyBundle\Form\CompanyType(), $company);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('session')->getFlashBag()->set('article', 'Article is stored at path: ' . $form->getData()->getPath());

            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            $view = View::createRouteRedirect('test_office_list', ['companyId' => $form->getData()->getIdCompany()]);
        } else {
            $view = View::create($form);
            $view->setTemplate('TestCompanyBundle:Form:basic.html.twig');
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

}
