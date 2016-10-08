<?php

namespace Xmasher\Middleware;

class GuestMiddleware extends Middleware
{
  public function __invoke($request, $response, $next)
  {
    if ($this->container->auth->check()) {
      // User already signed redirecting so redirecting to homepage.
      return $response->withRedirect($this->container->router->pathFor('home'));
    }

    return $next($request, $response);
  }
}
