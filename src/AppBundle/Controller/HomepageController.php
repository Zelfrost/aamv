<?php

namespace AppBundle\Controller;

use AppBundle\Entity\News;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route(path: '/', name: 'homepage')]
    #[Route(path: '/news/{page}', name: 'homepage_news')]
    public function indexAction(Request $request, $page = 1)
    {
        if (0 < count($request->query->all()) && ['page'] !== array_keys($request->query->all())) {
            return new Response(null, Response::HTTP_GONE);
        }

        $repository = $this->doctrine->getRepository('AppBundle\Entity\News');

        $pagination = array(
            'page'        => $page,
            'pages_count' => ceil($repository->countAll() / 10),
            'parameters'  => array()
        );

        $news = $repository->search($page);

        $options = array('news' => $news, 'pagination' => $pagination);
        $options['pagination']['route'] = 'homepage_news';

        return $this->render(
            '@AppBundle/Homepage/index.html.twig',
            $options
        );
    }

    #[Route(path: '/new/{id}', name: 'homepage_new')]
    public function newAction($id)
    {
        $news = $this->doctrine
            ->getManager()
            ->getRepository(News::class)
            ->find($id);

        if ($news === null) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render(
            '@AppBundle/Homepage/news.html.twig',
            array('news' => $news)
        );
    }
}
