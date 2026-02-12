<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ad;
use AppBundle\Entity\Disponibility;
use AppBundle\Entity\Tool;
use AppBundle\Entity\Category;
use AppBundle\Entity\User;
use AppBundle\Form\Type\AdFormType;
use AppBundle\Service\Retriever\RoleRetriever;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends AbstractController
{
    private ManagerRegistry $doctrine;
    private RoleRetriever $roleRetriever;

    public function __construct(ManagerRegistry $doctrine, RoleRetriever $roleRetriever)
    {
        $this->doctrine = $doctrine;
        $this->roleRetriever = $roleRetriever;
    }

    /**
     * @Route(
     *      path="/services/ads",
     *      options={"expose" = true},
     *      name="services_ads_index"
     * )
     */
    public function adsIndexAction()
    {
        return $this->render('@AppBundle/Services/ads.html.twig');
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
        $role = $this->roleRetriever->getRoleFromName($type);
        $repository = $this->doctrine
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
                'pages_count' => ceil($ads->count() / 10),
                'parameters' => [
                    'type' => $type,
                    'city' => $city,
                    'neighborhood' => $neighborhood,
                ]
            ]
        ];

        return $this->render('@AppBundle/Services/ads_list.html.twig', $parameters);
    }

    /**
     * @Route(path="/services/ad/{id}", requirements={"id" = "\d+"}, name="services_ad")
     */
    public function AdAction(Ad $ad)
    {
        if (null === $this->getUser() || ($ad->getAuthor()->getId() !== $this->getUser()->getId())) {
            $ad->addView();

            $this->doctrine
                ->getManager()
                ->flush();
        }

        if ($ad === null || $ad->getCreatedAt() < new \DateTime('-1 month')) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render(
            '@AppBundle/Services/ad.html.twig',
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
        $repository = $this->doctrine
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
                'route' => 'services_disponibilities',
                'page' => $page,
                'pages_count' => $pagesCount,
                'parameters' => [
                    'city' => $city,
                    'neighborhood' => $neighborhood,
                ],
            )
        );

        return $this->render('@AppBundle/Services/disponibilities.html.twig', $parameters);
    }

    /**
     * @Route(path="/services/tools/{type}", name="services_tools")
     */
    public function toolsAction($type = 'public')
    {
        if (!in_array($type, ['public', 'members'])) {
            $type = 'public';
        }

        $tools = 'public' === $type
            ? $this->doctrine->getManager()->getRepository(Tool::class)->findFiles(Tool::TOOL_TYPE)
            : []
        ;

        $categories = $this->doctrine
            ->getManager()
            ->getRepository(Category::class)
            ->findFiles(Tool::TOOL_TYPE, 'members' === $type)
        ;

        return $this->render(
            '@AppBundle/Services/tools.html.twig',
            array('tools' => $tools, 'categories' => $categories, 'type' => $type)
        );
    }

    /**
     * @Route(path="/services/docs/{type}", name="services_docs")
     */
    public function docsAction($type = 'public')
    {
        if (!in_array($type, ['public', 'members'])) {
            $type = 'public';
        }

        $tools = 'public' === $type
            ? $this->doctrine->getManager()->getRepository(Tool::class)->findFiles(Tool::DOC_TYPE)
            : []
        ;

        $categories = $this->doctrine
            ->getManager()
            ->getRepository(Category::class)
            ->findFiles(Tool::DOC_TYPE, 'members' === $type)
        ;

        return $this->render(
            '@AppBundle/Services/docs.html.twig',
            array('tools' => $tools, 'categories' => $categories, 'type' => $type)
        );
    }
}
