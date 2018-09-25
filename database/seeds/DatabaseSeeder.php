<?php

use App\Action;
use App\Category;
use App\Course;
use App\Student;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // To prevent errors we deactivate foreign keys check
      DB::statement('SET FOREIGN_KEY_CHECKS = 0');
      // We clean the tables
      Action::truncate();
      Category::truncate();
      Course::tuncate();
      Student::turncate();
      User::truncate();
      DB::table('category_course');

      $numberUsers      = 10;
      $numberCategories = 20;
      $numberCourses    = 30;
      $numberActions    = 100;

      factory(User::class,  $numberUsers)->create();
      factory(Category::class,  $numberCategories)->create();
      factory(Course::class,  $numberCourses)->create()->each(
        function ($course) {
          $categories = Category::all()->random(mt_rand(1,5))->pluck('id');
          $course->categories()->attach($categories);
        }
      );

      factory(Action::class,  $numberActions)->create();
    }
}
