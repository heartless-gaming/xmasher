<?php

namespace Xmasher\Controllers\Auth;

use Xmasher\Models\User;
use Xmasher\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller
{
  public function getSignOut($request, $response)
  {
    $this->auth->logout();

    return $response->withRedirect($this->router->pathFor('home'));
  }

  public function getSignIn($request, $response)
  {
    return $this->view->render($response, 'auth/signin.twig');
  }

  public function postSignIn($request, $response)
  {
    $auth = $this->auth->attempt(
      $request->getParam('mail'),
      $request->getParam('password')
    );

    if (!$auth) {
      return $response->withRedirect($this->router->pathFor('auth.signin'));
    }

    $this->flash->addMessage('info', 'Vous etes maintenant connecter');

    return $response->withRedirect($this->router->pathFor('home'));
  }

  public function getSignUp($request, $response)
  {
    return $this->view->render($response, 'auth/signup.twig');
  }

  public function postSignUp($request, $response)
  {
    $validation = $this->validator->validate($request, [
      'mail' => v::noWhitespace()->notEmpty()->email()->emailAvailaible(),
      'name' => v::notEmpty()->alpha(),
      'password' => v::noWhitespace()->notEmpty()
    ]);

    if ($validation->failed()) {
      return $response->withRedirect($this->router->pathFor('auth.signup'));
    }

    $user = User::create([
      'mail' => $request->getParam('mail'),
      'name' => $request->getParam('name'),
      'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT)
    ]);

    $this->flash->addMessage('info', 'Votre compte Xmasher est maintenant créer');

    // Log the user to his accont after the creation.
    $this->auth->attempt($user->mail, $request->getParam('password'));

    return $response->withRedirect($this->router->pathFor('home'));
  }
}
