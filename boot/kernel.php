<?php session_start();

$_SESSION['radical'] = require 'url.php';
$_SESSION['crypto'] = require 'crypto.php';
$_SESSION['racine'] = dirname(__DIR__) . '/';
$_SESSION['vueRoot'] = $_SESSION['racine'] . 'resources/';

$url = (isset($_GET['p']) or empty($_GET['p'])) ? '/' : $_GET['p'];
unset($_GET['p']);

require 'autoloader.php';

$container['tools'] = function() {
	return new \App\Utilitaire\Tools();
};

$app = \App\Root\App($container, $url);

require 'routes.php';
?>