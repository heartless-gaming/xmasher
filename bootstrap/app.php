<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
  // Slim config
  'settings' => [
    'displayErrorDetails' => true,
  ]
]);

$app->get('/', function ($request, $response) {
  return 'Hello There !';
});

