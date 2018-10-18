<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
  use Notifiable, HasApiTokens, SoftDeletes;

  const USER_VERIFIED = '1';
  const USER_NOT_VERIFIED = '0';

  const USER_ADMIN = 'true';
  const USER_REGULAR = 'false';

  // To fix error on legacy models seed
  protected $table = 'users';
  protected $dates = ['deleted_at'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'email', 'password','verified','verification_token','admin'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'password', 'remember_token', 'verification_token'
  ];

  public function isVerified()
  {
    return $this->verified == User::USER_VERIFIED;
  }

  public function isAdmin()
  {
    return $this->admin == User::USER_ADMIN;
  }

  public static function generateVerificationToken()
  {
    return str_random(40);
  }
}
