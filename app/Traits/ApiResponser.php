<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

trait ApiResponser
{
  private function successResponse($data, $code)
  {
    return response()->json($data, $code);
  }

  protected function errorResponse($message, $code)
  {
    return response()->json(['error' => $message, 'code' => $code], $code);
  }

  protected function showAll(Collection $collection, $code = 200)
  {
    $collection = $this->filterData($collection);
    $collection = $this->sortData($collection);
    $collection = $this->paginate($collection);
    return $this->successResponse(['data' => $collection], $code);
  }

  protected function showOne(Model $instance, $code = 200)
  {
    return $this->successResponse(['data' => $instance], $code);
  }

  protected function showMessage($message, $code = 200)
  {
    return $this->successResponse(['data' => $message], $code);
  }

  protected function sortData(Collection $collection)
  {
    if(request()->has('sort_by'))
    {
      $attribute = request()->sort_by;

      $collection = $collection->sortBy->{$attribute};
    }
    return $collection;
  }

  protected function paginate(Collection $collection)
  {
    $rules = [ 'per_page' => 'integer|min:2|max:50' ];



    $page     = LengthAwarePaginator::resolveCurrentPage();
    $perPage  = 15;

    if(request()->has('per_page'))
    {
      $perPage  = (int) request()->per_page;
    }

    $results  = $collection->slice(($page - 1) * $perPage, $perPage);

    $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page,['path' => LengthAwarePaginator::resolveCurrentPath()]);
    $paginated->appends(request()->all());

    return $paginated;
  }

  protected function filterData(Collection $collection)
  {
    foreach(request()->query() as $attribute => $value)
    {
      if(isset($attribute, $value))
      {
        $collection = $collection->where($attribute, $value);
      }
    }

    return $collection;
  }
}