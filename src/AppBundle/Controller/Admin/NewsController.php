<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\News;
use AppBundle\Form\Type\NewsType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route(path="/admin/news", name="admin_news")
     */
    public function indexAction()
    {
        $news = $this->doctrine
            ->getRepository(News::class)
            ->findAll();

        return $this->render('@AppBundle/Admin/News/index.html.twig', array(
            'news' => $news
        ));
    }

    /**
     * @Route(path="/admin/news/create", name="admin_news_create", methods={"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $news = new News();
        $news->setImportant(false);

        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $news->setAuthor($this->getUser());

            $this->doctrine
                ->getManager()
                ->persist($news);

            $this->doctrine
                ->getManager()
                ->flush();

            $request->getSession()->getFlashBag()->add('admin.news.success', "La news a bien été crée.");

            return $this->redirect($this->generateUrl('admin_news'));
        }

        return $this->render('@AppBundle/Admin/News/create.html.twig', array(
            'news' => $news,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/news/edit/{id}", name="admin_news_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, News $news)
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $news->setUpdatedAt(new \DateTime());

            $this->doctrine
                ->getManager()
                ->flush();

            $request->getSession()->getFlashBag()->add('admin.news.success', "La news a bien été modifiée.");

            return $this->redirect($this->generateUrl('admin_news'));
        }

        return $this->render('@AppBundle/Admin/News/edit.html.twig', array(
            'news' => $news,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/news/delete/{id}", name="admin_news_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, News $news)
    {
        $this->doctrine
            ->getManager()
            ->remove($news);

        $this->doctrine
            ->getManager()
            ->flush();

        $request->getSession()->getFlashBag()->add('admin.news.success', "La news a bien été supprimée.");

        return $this->redirect($this->generateUrl('admin_news'));
    }
}
