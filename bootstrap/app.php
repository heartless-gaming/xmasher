<?php

use Respect\Validation\Validator as v;

session_start();

require __DIR__ . '/../vendor/autoload.php';

/**
 * Slim framework & App settings container
 */
require __DIR__ . '/settings.php'; // settings.php.exemple

$app = new \Slim\App($app_settings);

$container = $app->getContainer();

// Starting Database
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($c) use ($capsule) {
  return $capsule;
};

$container['auth'] = function ($c) {
  return new \Xmasher\Auth\Auth;
};

$container['flash'] = function ($c) {
  return new \Slim\Flash\Messages;
};

$container['view'] = function ($c) {
  // Adding twig templating engine to view container
  $view = new \Slim\Views\Twig(__DIR__ . '/../ressources/views', [
    'cache' => false
  ]);

  $view->addExtension(new \Slim\Views\TwigExtension(
    $c->router,
    $c->request->getUri()
  ));

  // Making some class and variable available in the templates.
  $view->getEnvironment()->addGlobal('auth', [
    'check' => $c->auth->check(),
    'user' => $c->auth->user(),
  ]);

  $request_scheme = $_SERVER['REQUEST_SCHEME']; // returns http or https
  $app_url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
  $storage_foldername = $c['settings']['image']['storage_foldername'];
  $storage_folder_link = $app_url . $storage_foldername;

  $view->getEnvironment()->addGlobal('request_scheme', $request_scheme);
  $view->getEnvironment()->addGlobal('storage_folder_link', $storage_folder_link);
  $view->getEnvironment()->addGlobal('flash', $c->flash);

  return $view;
};

$container['validator'] = function ($c) {
  return new \Xmasher\Validation\Validator;
};

$container['HomeController'] = function ($c) {
  return new \Xmasher\Controllers\HomeController($c);
};

$container['UploadController'] = function ($c) {
  return new \Xmasher\Controllers\UploadController($c);
};

$container['AuthController'] = function ($c) {
  return new \Xmasher\Controllers\Auth\AuthController($c);
};

$container['PasswordController'] = function ($c) {
  return new \Xmasher\Controllers\Auth\PasswordController($c);
};

$container['csrf'] = function ($c) {
  return new \Slim\Csrf\Guard;
};


// Adding app level Middlewares
$app->add(new \Xmasher\Middleware\ValidationErrorsMiddleware($container));
// $app->add(new \Xmasher\Middleware\oldInputMiddleware($container));
$app->add(new \Xmasher\Middleware\CsrfViewMiddleware($container));
$app->add($container->get('csrf'));

// Adding custom form validation rules
v::with('Xmasher\\Validation\\Rules\\');

// App routes
require __DIR__ . '/../app/routes.php';
