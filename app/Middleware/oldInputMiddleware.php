<?php

namespace Xmasher\Middleware;

class oldInputMiddleware extends Middleware
{
  public function __invoke($request, $response, $next)
  {
    $this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);
    $_SESSION['old'] = $request->getParams();

    $response = $next($request, $response);
    return $response;
  }
}
