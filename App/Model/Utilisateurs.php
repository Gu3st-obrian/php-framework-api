<?php
namespace App\Model;

class Utilisateurs extends Model
{
	public static function Connexion($username, $password) {
		return self::db()->select('utilisateurs', "*", ['username' => $username, 'password' => $password]);
	}
}
