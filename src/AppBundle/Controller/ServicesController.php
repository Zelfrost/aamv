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
     *      path="/services/ads/{type}/{city}/{neighborhood}/{page}",
     *      options={"expose" = true},
     *      name="services_ads"
     * )
     */
    public function adsNewAction($type = "none", $city = "none", $neighborhood = "none", $page = 1)
    {
        $roleRetriever = $this->get('role_retriever');
        $type = ($type === "none")
            ? ($this->getUser() === null)
                ? 'assistante'
                : $roleRetriever->getOppositeNameFromUser($this->getUser()->getRoles())
            : $type;
        $role = $roleRetriever->getRoleFromName($type);

        $ads = $this->getDoctrine()
            ->getManager()
            ->getRepository(Ad::class)
            ->search($role, $city, $neighborhood, $page);

        $cities = array();
        foreach ($ads as $ad) {
            $adCity = $ad->getAuthor()->getCity();
            if (! in_array($adCity, $cities)) {
                $cities[] = $adCity;
            }
        }

        $neighborhoods = array();
        foreach ($ads as $ad) {
            $adNeighborhood = $ad->getAuthor()->getNeighborhood();
            if (! in_array($adNeighborhood, $neighborhoods)) {
                $neighborhoods[] = $adNeighborhood;
            }
        }

        $pagesCount = ceil($ads->count() / 10);

        $parameters = array(
            'ads' => $ads,
            'type' => $type,
            'city' => $city,
            'cities' => $cities,
            'neighborhood' => $neighborhood,
            'neighborhoods' => $neighborhoods,
            'pagination' => array(
                'route' => 'service_ads',
                'page' => $page,
                'pages_count' => $pagesCount,
                'parameters' => array(
                    'type' => $type,
                )
            )
        );

        return $this->render('AppBundle:Services:ads.html.twig', $parameters);
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
        $disponibilities = $this->getDoctrine()
            ->getRepository(Disponibility::class)
            ->search($city, $neighborhood, $page);

        $cities = array();
        foreach ($disponibilities as $disponibility) {
            $disponibilityCity = $disponibility->getChildminder()->getCity();
            if (! in_array($disponibilityCity, $cities)) {
                $cities[] = $disponibilityCity;
            }
        }

        $neighborhoods = array();
        foreach ($disponibilities as $disponibility) {
            $disponibilityNeighborhood = $disponibility->getChildminder()->getNeighborhood();
            if (! in_array($disponibilityNeighborhood, $neighborhoods)) {
                $neighborhoods[] = $disponibilityNeighborhood;
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
