<?php

$app->setRoute('/user/login', 'user.login', 'LoginController::LoginAction');
$app->setRoute('/user/auth', 'user.auth', 'LoginController::AuthAction')->Guardian('AdminGuard');
$app->setRoute('/user/logout', 'user.logout', 'LoginController::LogoutAction')->Guardian('AdminGuard');
