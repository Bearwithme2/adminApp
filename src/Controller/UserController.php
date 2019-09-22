<?php

namespace App\Controller;

use App\Entity\User;
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
		$users = $this->getDoctrine()
			->getRepository(User::class)
			->findAll();

		return $this->render('user/index.html.twig', [
			'users' => $users,
		]);
	}

	/**
	 * @Route("/user/add", name="addUser")
	 */
	public function add(Request $request): Response
	{
		$c = $this->convertToJson($request->getContent());
		$content = json_decode($c, TRUE);

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


		return $this->render('user/addUser.html.twig', []);
	}

	private function convertToJson($data): string
	{
		$e = explode('&', $data);
		$a = [];
		foreach ($e as $item) {
			$b = explode('=', $item);
			if (array_key_exists(1, $b)) {
				$a[$b[0]] = $b[1];
			}
		}

		return json_encode($a);
	}

}
