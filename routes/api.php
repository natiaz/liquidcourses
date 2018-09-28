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

/**
 * Users
 */

Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);