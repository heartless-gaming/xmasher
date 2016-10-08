<?php

$app->get('/', 'HomeController:index')->setName('home');

$app->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
$app->post('/auth/signup', 'AuthController:postSignUp');

$app->get('/auth/signin', 'AuthController:getSignin')->setName('auth.signin');
$app->post('/auth/signin', 'AuthController:postSignin');

$app->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');

$app->get('/account', 'PasswordController:getChangePassword')->setName('account');
$app->post('/account', 'PasswordController:postChangePassword');

