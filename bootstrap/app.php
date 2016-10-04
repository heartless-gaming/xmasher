<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

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

require __DIR__ . '/../app/routes.php';
