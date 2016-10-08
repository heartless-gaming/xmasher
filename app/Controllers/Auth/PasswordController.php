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

  }
}
