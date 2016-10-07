<?php

use Respect\Validation\Validator as v;

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
  // Slim config
  'settings' => [
    'displayErrorDetails' => true,
    'db' => [
      'driver' => 'mysql',
      'host' => '127.0.0.1',
      'database' => 'xmasher',
      'username' => 'skullmasher',
      'password' => '',
      'charset' => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix' => ''
    ]
  ]
]);

$container = $app->getContainer();

// Starting Database
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($c) use ($capsule) {
  return $capsule;
};

// Adding app container
$container['view'] = function ($c) {
  // Adding twig templating engine to view container
  $view = new \Slim\Views\Twig(__DIR__ . '/../ressources/views', [
    'cache' => false
  ]);

  $view->addExtension(new \Slim\Views\TwigExtension(
    $c->router,
    $c->request->getUri()
  ));

  return $view;
};

$container['validator'] = function ($c) {
  return new \Xmasher\Validation\Validator;
};

$container['HomeController'] = function ($c) {
  return new \Xmasher\Controllers\HomeController($c);
};

$container['AuthController'] = function ($c) {
  return new \Xmasher\Controllers\Auth\AuthController($c);
};

$container['csrf'] = function ($c) {
  return new \Slim\Csrf\Guard;
};

$container['auth'] = function ($c) {
  return new \Xmasher\Auth\Auth;
};

// Adding Middlewares
$app->add(new \Xmasher\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \Xmasher\Middleware\oldInputMiddleware($container));
$app->add(new \Xmasher\Middleware\CsrfViewMiddleware($container));
$app->add($container->get('csrf'));

// Adding custom form  validation rules
v::with('Xmasher\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';
