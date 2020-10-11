<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ProfileRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Mail\NewFriend;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProfileController extends ApiController
{

    /**
     * @var ProfileRepositoryInterface
     */
    private $profile;

    public function __construct(ProfileRepositoryInterface $profile)
    {

        $this->profile = $profile;
    }

    public function update(Request $request)
    {
        $data = [
            'id'           => $request->input('id'),
            'bio'          => $request->input('bio'),
            'name'         => $request->input('name'),
            'email'        => $request->input('email'),
            'image'        => $request->input('image'),
            'gender'       => $request->input('gender'),
            'user_id'      => $request->input('user_id'),
            'website'      => $request->input('website'),
            'username'     => $request->input('username'),
            'is_private'   => $request->input('privateAccount'),
            'password'     => $request->input('password'),
            'old_password' => $request->input('oldPassword'),
            'confirm_password' => $request->input('confirmPassword'),
        ];

        $profile = $this->profile->getById($data['id']);
        $authUser = $profile->user;


        if ($data['password']) {
            if (!$this->checkForPassword($data, $authUser)) return $this->respondWithError('Wrong password');
            if ($data['password'] !== $data['confirm_password']) return $this->respondWithError('Password are not matching');

            $authUser->password = bcrypt($data['password']);
            $authUser->save();
        }

        $profile = $this->profile->insertOrUpdate($data, $data['id']);

        if (!$profile){
           return $this->respondWithError();
        }

        return $this->respondCreated($profile);
        
    }

    private function checkForPassword($data, $authUser){

            if (!Hash::check($data['old_password'], $authUser->password)){
                return false;
            }
            return true;
    }

    public function follows(Request $request)
    {
        $data = [
            'profile_id' => $request->input('profile_id'),
            'friend_id' => $request->input('friend_id')
        ];

        $profile = $this->profile->getById($data['profile_id']);

        $alreadyFollows = $profile->friends()->where('friend_id', $data['friend_id'])->count() > 0 ? true : false;

        return $this->respondCreated('Successful retreave', $alreadyFollows);

    }

    public function toggleFollows(Request $request)
    {
        $data = [
            'profile_id' => $request->input('profile_id'),
            'friend_id' => $request->input('friend_id')
        ];

        $profile = $this->profile->getById($data['profile_id']);
        $profile->friends()->toggle($data['friend_id']);
        $friend = $this->profile->getById($data['friend_id']);



        Mail::to($friend->email)->send(new NewFriend($profile, $friend));

//        new Mail(NewFriend::class);
        return $this->respondCreated('Successfully following');
    }

}
