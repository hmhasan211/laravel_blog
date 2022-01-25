<?php

namespace App\Http\Controllers\Author;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::User();
        $posts = $user->posts;
        $popular_posts = $user->posts()
            ->withCount('comments')
            ->withCount('favourite_to_users')
            ->orderBy('view_count','desc')
            ->orderBy('comments_count')
            ->orderBy('favourite_to_users_count')
            ->take(5)->get();
        $favorite_posts = $user->favourite_posts();
        $pending_posts = $posts->where('is_approved', false )->count();
        $all_views = $posts->sum('view_count');
        return view('author.dashboard',compact('posts','popular_posts','favorite_posts','pending_posts','all_views'));
    }
}
