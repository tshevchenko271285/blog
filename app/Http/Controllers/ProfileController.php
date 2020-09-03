<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\IAttachmentRepo;
use App\Repositories\Contracts\IProfileRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $profile_repo;

    protected $attachment_repo;

    public function __construct(IProfileRepo $profile_repo, IAttachmentRepo $attachment_repo) {

        $this->middleware('auth');

        $this->profile_repo = $profile_repo;

        $this->attachment_repo = $attachment_repo;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = $this->profile_repo->getForUserId(Auth::id());

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

        $user_data = [
            'id' => $user_id,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'lastname' => $request->input('lastname'),
            'firstname' => $request->input('firstname'),
        ];

        if( $request->input('password') ) {
            $user_data['password'] = Hash::make($request->input('password'));
        }

        if( $request->file('avatar') ) {
            $path = $request->file('avatar')->store('public/avatars');
            $attachment = $this->attachment_repo->create($path);
            $user_data['avatar_id'] = $attachment->id;
        }

        $this->profile_repo->update($user_data);

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
