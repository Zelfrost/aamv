<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\News;
use AppBundle\Form\Type\NewsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends Controller
{
    /**
     * @Route(path="/admin/news", name="admin_news")
     */
    public function indexAction()
    {
        $news = $this->getDoctrine()
            ->getRepository(News::class)
            ->findAll();

        return $this->render('AppBundle:Admin:News/index.html.twig', array(
            'news' => $news
        ));
    }

    /**
     * @Route(path="/admin/news/create", name="admin_news_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $news = new News();
        $news->setImportant(false);

        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $news->setAuthor($this->getUser());

            $this->getDoctrine()
                ->getManager()
                ->persist($news);

            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('admin.news.success', "La news a bien été crée.");

            return $this->redirect($this->generateUrl('admin_news'));
        }

        return $this->render('AppBundle:Admin:News/create.html.twig', array(
            'news' => $news,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/news/edit/{id}", name="admin_news_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, News $news)
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $news->setUpdatedAt(new \DateTime());

            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('admin.news.success', "La news a bien été modifiée.");

            return $this->redirect($this->generateUrl('admin_news'));
        }

        return $this->render('AppBundle:Admin:News/edit.html.twig', array(
            'news' => $news,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/news/delete/{id}", name="admin_news_delete")
     * @Method("DELETE")
     */
    public function deleteAction(News $news)
    {
        $this->getDoctrine()
            ->getManager()
            ->remove($news);

        $this->getDoctrine()
            ->getManager()
            ->flush();

        $this->get('session')->getFlashBag()->add('admin.news.success', "La news a bien été supprimée.");

        return $this->redirect($this->generateUrl('admin_news'));
    }
}
