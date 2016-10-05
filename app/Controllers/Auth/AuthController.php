<?php
/**
*
*/
namespace Xmasher\Controllers\Auth;

use Xmasher\Controllers\Controller;

class AuthController extends Controller
{

  public function getSignUp($request, $response) {
    return $this->view->render($response, 'auth/signup.twig');
  }

  public function postSignUp($request, $response) {
    var_dump($request->getParams());
  }
}
