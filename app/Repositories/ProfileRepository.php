<?php
/**
 * Created by PhpStorm.
 * User: Aleksa
 * Date: 2020-04-28
 * Time: 00:15
 */
namespace App\Repositories;

use App\Contracts\ProfileRepositoryInterface;
use App\Profile;

class ProfileRepository implements ProfileRepositoryInterface{

    /**
     * @var Profile
     */
    private $profile;

    public function __construct(Profile $profile)
    {

        $this->profile = $profile;
    }

    public function getById($id)
    {
        return $this->profile->find($id);
    }

    public function getByUsername($username)
    {
        return $this->profile->where('username', $username)->with('posts')->first();
    }

    public function insertOrUpdate($data, $id = null)
    {
        $profile = $id ? $this->getById($id) : $this->profile;
        $profile  = $this->fillProfileObject($profile, $data);
        return $profile->save() ? $profile : false;
    }

    private function fillProfileObject($object, array $data){

        if (isset($data['name'])){
            $object->name = $data['name'];
        }
        if (isset($data['username'])){
            $object->username = $data['username'];
        }
        if (isset($data['image'])){
            $object->image = $data['image'];
        }
        if (isset($data['website'])){
            $object->website = $data['website'];
        }
        if (isset($data['bio'])){
            $object->bio = $data['bio'];
        }
        if (isset($data['email'])){
            $object->email = $data['email'];
        }
        if (isset($data['gender'])){
            $object->gender = $data['gender'];
        }
        if (isset($data['password'])){
            $object->password = $data['password'];
        }
        if (isset($data['isPrivate'])){
            $object->is_private = $data['isPrivate'];
        }
        if (isset($data['user_id'])){
            $object->user_id = $data['user_id'];
        }

        return $object;
    }
}