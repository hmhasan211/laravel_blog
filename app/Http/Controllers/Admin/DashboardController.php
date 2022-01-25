<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Post;
use App\Tag;
use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        $popular_posts = Post::withCount('comments')
                            ->withCount('favourite_to_users')
                            ->orderBy('view_count','desc')
                            ->orderBy('comments_count','desc')
                            ->orderBy('favourite_to_users_count','desc')
                            ->take(5)->get();
         $pending_posts = Post::where('is_approved',false)->count();
         $total_authors = User::where('role_id',2)->count();
         $total_view = Post::sum('view_count');

          //Author() is a scrope from User model
         $new_authors_perDay = User::Authors()->whereDate('created_at',Carbon::today())->count();

         $active_users = User::Authors()
                        ->withcount('posts')
                        ->withcount('comment')
                        ->withcount('favourite_posts')
                        ->orderBy('posts_count','desc')
                        ->orderBy('comment_count','desc')
                        ->orderBy('favourite_posts_count','desc')
                        ->take(10)->get();
        $total_category = Category::all()->count();
        $total_tags     = Tag::all()->count();
        return view('admin.dashboard',compact('posts','popular_posts',
            'pending_posts','total_authors','total_view','new_authors_perDay',
            'active_users','total_category','total_tags'));
    }
}
