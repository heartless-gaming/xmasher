<?php

namespace Xmasher\Validation\Rules;

use \Xmasher\Models\User;
use Respect\Validation\Rules\AbstractRule;

class MatchesPassword extends AbstractRule
{
  protected $password;

  function __construct($password)
  {
    $this->password = $password;
  }
  public function validate($input)
  {
    return password_verify($input, $this->password);
  }
}
