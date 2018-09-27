<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\ApiController;
use App\Student;
use Illuminate\Http\Request;

class StudentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // Only the users with actions are students
      $students = Student::has('actions')->get();

      return $this->showAll($students);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
      return $this->showOne($student);
    }

}
