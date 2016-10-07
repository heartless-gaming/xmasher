<?php

namespace Xmasher\Validation\Rules;

use \Xmasher\Models\User;
use Respect\Validation\Rules\AbstractRule;

class EmailAvailaible extends AbstractRule
{

  public function validate($input)
  {
    return User::where('mail', $input)->count() === 0;
  }
}
