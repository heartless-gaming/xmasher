<?php

namespace Xmasher\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

/**
*
*/
class EmailAvailaibleException extends ValidationException
{

  public static $defaultTemplates = [
    self::MODE_DEFAULT => [
      self::STANDARD => 'Cette adresse mail est déjà utilisée.'
    ]
  ];
}
