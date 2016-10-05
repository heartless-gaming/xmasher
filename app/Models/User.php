<?php

/**
*
*/
namespace Xmasher\Models;

use \Illuminate\Database\Eloquent\Model;

class User extends Model
{
  // Eloquent Model class finds the database by himself (plural of User)
  // protected $table = 'users';

  // Writable column list
  protected $fillable = ['name', 'mail', 'password'];
}
