<?php
/**
*
*/
namespace Xmasher\Controllers\Auth;

use Xmasher\Models\User;
use Xmasher\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller
{

  public function getSignUp($request, $response) {
    return $this->view->render($response, 'auth/signup.twig');
  }

  public function postSignUp($request, $response) {
    $validation = $this->validator->validate($request, [
      'mail' => v::noWhitespace()->notEmpty(),
      'name' => v::notEmpty()->alpha(),
      'password' => v::noWhitespace()->notEmpty()
    ]);

    if ($validation->failed()) {
      return $response->withRedirect($this->router->pathFor('auth.signup'));
    }

    User::create([
      'mail' => $request->getParam('mail'),
      'name' => $request->getParam('name'),
      'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT)
    ]);

    return $response->withRedirect($this->router->pathFor('home'));
  }
}
