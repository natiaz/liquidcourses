<?php

namespace App;

use App\Action;

class Student extends User
{
  /*
   * Returns a relation to the Action model, is a many relation
   */
  public function actions()
  {
    return $this->hasMany(Action::class);
  }
}
