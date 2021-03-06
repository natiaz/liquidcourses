<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Students
 */

Route::resource('students', 'Student\StudentController', ['only' => ['index', 'show']]);
Route::resource('students.actions', 'Student\StudentActionController', ['only' => ['index']]);
Route::resource('students.courses', 'Student\StudentCourseController', ['only' => ['index']]);
Route::resource('students.categories', 'Student\StudentCategoryController', ['only' => ['index']]);

/**
 * Categories
 */
// To Do admins will be able to create & edit categories
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
Route::resource('categories.courses', 'Category\CategoryCourseController', ['only' => ['index']]);
Route::resource('categories.actions', 'Category\CategoryActionController', ['only' => ['index']]);
Route::resource('categories.students', 'Category\CategoryStudentController', ['only' => ['index']]);

/**
 * Courses
 */

Route::resource('courses', 'Course\CourseController', ['only' => ['index', 'show']]);
Route::resource('courses.actions', 'Course\CourseActionController', ['only' => ['index']]);
Route::resource('courses.students', 'Course\CourseStudentController', ['only' => ['index']]);
Route::resource('courses.students.actions', 'Course\CourseStudentActionController', ['only' => ['store']]);
Route::resource('courses.categories', 'Course\CourseCategoryController', ['only' => ['index', 'update', 'destroy']]);


/**
 * Actions
 */

Route::resource('actions', 'Action\ActionController', ['only' => ['index', 'show']]);
Route::resource('actions.categories', 'Action\ActionCategoryController', ['only' => ['index']]);

/**
 * Users
 */

Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');