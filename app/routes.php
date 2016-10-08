<?php

use Xmasher\Middleware\AuthMiddleware;

$app->get('/', 'HomeController:index')->setName('home');

$app->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
$app->post('/auth/signup', 'AuthController:postSignUp');

$app->get('/auth/signin', 'AuthController:getSignin')->setName('auth.signin');
$app->post('/auth/signin', 'AuthController:postSignin');

$app->group('', function () {
  $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');

  $this->get('/account', 'PasswordController:getChangePassword')->setName('account');
  $this->post('/account', 'PasswordController:postChangePassword');
})->add(new AuthMiddleware($container));


