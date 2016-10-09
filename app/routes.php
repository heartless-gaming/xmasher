<?php

use Xmasher\Middleware\AuthMiddleware;
use Xmasher\Middleware\GuestMiddleware;

$app->get('/', 'HomeController:index')->setName('home');

$app->get('/upload', 'UploadController:getUpload')->setName('upload');
$app->post('/upload', 'UploadController:postUpload');

$app->group('', function () {
  $this->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
  $this->post('/auth/signup', 'AuthController:postSignUp');

  $this->get('/auth/signin', 'AuthController:getSignin')->setName('auth.signin');
  $this->post('/auth/signin', 'AuthController:postSignin');
})->add(new GuestMiddleware($container));

$app->group('', function () {
  $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');

  $this->get('/account', 'PasswordController:getChangePassword')->setName('account');
  $this->post('/account', 'PasswordController:postChangePassword');
})->add(new AuthMiddleware($container));
