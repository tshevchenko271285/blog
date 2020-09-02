<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with('avatar')->find( Auth::id() );
//        dd($user);
        return view('profile', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user_id]
        ];
        if( $request->input('password') ) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }
        if( $request->file('avatar') ) {
            $rules['avatar'] = ['image'];
        }
        $request->validate($rules);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->lastname = $request->input('lastname');
        $user->firstname = $request->input('firstname');
        $user->password = Hash::make($request->input('password'));
        if( $request->file('avatar') ) {
            $path = $request->file('avatar')->store('public/avatars');
            $attachment = new Attachment(['path' => $path]);
            $attachment->save();
            $user->avatar_id = $attachment->id;
        }

        $user->save();
        return redirect()->route('profile.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
