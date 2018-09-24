<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
  protected $fillable = ['student_id', 'course_id'];
}
