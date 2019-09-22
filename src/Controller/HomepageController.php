<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
	/**
	 * @Route("/", name="homepage")
	 */
	public function home()
	{
		return $this->render('base.html.twig', []);

	}
}