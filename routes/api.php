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

/**
 * Courses
 */

Route::resource('courses', 'Course\CourseController', ['only' => ['index', 'show']]);

/**
 * Actions
 */

Route::resource('actions', 'Action\ActionController', ['only' => ['index', 'show']]);
Route::resource('actions.categories', 'Action\ActionCategoryController', ['only' => ['index']]);

/**
 * Users
 */

Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);