<?php

namespace App;

use App\Student;
use App\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{
  use SoftDeletes;

  protected $fillable = ['name', 'student_id', 'course_id'];
  protected $dates = ['deleted_at'];

  public function student()
  {
    return $this->belongsTo(Student::class);
  }

  public function course()
  {
    return $this->belongsTo(Course::class);
  }
}
