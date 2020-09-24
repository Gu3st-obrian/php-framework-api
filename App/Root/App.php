<?php
namespace App;
use \App\Root\Router;
use \App\Root\Request;
use \App\Root\Response;
use \App\Root\Crypto;
use \Exception;

class App
{
	private $api;
	private $url;
	private $guard;
	private $crypto;
	private $routes;

	public function __construct($container, $urlpage) {
		$this->api = $container;
		$this->url = '/'. $urlpage;
		$this->crypto = new Crypto($_SESSION['crypto']);
		unset($_SESSION['crypto']);
	}

	public function setRoute($urlpath, $urlname, $mixed) {
		$this->guard = $urlpath;
		$mixed = explode('::', $mixed);
		$this->routes[$urlpath] = new Router($urlpath, $urlname, $mixed[0], $mixed[1]);
		return $this;
	}

	public function Guardian($middleware) {
		$classfile = "App/Utilitaire/$middleware.php";
		if (!file_exists($_SESSION['racine'] . $classfile)) {
			throw new Exception("The Guardian class file $classfile are not founded.", 1);
		}
		if (isset($this->guard)) {
			$this->routes[$this->guard]->setGuard($middleware);
			$this->guard = null;
		}
		else {
			throw new Exception("The Guardian is not properly defined in the routes file.", 1);
		}
	}

	public function run() {
		if (isset($this->routes[$this->url])) {
			$route = $this->routes[$this->url];
			$namespace = '\\App\\Controller\\';
			$nsController = $namespace . $route->getController();
			$nsFunction = $route->getCallback();
			$nsGuardian = $route->getGuardian();
			$request = new Request($this->url);
			$response = new Response($this->routes, $this->crypto);
			if (isset($nsGuardian)) {
				try {
					$nsGuardian($request, $response);
				}
				catch (Exception $e) {
					throw new Exception("The Guardian $nsGuardian is not valid.", 1);
				}
			}
			$manager = new $nsController($this->api);
			$manager->$nsFunction($request, $response);
			exit();
		}

		echo "<h1>Erreur 404.</h1><br/>Page introuvable.";
		exit();
	}
}
