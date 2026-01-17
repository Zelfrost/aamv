<?php

namespace AppBundle\Controller;

use AppBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends Controller
{
    /**
     * @Route(path="/", name="homepage")
     * @Route(path="/news/{page}", name="homepage_news")
     */
    public function indexAction(Request $request, $page = 1)
    {
        if (0 < count($request->query->all()) && ['page'] !== array_keys($request->query->all())) {
            return new Response(null, Response::HTTP_GONE);
        }

        $repository = $this->getDoctrine()->getRepository('AppBundle\Entity\News');

        $pagination = array(
            'page'        => $page,
            'pages_count' => ceil($repository->count() / 10),
            'parameters'  => array()
        );

        $news = $repository->search($page);

        $options = array('news' => $news, 'pagination' => $pagination);
        $options['pagination']['route'] = 'homepage_news';

        return $this->render(
            'AppBundle:Homepage:index.html.twig',
            $options
        );
    }

    /**
     * @Route(path="/new/{id}", name="homepage_new")
     */
    public function newAction($id)
    {
        $news = $this->getDoctrine()
            ->getManager()
            ->getRepository(News::class)
            ->find($id);

        if ($news === null) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render(
            'AppBundle:Homepage:news.html.twig',
            array('news' => $news)
        );
    }
}
