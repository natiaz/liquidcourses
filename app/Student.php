<?php

namespace App;

use App\Action;
use App\Scopes\StudentScope;

class Student extends User
{
  protected static function boot()
  {
    parent::boot();
    static::addGlobalScope(new StudentScope);
  }

  /*
   * Returns a relation to the Action model, is a many relation
   */
  public function actions()
  {
    return $this->hasMany(Action::class);
  }
}
