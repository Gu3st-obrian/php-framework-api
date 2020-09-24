<?php
namespace App\Model;
use \App\Root\Database;

class Model
{
	private static $pdo = null;

	protected static function db() {
		if (self::$pdo == null) {
			$options = require $_SESSION['racine'] .'boot/dbo.php';
			self::$pdo = new Database($options);
		}
		return self::$pdo;
	}
}
