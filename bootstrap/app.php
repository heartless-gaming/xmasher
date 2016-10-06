<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$user = new \Xmasher\Models\User;

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

$capsule = new \Illuminate\Database\Capsule\Manager;

$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
  return $capsule;
};

$container['view'] = function ($container) {
  $view = new \Slim\Views\Twig(__DIR__ . '/../ressources/views', [
    'cache' => false
  ]);

  $view->addExtension(new \Slim\Views\TwigExtension(
    $container->router,
    $container->request->getUri()
  ));

  return $view;
};

$container['validator'] = function ($container) {
  return new \Xmasher\Validation\Validator;
};

$container['HomeController'] = function ($container) {
  return new \Xmasher\Controllers\HomeController($container);
};

$container['AuthController'] = function ($container) {
  return new \Xmasher\Controllers\Auth\AuthController($container);
};

require __DIR__ . '/../app/routes.php';
