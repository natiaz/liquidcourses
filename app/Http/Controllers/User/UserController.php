<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $users = User::all();

      return response()->json(['data' => $users], 200);
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

      return response()->json(['data' => $user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $user = User::findOrFail($id);

      return response()->json(['data' => $user], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $user   = User::findOrfail($id);
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
          return response()->json(['error' => 'Sólo los usuarios verificados pueden cambiar el valor admin', 'code' => '409'], 409);
        }

        $user->admin = $request->admin;
      }

      if(!$user->isDirty())
      {
        return response()->json(['error' => 'Se debe especificar al menos algún valor diferente', 'code' => '422'], 422);
      }

      $user->save();

      return response()->json(['data' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user   = User::findOrfail($id);

      $user->delete();

      return response()->json(['data' => $user], 200);
    }
}
