<?php
namespace App\Root;
use \Exception;

class Response
{
	private $routes;
	private $crypto;
	
	public function __construct($routes, $crypto) {
		$this->routes = $routes;
		$this->crypto = $crypto;
	}

	public function pathFor($urlpage) {
		foreach ($this->routes as $route) {
			if ($route->getUri() == $urlpage) {
				return $_SESSION['radical'] . $route->getUrl();
			}
		}

		throw new Exception("Route $urlpage is not found.", 1);
	}

	public function withRedirect($urlpage) {
		$urlpage = $this->pathFor($urlpage);
		header('Location: '. $urlpage);
		exit();
	}

	public function render($html, $variables = [], $template = 'default.php') {
		$response = $this;

		if (sizeof($variables) > 0) {
			extract($variables);
		}

		ob_start();
		$blockpage = $_SESSION['vueRoot'] . $html .'.php';
		require $blockpage;
		$content = ob_get_clean();

		require $_SESSION['vueRoot'] . $template;
	}

	public function JsonXender($donnees) {
		return json_encode($donnees);
	}

	public function JsonRender($donnees) {
		print($this->JsonXender($donnees));
		exit();
	}

	public function CryptoEncrypt($plaintext, $token) {
		return $this->crypto->AesEncrypt($plaintext, $token);
	}

	public function CryptoDecrypt($ciphertext, $token) {
		return $this->crypto->AesDecrypt($ciphertext, $token);
	}
}
