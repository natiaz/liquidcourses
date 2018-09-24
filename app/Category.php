<?php

namespace App;

use App\Course;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $fillable = ['name', 'description'];

  public function courses()
  {
    return $this->belongsToMany(Course::class);
  }
}
