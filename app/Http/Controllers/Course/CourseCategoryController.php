<?php

namespace App\Http\Controllers\Course;

use App\Category;
use App\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CourseCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Course $course)
    {
      $categories = $course->categories;

      return $this->showAll($categories);
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, Course $course, Category $category)
    {
      $course->categories()->syncWithoutDetaching([$category->id]);

      return $this->showAll($course->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course, Category $category)
    {
      // Verify if the course has this category associated
      if(!$course->categories()->find($category->id))
      {
        return $this->errorResponse('La categoría especificada no es una categoría de este curso', 404);
      }
      else
      {
        $course->categories()->detach([$category->id]);
        return $this->showAll($course->categories);
      }
    }
}
