<?php

$app->get('/kek', function ($request, $response) {
  return $this->view->render($response, 'home.twig');
});

