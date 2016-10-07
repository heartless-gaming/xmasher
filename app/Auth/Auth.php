<?php

namespace Xmasher\Auth;

use Xmasher\Models\User;

class Auth
{
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
}
