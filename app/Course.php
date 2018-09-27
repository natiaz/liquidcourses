<?php

namespace App;

use App\Category;
use App\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
  use SoftDeletes;

  const COURSE_OPEN = 'open';
  const COURSE_CLOSE = 'close';

  protected $fillable = ['name', 'description', 'maximum', 'status'];
  protected $dates = ['deleted_at'];

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
