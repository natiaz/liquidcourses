<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $users = User::all();

      return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $rules = [
        'name'    => 'required',
        'email'   => 'required|email|unique:users',
        'password'=> 'required|min:6|confirmed'
      ];

      $this->validate($request, $rules);

      $fields = $request->all();
      $fields['verified']           = User::USER_NOT_VERIFIED;
      $fields['verification_token'] = User::generateVerificationToken();
      $fields['admin']              = User::USER_REGULAR;
      $fields['password']           = bcrypt($request->password);

      $user   = User::create($fields);

      return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
      return $this->showOne($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
      $rules  = [
        'email'   => 'email|unique:users,email,'.$user->id,
        'password'=> 'min:6|confirmed',
        'admin'   => 'in:'.User::USER_ADMIN.','.User::USER_REGULAR,
      ];

      $this->validate($request, $rules);

      if($request->has('name'))
      {
        $user->name = $request->name;
      }

      if($request->has('email') && $user->email != $request->email)
      {
        $user->verified           = User::USER_NOT_VERIFIED;
        $user->verification_token = User::generateVerificationToken();
        $user->email              = $request->email;
      }

      if($request->has('password'))
      {
        $user->password = bcrypt($request->password);
      }

      if($request->has('admin'))
      {
        if(!$user->isVerified())
        {
          return $this->errorResponse('Sólo los usuarios verificados pueden cambiar el valor admin', 409);
        }

        $user->admin = $request->admin;
      }

      if(!$user->isDirty())
      {
        return $this->errorResponse('Se debe especificar al menos algún valor diferente', 422);
      }

      $user->save();

      return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
      $user->delete();

      return $this->showOne($user);
    }
}
