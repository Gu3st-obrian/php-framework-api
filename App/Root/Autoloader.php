<?php
namespace App;

class Autoloader
{	
	public static function Register() {
		spl_autoload_register(array(__CLASS__, 'appLoader'));
	}

	public static function appLoader($classe) {
		$classe = str_replace('\\', '/', $classe);
		require_once $classe . '.php';
	}
}
