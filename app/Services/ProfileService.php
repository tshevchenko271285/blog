<?php
namespace App\Services;

use App\Repositories\Contracts\IAttachmentRepo;
use App\Repositories\Contracts\IProfileRepo;
use App\Services\Contracts\IProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileService implements IProfileService {
    /**
     * @var IProfileRepo
     */
    protected $profileRepo;

    /**
     * @var IAttachmentRepo
     */
    protected $attachmentRepo;

    /**
     * ProfileService constructor.
     * @param IProfileRepo $profileRepo
     * @param IAttachmentRepo $attachmentRepo
     */
    public function __construct(IProfileRepo $profileRepo, IAttachmentRepo $attachmentRepo)
    {
        $this->profileRepo = $profileRepo;
        $this->attachmentRepo = $attachmentRepo;
    }

    /**
     * @return mixed
     */
    public function getCurrentUser()
    {
        return $this->profileRepo->getForUserId( Auth::id() );
    }

    /**
     * @param Request $request
     */
    public function update(Request $request)
    {
        $user_data = [
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
            $attachment = $this->attachmentRepo->create($path);
            $user_data['avatar_id'] = $attachment->id;
        }

        $this->profileRepo->update(Auth::id(), $user_data);
    }
}
