<?php
namespace App\Controller;
use \App\Model\Utilisateurs;

class LoginController
{
	public function LoginAction($request, $response) {
		$response->render('table/user');
	}

	public function AuthAction($request, $response) {
		$username = $request->paramMap('username')->text();
		$password = $request->paramMap('password')->text();
		$users = Utilisateurs::Connexion($username, $password);
		$ipaddress = $this->tools->getIp();
	}

	public function LogoutAction($request, $response) {
		session_destroy();
		$response->withRedirect('user.login');
	}
}
