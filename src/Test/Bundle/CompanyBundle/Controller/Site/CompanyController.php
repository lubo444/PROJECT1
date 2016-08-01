<?php

namespace Test\Bundle\CompanyBundle\Controller\Site;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Test\Bundle\CompanyBundle\Entity\Company;
use Test\Bundle\CompanyBundle\Entity\Week;
use Test\Bundle\CompanyBundle\Form\FilterType;
use Test\Bundle\CompanyBundle\Form\CompanyType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CompanyController extends Controller
{

    private function getRoutes()
    {
        $router = $this->container->get('router');
        /** @var $collection \Symfony\Component\Routing\RouteCollection */
        $collection = $router->getRouteCollection();
        $allRoutes = $collection->all();

        $routes = array();

        /** @var $params \Symfony\Component\Routing\Route */
        foreach ($allRoutes as $route => $params) {
            $defaults = $params->getDefaults();

            if (isset($defaults['_controller'])) {
                $controllerAction = explode(':', $defaults['_controller']);
                $controller = $controllerAction[0];

                if (!isset($routes[$controller])) {
                    $routes[$controller] = array();
                }

                $routes[$controller][] = $route;
            }
        }

        return $thisRoutes = isset($routes[get_class($this)]) ?
                $routes[get_class($this)] : null;
    }

    /**
     * @Route("/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1}, name="test_company_list")
     * @Template("TestCompanyBundle:Homepage:list.html.twig")
     */
    public function companiesListAction(Request $request, $page)
    {
        $form = $this->createForm(new FilterType());
        $form->handleRequest($request);

        $filters = [];

        if ($this->isGranted('ROLE_ADMIN')) {
            $filters['roleAdmin'] = true;
        }

        if ($form->isSubmitted()) {
            $data = $form->getData();

            $filters['name'] = $data['title'];
            $filters['day'] = $data['day'];
            $filters['hour'] = $data['hour'];
        }

        $em = $this->getDoctrine()->getManager();
        $companies = $em->getRepository('TestCompanyBundle:Company')->getCompanies($filters, $page);
        //$companies = $em->getRepository('TestCompanyBundle:Company')->findAll();
        /*
        echo '<pre>';
        dump($companies);
        echo '</pre>';
        die;/**/
        return [
            'companies' => $companies,
            'daysInWeek' => Week::getDaysInWeek(),
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/company/create", name="test_company_create")
     * @Template("TestCompanyBundle:Form:basic.html.twig")
     */
    public function registerCompanyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $loggedUserId = $this->get('test.authorization')->getAuthenticatedUserId();

        $company = new Company();
        $company->setCreatedBy($loggedUserId);
        $form = $this->createForm(new CompanyType(), $company);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $title = $form->getData()->getTitle();
            $company->setTitle($title);

            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            return $this->redirectToRoute('test_company_list', array(), 301);
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/company/{itemId}/edit", requirements={"itemId" = "\d+"}, name="test_company_edit")
     * @Template("TestCompanyBundle:Form:basic.html.twig")
     */
    public function companyEditAction(Request $request, $itemId)
    {
        $em = $this->getDoctrine()->getManager();

        $company = $em->getRepository('TestCompanyBundle:Company')->find($itemId);

        if (!$company) {
            return $this->get('test.error_manager')->getFlashBagError('Object not found!', ['companyId' => $itemId]);
        }

        $this->get('test.authorization')->checkAccessItem($company);

        $form = $this->createForm(new CompanyType(), $company);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();

                return $this->redirectToRoute('test_company_list', array(), 301);
            }
        }

        return ['form' => $form->createView()];
    }

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
            return $this->get('test.error_manager')->getFlashBagError('Object not found!', ['companyId' => $itemId]);
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

}
