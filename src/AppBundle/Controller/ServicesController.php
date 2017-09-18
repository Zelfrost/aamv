<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ad;
use AppBundle\Entity\Disponibility;
use AppBundle\Entity\Tool;
use AppBundle\Entity\User;
use AppBundle\Form\Type\AdFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends Controller
{
    /**
     * @Route(
     *      path="/services/ads",
     *      options={"expose" = true},
     *      name="services_ads_index"
     * )
     */
    public function adsIndexAction()
    {
        return $this->render('AppBundle:Services:ads.html.twig');
    }

    /**
     * @Route(
     *      path="/services/ads/{type}/{city}/{neighborhood}/{page}",
     *      options={"expose" = true},
     *      name="services_ads_list"
     * )
     */
    public function adsListAction($type, $city = "none", $neighborhood = "none", $page = 1)
    {
        $role = $this->get('retriever.role')->getRoleFromName($type);
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository(Ad::class)
        ;

        $ads = $repository->search(
            $role,
            $city,
            $neighborhood,
            $page
        );

        $citiesData = $repository->getCities($role);

        $cities = array();
        $neighborhoods = array();

        foreach ($citiesData as $cityData) {
            if (!in_array($cityData['city'], $cities)) {
                $cities[] = $cityData['city'];
            }

            if (!in_array($cityData['neighborhood'], $neighborhoods)) {
                $neighborhoods[] = $cityData['neighborhood'];
            }
        }

        $parameters = [
            'ads' => $ads,
            'type' => $type,
            'city' => $city,
            'cities' => $cities,
            'neighborhood' => $neighborhood,
            'neighborhoods' => $neighborhoods,
            'pagination' => [
                'route' => 'services_ads_list',
                'page' => $page,
                'pages_count' => $ads->count() / 10,
                'parameters' => [
                    'type' => $type,
                    'city' => $city,
                    'neighborhood' => $neighborhood,
                ]
            ]
        ];

        return $this->render('AppBundle:Services:ads_list.html.twig', $parameters);
    }

    /**
     * @Route(path="/services/ad/{id}", requirements={"id" = "\d+"}, name="services_ad")
     */
    public function AdAction(Ad $ad)
    {
        if (null === $this->getUser() || ($ad->getAuthor()->getId() !== $this->getUser()->getId())) {
            $ad->addView();

            $this->getDoctrine()
                ->getManager()
                ->flush();
        }

        if ($ad === null) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render(
            'AppBundle:Services:ad.html.twig',
            array('ad' => $ad)
        );
    }

    /**
     * @Route(
     *      path="/services/disponibilities/{city}/{neighborhood}/{page}",
     *      options={"expose" = true},
     *      name="services_disponibilities"
     * )
     */
    public function disponibilitiesAction($city = "none", $neighborhood = "none", $page = 1)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Disponibility::class)
        ;

        $disponibilities = $repository->search($city, $neighborhood, $page);

        $citiesData = $repository->getCities();

        $cities = array();
        $neighborhoods = array();

        foreach ($citiesData as $cityData) {
            if (!in_array($cityData['city'], $cities)) {
                $cities[] = $cityData['city'];
            }

            if (!in_array($cityData['neighborhood'], $neighborhoods)) {
                $neighborhoods[] = $cityData['neighborhood'];
            }
        }

        $pagesCount = ceil($disponibilities->count() / 10);

        $parameters = array(
            'disponibilities' => $disponibilities,
            'city' => $city,
            'cities' => $cities,
            'neighborhood' => $neighborhood,
            'neighborhoods' => $neighborhoods,
            'pagination' => array(
                'route' => 'service_disponibilities',
                'page' => $page,
                'pages_count' => $pagesCount
            )
        );

        return $this->render('AppBundle:Services:disponibilities.html.twig', $parameters);
    }

    /**
     * @Route(path="/services/tools", name="services_tools")
     */
    public function toolsAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository(Tool::class);

        return $this->render(
            'AppBundle:Services:tools.html.twig',
            array('tools' => array(
                'aamv' => $repository->findAamvTools(),
                'veronalice' => $repository->findVeronaliceTools(),
            ))
        );
    }
}
