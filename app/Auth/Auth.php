<?php

namespace Xmasher\Auth;

use Xmasher\Models\User;

class Auth
{

  public function user()
  {
    if (isset($_SESSION['user'])) {
      return User::find($_SESSION['user']);
    }
  }

  public function check()
  {
    return isset($_SESSION['user']);
  }

  public function attempt($email, $password)
  {
    $user = User::where('mail', $email)->first();

    if (!$user) {
      return false;
    }

    if (password_verify($password, $user->password)) {
      $_SESSION['user'] = $user->id;
      return true;
    }
  }

  public function logout()
  {
    unset($_SESSION['user']);
  }
}
