<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DiversController extends AbstractController
{
    /**
     * @Route(path="/divers/questions_answers", name="divers_questions_answers")
     */
    public function questionsAnswersAction()
    {
        return $this->render('@AppBundle/Divers/questions_answers.html.twig');
    }

    /**
     * @Route(path="/divers/sites", name="divers_sites")
     */
    public function sitesAction()
    {
        return $this->render('@AppBundle/Divers/sites.html.twig');
    }
}
