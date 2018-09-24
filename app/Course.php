<?php

namespace App;

use App\Category;
use App\Action;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
  const COURSE_OPEN = 'open';
  const COURSE_CLOSE = 'close';

  protected $fillable = ['name', 'description', 'maximum', 'status'];

  public function isOpen()
  {
    return $this->status == Course::COURSE_OPEN;
  }

  public function actions()
  {
    return $this->hasMany(Action::class);
  }

  public function categories()
  {
    return $this->belongsToMany(Category::class);
  }
}
