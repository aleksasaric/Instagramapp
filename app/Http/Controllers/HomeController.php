<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::whereHas('profile', function($query){
            $query->where('id', '!=', Auth::user()->profile->id);
        })->orderByDesc('created_at')->with('profile')->get();

        $posts = PostResource::collection($posts);

        return view('home', compact('posts'));
    }
}
