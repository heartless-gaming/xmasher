<?php

namespace Xmasher\Middleware;

class ValidationErrorsMiddleware extends Middleware
{
  public function __invoke($request, $response, $next)
  {
    var_dump($_SESSION['kek']);
    $this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
    unset($_SESSION['errors']);

    $response = $next($request, $response);
    return $response;
  }
}
