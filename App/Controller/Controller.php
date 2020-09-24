<?php
namespace App\Controller;
use \Exception;

class Controller
{
	private $container;

	public function __construct($api) {
		$this->container = $api;
	}

	public function __get($prop) {
		if (isset($this->container[$prop])) {
			return call_user_func($this->container[$prop]);
		}

		throw new Exception("The property <<$prop>> requested is not defined.", 1);
	}
}
