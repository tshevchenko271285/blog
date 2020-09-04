<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfile;
use App\Services\Contracts\IProfileService;

class ProfileController extends Controller
{

    protected $profileService;

    public function __construct(IProfileService $profileService)
    {
        $this->middleware('auth');
        $this->profileService = $profileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->profileService->getCurrentUser();
        return view('profile', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfile $request)
    {
        $this->profileService->update($request);
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
