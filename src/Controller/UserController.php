<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\JsonConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
	const SALT = 'as13';

	/**
	 * @Route("/user", name="user")
	 */
	public function index(): Response
	{
		$users = $this->getDoctrine()->getRepository(User::class)->findAll();

		/**
		 * Zde by se v REST API posilal JsonResponse s daty
		 * javascript by potom tyhle data rozlozil do sablony
		 */

		return $this->render('user/index.html.twig', [
			'users' => $users,
		]);
	}

	/**
	 * @Route("/user/add", name="addUser")
	 */
	public function add(Request $request, JsonConverter $jsonConverter): Response
	{
		$content = $jsonConverter->convertRequestToArray($request->getContent());

		/**
		 * po validaci z javascriptu na frontendu by
		 * zde probihala finalni validace dat z formulare
		 * pred ulozenim do databaze
		 */

		if (count($content) > 0) {

			$user = (new User)
				->setName(urldecode($content['username']))
				->setPassword(sha1(self::SALT . urldecode($content['password'])))
				->setEmail(urldecode($content['email']))
				->setPrivilege(array_key_exists('privilege', $content));

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($user);
			$entityManager->flush();
		}

		/** v REST API by zde byl navratovy status jestli se ukladani povedlo nebo ne */
		return $this->render('user/addUser.html.twig', []);
	}

}
