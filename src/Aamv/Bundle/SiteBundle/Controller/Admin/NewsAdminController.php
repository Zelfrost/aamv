<?php

namespace Aamv\Bundle\SiteBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Aamv\Bundle\DefaultBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Aamv\Bundle\SiteBundle\Entity\News;

class NewsAdminController extends AbstractController
{
    private static $message = array(
        'not found' => array(
            'class' => 'warning',
            'value' => 'Aucune news ne correspond à cet ID'
        )
    );

    public function indexAction($page)
    {

        $resultsPerPage = $this->container->getParameter('news.results_per_page');

        $results = $this->get('aamv_site.news.news_finder')->getNews($page, $resultsPerPage);
        $results['pagination']['route'] = 'aamv_admin_news';

        $messages = array('messages' => array());
        foreach ($this->get('session')->getFlashBag()->get('admin_news_notice') as $notice) {
            if (array_key_exists($notice, NewsAdminController::$message)) {
                $messages['messages'][] = NewsAdminController::$message[$notice];
            }
        }
        $results = array_merge($results, $messages);

        return $this->render(
            'AamvSiteBundle:Admin/News:index.html.twig',
            $results
        );
    }

    public function createAction(Request $request)
    {
        $news = new News();
        $news->setAuthor($this->getUser());

        $form = $this->createForm('news_form', $news);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->persistAndFlush($news);

            return $this->redirect($this->generateUrl('aamv_admin_news'));
        }

        return $this->render(
            'AamvSiteBundle:Admin/News:create.html.twig',
            array('form' => $form->createView())
        );
    }

    public function editAction($id, Request $request)
    {
        $news = $this->getRepository('AamvSiteBundle:News')
            ->findOneById($id);

        if (null !== $news) {
            $form = $this->createForm('news_form', $news);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $news->setUpdatedAt(new \DateTime());
                $this->persistAndFlush($news);

                return $this->redirect($this->generateUrl('aamv_admin_news'));
            }

            return $this->render(
                'AamvSiteBundle:Admin/News:edit.html.twig',
                array('form' => $form->createView())
            );
        }

        $this->get('session')->getFlashBag()->add(
            'admin_news_notice',
            'not found'
        );

        return $this->redirect($this->generateUrl('aamv_admin_news'));
    }

    public function deleteAction($id)
    {
        $news = $this->getRepository('AamvSiteBundle:News')
            ->findOneById($id);

        if (null !== $news) {
            $this->getEntityManager()
                ->remove($news);

            $this->getEntityManager()
                ->flush();

            return $this->redirect($this->generateUrl('aamv_admin_news'));
        }

        $this->get('session')->getFlashBag()->add(
            'admin_news_notice',
            'not found'
        );

        return $this->redirect($this->generateUrl('aamv_admin_news'));
    }
}
