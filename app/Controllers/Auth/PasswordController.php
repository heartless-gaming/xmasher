<?php

namespace Xmasher\Controllers\Auth;

use Xmasher\Models\User;
use Xmasher\Controllers\Controller;
use Respect\Validation\Validator as v;

class PasswordController extends Controller
{
  public function getChangePassword($request, $response)
  {
    return $this->view->render($response, 'account/account.twig');
  }

  public function postChangePassword($request, $response)
  {
    $validation = $this->validator->validate($request, [
      'password_old' => v::notEmpty()->matchesPassword($this->auth->user()->password),
      'password' => v::notEmpty()
    ]);

    if ($validation->failed()) {
      return $response->withRedirect($this->router->pathFor('account'));
    }

    $this->auth->user()->setPassword($request->getParam('password'));
    $this->flash->addMessage('info', 'Le mot de passe a été changé');

    return $response->withRedirect($this->router->pathFor('account'));
  }
}
