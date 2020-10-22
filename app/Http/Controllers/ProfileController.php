<?php

namespace App\Http\Controllers;

use App\Contracts\ProfileRepositoryInterface;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    /**
     * @var ProfileRepositoryInterface
     */
    private $profile;

    public function __construct(ProfileRepositoryInterface $profile)
    {
        $this->profile = $profile;
    }

    public function show($username)
    {
        $profile = $this->profile->getByUsername($username);
        if (!$profile) abort(404);
            $authProfile = Auth::user()->profile;
        return view('profile.index', compact('profile', 'authProfile'));
    }

    public function edit(Profile $profile)
    {
        $profile = Auth::user()->profile;
        return view('profile.edit', compact('profile'));
    }
}
