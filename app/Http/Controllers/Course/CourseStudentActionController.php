<?php

namespace App\Http\Controllers\Course;

use App\Course;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CourseStudentActionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Course $course, User $student)
    {
      if(!$student->isVerified())
      {
        return $this->errorResponse('El estudiante debe ser un usuario verificado', 409);
      }

      if(!$course->isOpen())
      {
        return $this->errorResponse('El curso no está disponible', 409);
      }

      // Control the total number of students in the course
      $totalStudents = $course->actions()
        ->with('student')
        ->get()
        ->pluck('student')
        ->unique('id')
        ->count();

        if($totalStudents < $course->maximum)
        {
          dd('Se podría añadir');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }
}
