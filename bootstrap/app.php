<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$user = new \Xmasher\Models\User;

$app = new \Slim\App([
  // Slim config
  'settings' => [
    'displayErrorDetails' => true,
  ]
]);

$container = $app->getContainer();

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

$container['HomeController'] = function ($container) {
  return new \Xmasher\Controllers\HomeController($container);
};

require __DIR__ . '/../app/routes.php';
