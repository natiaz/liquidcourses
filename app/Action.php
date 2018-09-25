<?php

namespace App;

use App\Student;
use App\Course;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
  protected $fillable = ['name', 'student_id', 'course_id'];

  public function student()
  {
    return $this->belongsTo(Student::class);
  }

  public function course()
  {
    return $this->belongsTo(Course::class);
  }
}
