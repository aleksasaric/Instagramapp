<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ProfileRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            'password'     => $request->input('password'),
            'is_private'   => $request->input('is_private'),
            'old_password' => $request->input('oldPassword'),
        ];
        

        $profile = $this->profile->insertOrUpdate($data, $data['id']);

        if (!$profile){
           return $this->respondWithError();
        }

        return $this->respondCreated($profile);
        
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

        return $this->respondCreated('Successfully following');
    }

}
