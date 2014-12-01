<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NewsController
{

	/**
	 * @Route("/")
	 * @Template("")
	 */
	public function indexAction()
	{
		return [];
	}
}
